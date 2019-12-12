<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class EventController extends AbstractController
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
        if($this->session->get('loggedin')){
            return $this->render('account/eventAdmin.html.twig', [
                'controller_name' => 'AdminController',
            ]);
        }
        
    }

    /**
     * @Route("/event-details", name="eventdet")
     */
    public function createDay()
    {
        if($this->session->get('loggedin')){
            return $this->render('account/eventAdmin.html.twig', [
                'controller_name' => 'AdminController',
            ]);
        }
        
    }
}
