<?php
/**
 * ETML
 * Author : Chyzhyk Aleh
 * Date : 16.01.2020
 * Description : Day controller - controls agenda, create, detail, modify and delete days for admin
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

    private $session;

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
        foreach($foundDays as $day){
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

    private function updateDays(){
        //Getting days from repository by date and time
        $entityManager = $this->getDoctrine()->getManager();
        $foundDays =$entityManager->getRepository(TDay::class)->findAll();
        $date = new \DateTime();

        for($i=0;$i<count($foundDays); $i++){
            //If any day which must repeat each year has date less than today - 
            if($foundDays[$i]->getDaydate()<$date && $foundDays[$i]->getDayrepeat()==true){
                $entityManager = $this->getDoctrine()->getManager();
                $foundDay = $entityManager->getRepository(TDay::class)->find($foundDays[$i]->getIdday());
                // This is made because symfony doesn't understand that even if object ID is the same, date inside it will be different
                // So i need to make 2 objects
                $dateInit = $foundDay->getDaydate()->add(date_interval_create_from_date_string('1 year'));
                while($dateInit<$date){
                    $dateInit->add(date_interval_create_from_date_string('1 year'));
                }
                $newDateStr = $dateInit->format('d/m/Y:H:i:s');
                $newDate = date_create_from_format('d/m/Y:H:i:s', $newDateStr);
                $foundDay->setDaydate($newDate);
                $entityManager->flush();
            }
            elseif($foundDays[$i]->getDaydate()<$date && $foundDays[$i]->getDayrepeat()==false){
                $entityManager = $this->getDoctrine()->getManager();
                $foundDay = $entityManager->getRepository(TDay::class)->find($foundDays[$i]->getIdday());
                $foundDay->setDaydeleted(true);
                $entityManager->flush();
            }
        }
    }

    /**
     * @Route("/new-day", name="newday")
     */
    public function addDay(Request $request)
    {
        if(!($this->session->has('loggedin') && $this->session->get('loggedin')==true)){
            return $this->redirectToRoute('index');     
        }
            $errors=array();
            $day = new TDay();
            $form = $this->createForm(DayForm::class, $day);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $inputDay = $form->getData(); 
                
                if($inputDay->getDayname()==null || $inputDay->getDayDate()==null || $inputDay->getDaybegintime()==null || $inputDay->getDayendTime()==null){
                    $errors=array();

                    array_push($errors, "Veuillez remplir tous les champs");

                    return $this->render('days/dayCreate.html.twig', [
                        'form' => $form->createView(),
                        'errors'=>$errors,
                    ]);
                }
               
                $repository = $this->getDoctrine()->getRepository(TDay::class);
                // look for a single day by name
                $foundDay = $repository->findOneBy(['dayname' => $inputDay->getDayname(), 'daydate' => $inputDay->getDayDate()]);
                
                if ($foundDay) {
                    array_push($errors, "Le jour avec le même nom et la date existe déja");
                    return $this->render('days/dayCreate.html.twig', [
                        'form' => $form->createView(),
                        'errors'=>$errors,
                    ]);
                }
                
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($inputDay);
                $entityManager->flush();
                $idDay = $inputDay->getIdday();

                $this->session->set("idDetailDay", $idDay);
    
                return $this->redirectToRoute('dayDetail',['idDay' => $idDay]);     
            }

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
        if(!($this->session->has('loggedin') && $this->session->get('loggedin')==true)){
            return $this->redirectToRoute('index');     
        }
        $repository = $this->getDoctrine()->getRepository(TDay::class);
        $day = $repository->findOneBy(['idday'=>$idDay]);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($day);
        $entityManager->flush();
        return $this->redirectToRoute('agenda');
    }

    /**
     * showing details - events and description of the chosen day
     * @Route("/day-detail/{idDay}", methods={"GET"}, name="dayDetail")
     * @param int $idDay
     */
    public function showDay(int $idDay)
    {
        if(!($this->session->has('loggedin') && $this->session->get('loggedin')==true)){
            return $this->redirectToRoute('index');     
        }
        $repository = $this->getDoctrine()->getRepository(TDay::class);
        $day = $repository->findOneBy(['idday'=>$idDay]);
        $name=$day->getDayname();
        $date=$day->getDaydate()->format('d/m/Y');
        $beginTime=$day->getDaybegintime()->format('H\hi');
        $endTime=$day->getDayendtime()->format('H\hi');
        $description=$day->getDaydescription();
        $repeat=$day->getDayrepeat();
        $idDay=$day->getIdday();
        $foundDay=array('idDay'=>$idDay, 'description'=>$description, 'repeat'=>$repeat, 'name'=>$name, 'date'=>$date, 'beginTime'=>$beginTime, 'endTime'=>$endTime);

        $repository = $this->getDoctrine()->getRepository(TEvent::class);
        $eventEntities = $repository->findBy(['fkday'=>$idDay]);

        $events=array();
        $timeTableBegin=array();
        $timeTableEnd=array();
        foreach($eventEntities as $event){

            $convertedEvent = EventHelper::make_entity_transition_as_single($event);
            array_push($events, $convertedEvent);

            if(!in_array($convertedEvent['beginTime'], $timeTableBegin)){
                $timeTableBegin[$convertedEvent['beginTime']]=1;
            }
            else{
                $timeTableBegin[$convertedEvent['beginTime']]+=1;
            }
            if(!in_array($convertedEvent['endTime'], $timeTableEnd)){
                $timeTableEnd[$convertedEvent['endTime']]=1;
            }
            else{
                $timeTableEnd[$convertedEvent['endTime']]+=1;
            }
        }

        $maxLineAmount=(strtotime($day->getDayendtime()->format('H:i:00')) - strtotime($day->getDaybegintime()->format('H:i:00')))/900+1;
       
        $colAmount=0;
        $maxColAmount=$colAmount;

        for($i=0; $i<$maxLineAmount; $i++){
            $tmpTime=date("H\hi", strtotime($day->getDaybegintime()->format('H:i:00')) + $i*900);
            if(array_key_exists($tmpTime,$timeTableBegin)){
                $colAmount+=$timeTableBegin[$tmpTime];
            }
            if(array_key_exists(date("H\hi", strtotime($day->getDaybegintime()->format('H:i:00')) + $i*900),$timeTableEnd)){
                $colAmount-=$timeTableEnd[$tmpTime];
            }
            if($colAmount>$maxColAmount){
                $maxColAmount=$colAmount;
            }
        }
        
        $timeTable=$timeTableBegin;
        foreach($timeTableEnd as $keyEnd=>$valueEnd){
            if(!array_key_exists($keyEnd, $timeTable)){
                $timeTable[$keyEnd]=$valueEnd;
            }
        }
        $gridAutoStyle=str_repeat("auto ", $maxColAmount+2);
        //$this->session->set('idDay', $idDay);

        return $this->render('days/dayDetail.html.twig', [
            'day'=>$foundDay,
            'timeTableEnd'=>$timeTableEnd,
            'timeTableBegin'=>$timeTableBegin,
            'timeTable'=>$timeTable,
            'events'=>$events,
            'maxColAmount'=>$maxColAmount,
            'gridAutoStyle'=>$gridAutoStyle
        ]);
    }

    /**
     * updating chosen day
     * @Route("/day-modify/{idDay}", methods={"GET","POST"}, name="dayModify")
     * @param int $idDay
     */
    public function modifyDay(int $idDay, Request $request) 
    {
        //TODO : remove expired days and add repeating days
        $errors=array();
        if(!($this->session->has('loggedin') && $this->session->get('loggedin')==true)){
            return $this->redirectToRoute('index');     
        }
         
        $entityManager = $this->getDoctrine()->getManager();
        $foundDay = $entityManager->getRepository(TDay::class)->find($idDay);

        $form = $this->createForm(DayForm::class, $foundDay);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $foundDay = $form->getData(); 

            if($foundDay->getDayname()==null || $foundDay->getDayDate()==null || $foundDay->getDaybegintime()==null || $foundDay->getDayendTime()==null){
                $errors=array();

                array_push($errors, "Veuillez remplir tous les champs");
                return $this->render('days/dayCreate.html.twig', [
                    'form' => $form->createView(),
                    'errors'=>$errors,
                ]);
            }
            $entityManager->flush();

            return $this->redirectToRoute('dayDetail',['idDay' => $idDay]);     
        }
        return $this->render('days/modifyDay.html.twig', [
            'form' => $form->createView(),
            'errors'=>$errors,
            'idDay'=>$idDay,
        ]);
    }
    
}
