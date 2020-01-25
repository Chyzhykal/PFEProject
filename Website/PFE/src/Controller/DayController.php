<?php
/**
 * ETML
 * Author : Chyzhyk Aleh
 * Date : 16.01.2020
 * Description : Day controller - controls agenda, create, detail, modify and delete days for admin
 * NOTE : activity is the same thing as event, just different name
 */
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Entity\TDay;
use App\Form\DayForm;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\TEvent;
use Symfony\Component\Validator\Constraints\DateTime;
use App\EntityHelpers\EventHelper;

class DayController extends AbstractController
{

    private $session; // Session object

    /**
     * Constructor
     *
     * @param SessionInterface $session
     */
    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    /**
     * Agenda, displays days
     * @Route("/agenda", name="agenda")
     */
    public function index()
    {
        $this->updateDays();
        //Getting days from repository by date and time
        $entityManager = $this->getDoctrine()->getManager();
        $foundDays =$entityManager->getRepository(TDay::class)->findBy(array('daydeleted'=>false), array('daydate' => 'ASC', 'daybegintime'=>'ASC'));
        $date = new \DateTime();

        $days=array();
        //Displaying all days
        foreach($foundDays as $day){
            // put everything in an array because of date formatting
            $name=$day->getDayname();
            $date=$day->getDaydate()->format('d/m/Y');
            $beginTime=$day->getDaybegintime()->format('H\hi');
            $endTime=$day->getDayendtime()->format('H\hi');
            $description=$day->getDaydescription();
            $repeat=$day->getDayrepeat();
            $idDay=$day->getIdday();
            array_push($days, array('idDay'=>$idDay, 'description'=>$description, 'repeat'=>$repeat, 'name'=>$name, 'date'=>$date, 'beginTime'=>$beginTime, 'endTime'=>$endTime));
        }
            return $this->render('days/agenda.html.twig', [
                'days'=> $days,
                'errors'=>array()
            ]); 
    }

    /**
     * Updates days in database automatically 
     */
    private function updateDays(){
        // Getting all days from repository
        $entityManager = $this->getDoctrine()->getManager();
        $foundDays =$entityManager->getRepository(TDay::class)->findAll();
        // Looking for current date
        $date = new \DateTime();
        for($i=0;$i<count($foundDays); $i++){
            //If any day which must repeat each year has date less than today - 
            if($foundDays[$i]->getDaydate()<$date && $foundDays[$i]->getDayrepeat()==true){
                $entityManager = $this->getDoctrine()->getManager();
                $foundDay = $entityManager->getRepository(TDay::class)->find($foundDays[$i]->getIdday());
                // Symfony can't see modifications inside an object taken from database. 
                // It sees only Object ID (not the one from db, the one which is given by php, var_dump something to see example)
                // So needed to create another object based on string value of initial datetime instances
                $dateInit = $foundDay->getDaydate()->add(date_interval_create_from_date_string('1 year'));
                //If for example special day which must repeat each year was last modified on 2015, then it goes up to current year, so filter can accept it
                while($dateInit<$date){
                    $dateInit->add(date_interval_create_from_date_string('1 year'));
                }
                $newDateStr = $dateInit->format('d/m/Y:H:i:s');
                $newDate = date_create_from_format('d/m/Y:H:i:s', $newDateStr);
                $foundDay->setDaydate($newDate);
                $entityManager->flush();
            }
            //Filters all other days, does not delete it from the database, just sets deleted bool to true, so won't display
            elseif($foundDays[$i]->getDaydate()<$date && $foundDays[$i]->getDayrepeat()==false){
                $entityManager = $this->getDoctrine()->getManager();
                $foundDay = $entityManager->getRepository(TDay::class)->find($foundDays[$i]->getIdday());
                $foundDay->setDaydeleted(true);
                $entityManager->flush();
            }
        }
    }

