<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Entity\TDay;
use App\Form\DayForm;
use Symfony\Component\HttpFoundation\Request;

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
     * @Route("/agenda", name="agenda")
     */
    public function index()
    {
        $repository = $this->getDoctrine()->getRepository(TDay::class);
        $foundDays = $repository->findBy(array(), array('daydate' => 'ASC', 'daybegintime'=>'ASC'));

        $days=array();
        foreach($foundDays as $day){
            $name=$day->getDayname();
            $date=$day->getDaydate()->format('Y-m-d H:i:s');
            $beginTime=$day->getDaybegintime()->format('Y-m-d H:i:s');
            $endTime=$day->getDayendtime()->format('Y-m-d H:i:s');
            array_push($days, array('name'=>$name, 'date'=>$date, 'beginTime'=>$beginTime, 'endTime'=>$endTime));
        }
        if($this->session->get('loggedin')){
            return $this->render('days/agenda.html.twig', [
                'days'=> $days,
                'errors'=>array()
            ]);
        }
        
    }

    /**
     * @Route("/new-day", name="newday")
     */
    public function addDay(Request $request)
    {
        if($this->session->get('loggedin')){
            $day = new TDay();
        
            $form = $this->createForm(DayForm::class, $day);
            
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                
                // $form->getData() holds the submitted values
                // but, the original `$task` variable has also been updated
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
                // look for a single Product by name
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
    
                return $this->redirectToRoute('dayDetail');     
            }

            return $this->render('days/dayCreate.html.twig', [
                'form' => $form->createView(),
                'errors'=>array(),
            ]);
        }
        
    }

    /**
     * @Route("/remove-day", name="removeDay")
     */
    public function removeDay()
    {
        if($this->session->get('loggedin')){
            return $this->render('days/agenda.html.twig', [
            ]);
        }
    }

    /**
     * @Route("/day-detail", name="dayDetail")
     */
    public function showDay()
    {
        if($this->session->get('loggedin')){
            return $this->render('days/dayDetail.html.twig', [
                
            ]);
        }
    }

    /**
     * @Route("/day-modify", name="dayModify")
     */
    public function modifyDay()
    {
        if($this->session->get('loggedin')){
            return $this->render('days/modifyDay.html.twig', [
              
            ]);
        }
    }
    
}
