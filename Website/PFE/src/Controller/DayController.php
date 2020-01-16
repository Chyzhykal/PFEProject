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
        //Getting days from repository by date and time
        $repository = $this->getDoctrine()->getRepository(TDay::class);
        $foundDays = $repository->findBy(array('daydeleted'=>false), array('daydate' => 'ASC', 'daybegintime'=>'ASC'));

        //If any day which must repeat each year has date less than today - 
        $date = new \DateTime();
        for($i=0;$i<count($foundDays); $i++){
            if($foundDays[$i]->getDaydate()<$date && $foundDays[$i]->getDayrepeat()==true){
                $entityManager = $this->getDoctrine()->getManager();
                $foundDay = $entityManager->getRepository(TDay::class)->find($foundDays[$i]->getIdday());
                $date= $foundDays[$i]->getDaydate();
                $date->modify('+1 year');
                $foundDay->setDaydate($date);
                $foundDays[$i]=$foundDay;
                $entityManager->flush();
            }
            elseif($foundDays[$i]->getDaydate()<$date && $foundDays[$i]->getDayrepeat()==false){
                $entityManager = $this->getDoctrine()->getManager();
                $foundDay = $entityManager->getRepository(TDay::class)->find($foundDays[$i]->getIdday());
                $foundDay->setDaydeleted(true);
                $foundDays[$i]=$foundDay;
                $entityManager->flush();
            }
        }

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
        $date=$day->getDaydate()->format('Y/m/d');
        $beginTime=$day->getDaybegintime()->format('H\hi');
        $endTime=$day->getDayendtime()->format('H\hi');
        $description=$day->getDaydescription();
        $repeat=$day->getDayrepeat();
        $idDay=$day->getIdday();
        $foundDay=array('idDay'=>$idDay, 'description'=>$description, 'repeat'=>$repeat, 'name'=>$name, 'date'=>$date, 'beginTime'=>$beginTime, 'endTime'=>$endTime);

        $repository = $this->getDoctrine()->getRepository(TEvent::class);
        $events = $repository->findBy(['fkday'=>$idDay]);

        $this->session->set('idDay', $idDay);

        return $this->render('days/dayDetail.html.twig', [
            'day'=>$foundDay,
        ]);
    }

    /**
     * updating chosen day
     * @Route("/day-modify/{idDay}", methods={"GET","POST"}, name="dayModify")
     * @param int $idDay
     */
    public function modifyDay(int $idDay, Request $request) 
    {
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