    /**
     * Form controller for day creation s
     * @Route("/new-day", name="newday")
     */
    public function addDay(Request $request)
    {
        // Checks if user is logged in
        if(!($this->session->has('loggedin') && $this->session->get('loggedin')==true)){
            return $this->redirectToRoute('index');     
        }
            // Errors array for forms validation
            $errors=array();
            // Creatong form
            $day = new TDay();
            $form = $this->createForm(DayForm::class, $day);
            $form->handleRequest($request);

            // Form validation and database insert into database
            if ($form->isSubmitted() && $form->isValid()) {
                // getting data from form
                $inputDay = $form->getData(); 
                
                $repository = $this->getDoctrine()->getRepository(TDay::class);
                // look for a single day by name and date
                $foundDay = $repository->findOneBy(['dayname' => $inputDay->getDayname(), 'daydate' => $inputDay->getDayDate()]);
                // if day with same name and date already exists, then return an error
                if ($foundDay) {
                    array_push($errors, "Le jour avec le même nom et la date existe déja");
                    return $this->render('days/dayCreate.html.twig', [
                        'form' => $form->createView(),
                        'errors'=>$errors,
                    ]);
                }

                //Insert into db
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($inputDay);
                $entityManager->flush();
                $idDay = $inputDay->getIdday();
    
                // redirect to day details
                return $this->redirectToRoute('dayDetail',['idDay' => $idDay]);     
            }
            // return form
            return $this->render('days/dayCreate.html.twig', [
                'form' => $form->createView(),
                'errors'=>array(),
            ]);
    }


    /**
     * Deleting chosen day
     * @Route("/remove-day/{idDay}", methods={"GET"}, name="removeDay")
     * @param int $idDay
     */
    public function removeDay(int $idDay)
    {
        // continue if logged in
        if(!($this->session->has('loggedin') && $this->session->get('loggedin')==true)){
            return $this->redirectToRoute('index');     
        }
        // deleting day from db - setting deleted to true
        $entityManager = $this->getDoctrine()->getManager();
        $day = $entityManager->getRepository(TDay::class)->find($idDay);
        $day->setDaydeleted(true);
        $entityManager->flush();

        return $this->redirectToRoute('agenda');
    }

