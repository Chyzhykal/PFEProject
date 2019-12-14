<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

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
        if($this->session->get('loggedin')){
            return $this->render('days/agenda.html.twig', [
            ]);
        }
        
    }

    /**
     * @Route("/new-day", name="newday")
     */
    /*public function addDay(Request $request)
    {
        if($this->session->get('loggedin')){
            return $this->render('days/dayCreate.html.twig', [
                'form' => $form->createView(),
                'errors'=>$errors,
            ]);
        }
        
    }*/

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
