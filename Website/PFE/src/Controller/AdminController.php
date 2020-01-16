<?php
/**
 * ETML
 * Author : Chyzhyk Aleh
 * Date : 16.01.2020
 * Description : Administrator controller, does 
 */
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\tempEntity\TempEvent;
use App\Form\EventForm;

class AdminController extends AbstractController
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
     * @Route("/administration", name="admin")
     */
    public function index()
    {
        if(!($this->session->has('loggedin') && $this->session->get('loggedin')==true)){
            return $this->redirectToRoute('index');     
        }
        return $this->render('account/mainPage.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

    /**
     * @Route("/new-day", name="newday")
     */
    public function createDay()
    {
        if(!($this->session->has('loggedin') && $this->session->get('loggedin')==true)){
            return $this->redirectToRoute('index');     
        }
        return $this->render('account/mainPage.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

   

    /**
     * @Route("/show-day", name="showdays")
     */
    public function showDay()
    {
        if(!($this->session->has('loggedin') && $this->session->get('loggedin')==true)){
            return $this->redirectToRoute('index');     
        }
        return $this->render('account/mainPage.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

    /**
     * @Route("/show-event", name="showevents")
     */
    public function showEvent()
    {
        if(!($this->session->has('loggedin') && $this->session->get('loggedin')==true)){
            return $this->redirectToRoute('index');     
        }
        return $this->render('account/eventAdmin.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }
}