    /**
     * showing details - events and description of the chosen day, activities grid
     * @Route("/day-detail/{idDay}", methods={"GET"}, name="dayDetail")
     * @param int $idDay
     */
    public function showDay(int $idDay)
    {
        // Continue if logged in
        if(!($this->session->has('loggedin') && $this->session->get('loggedin')==true)){
            return $this->redirectToRoute('index');     
        }
        // Getting day based on id
        $repository = $this->getDoctrine()->getRepository(TDay::class);
        $day = $repository->findOneBy(['idday'=>$idDay]);

        // Moving day props to an array, needed only because of date and time formatting.
        // Not the best solution, can change it 
        $name=$day->getDayname();
        $date=$day->getDaydate()->format('d/m/Y');
        $beginTime=$day->getDaybegintime()->format('H\hi');
        $endTime=$day->getDayendtime()->format('H\hi');
        $description=$day->getDaydescription();
        $repeat=$day->getDayrepeat();
        $idDay=$day->getIdday();
        $foundDay=array('idDay'=>$idDay, 'description'=>$description, 'repeat'=>$repeat, 'name'=>$name, 'date'=>$date, 'beginTime'=>$beginTime, 'endTime'=>$endTime);

        // Getting event entities for given day
        $repository = $this->getDoctrine()->getRepository(TEvent::class);
        $eventEntities = $repository->findBy(['fkday'=>$idDay]);

        //Timetable used for grid display
        $timeTableBegin=array();
        $timeTableEnd=array();
        $usedTimes=array();
        foreach($eventEntities as $event){

            // Event entity object to array converter
            $convertedEvent = EventHelper::make_entity_transition_as_single($event);
            $convertedEvent['periodAmount']=(strtotime($convertedEvent['endTime']) - strtotime($convertedEvent['beginTime']))/900+1;
            // Adding begin time and end time to a global array for grid to know where to display time
            // Key is time, value is number of occurences
            if(!in_array($convertedEvent['beginTime'], $timeTableBegin)){
                $timeTableBegin[$convertedEvent['beginTime']]=array();
                array_push($timeTableBegin[$convertedEvent['beginTime']], $convertedEvent);
            }
            else{
                array_push($timeTableBegin[$convertedEvent['beginTime']], $convertedEvent);
            }
            if(!in_array($convertedEvent['endTime'], $timeTableEnd)){
                $timeTableEnd[$convertedEvent['endTime']]=array();
                $timeTableEnd[$convertedEvent['endTime']]=1;
            }
            else{
                $timeTableEnd[$convertedEvent['endTime']]+=1;
            }
            if(!in_array($convertedEvent['beginTime'], $usedTimes)){
                array_push($usedTimes, $convertedEvent['beginTime']);
            }
            if(!in_array($convertedEvent['endTime'], $usedTimes)){
                array_push($usedTimes, $convertedEvent['endTime']);
            }   
        }

        //Weird line, but needed to calculate number of maximum lines for the grid (15 min for each line) based on day timing
        //Do not touch if don't have a better solution
        // 900 is because 3600/4 (4 because it's 4 times 15 mins in one hour)
        // To be honest i have no idea how it works, but it works, so fine
        $maxLineAmount=(strtotime($day->getDayendtime()->format('H:i:00')) - strtotime($day->getDaybegintime()->format('H:i:00')))/900+1;
       
        // Calculation how many columns is needed to display a day
        $colAmount=0;
        $maxColAmount=$colAmount;
        $globalTable=array();
        // for each line look for number of activities in it
        for($i=0; $i<$maxLineAmount; $i++){
            // tmpTime is just used to make shorter "if" lines
            // stores time of current sequence - day begin time + sequence number of 15 mins
            // F.e. if day starts at 8h00 and actual sequence is 2h15 (9 times 15 minutes),
            // then actual sequence time will be 8h00+2h15 = 10h15
            $tmpTime=date("H\hi", strtotime($day->getDaybegintime()->format('H:i:00')) + $i*900);
            array_push($globalTable, $tmpTime);
            // If activity starts at sequence time, then increment column amount by number of activities started at that time
            if(array_key_exists($tmpTime,$timeTableBegin)){
                $colAmount+=count($timeTableBegin[$tmpTime]);
            }
            // Opposite if activities end at sequence time, decrement column amount
            if(array_key_exists($tmpTime,$timeTableEnd)){
                $colAmount-=$timeTableEnd[$tmpTime];
            }
            // if actual is bigger then max, then set max = actual
            if($colAmount>$maxColAmount){
                $maxColAmount=$colAmount;
            }
        }
        // grid style modifying - adding colums based on max amount of activities at the same time
        $gridAutoStyle=str_repeat("auto ", $maxColAmount);
        
        return $this->render('days/dayDetail.html.twig', [
            'day'=>$foundDay,
            'timeTableBegin'=>$timeTableBegin,
            'usedTimes'=>$usedTimes,
            'maxColAmount'=>$maxColAmount,
            'gridAutoStyle'=>$gridAutoStyle,
            'globalTable'=>$globalTable,
        ]);
    }

    /**
     * updating chosen day
     * @Route("/day-modify/{idDay}", methods={"GET","POST"}, name="dayModify")
     * @param int $idDay
     */
    public function modifyDay(int $idDay, Request $request) 
    {
        // same as before
        $errors=array();
        if(!($this->session->has('loggedin') && $this->session->get('loggedin')==true)){
            return $this->redirectToRoute('index');     
        }
        // Getting day to modify
        $entityManager = $this->getDoctrine()->getManager();
        $foundDay = $entityManager->getRepository(TDay::class)->find($idDay);

        $form = $this->createForm(DayForm::class, $foundDay);
        $form->handleRequest($request);
        // same as before
        if ($form->isSubmitted() && $form->isValid()) {
            $foundDay = $form->getData(); 
            // updating in db
            $entityManager->flush();
            // redirecting to day details
            return $this->redirectToRoute('dayDetail',['idDay' => $idDay]);     
        }
        return $this->render('days/modifyDay.html.twig', [
            'form' => $form->createView(),
            'errors'=>$errors,
            'idDay'=>$idDay,
        ]);
    }
    
}
