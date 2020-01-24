<?php
/**
 * ETML
 * Chyzhyk Aleh 
 * 14.11.2019
 * Controller class for home pages (Home, Calendar, F.A.Q.)
 */

// src/Controller/HomeController.php


namespace App\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Task;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class HomeController extends AbstractController
{
    private $session;

    /**
     * Constructor
     *
     * @param SessionInterface $session
     */
    public function __construct(SessionInterface $session)
    {
        //TODO : Active class changement for links in twig
        $this->session = $session;
    }

    /**
    * Home page, login form for participant s
    * @Route("/" , name="index")
    */
    public function Home(Request $request)
    {
         // creates a task object and initializes some data for this example
         $guestForm = $this->createFormBuilder()
             ->add('firstname', TextType::class)
             ->add('lastname', TextType::class)
             ->add('begin', SubmitType::class, ['label' => 'Commencer'])
             ->getForm();
 

        return $this->render('home/home.html.twig', [
            'form' => $guestForm->createView(),
        ]);
    }

    /**
    * Calendar page
    * @Route("/calendar", name="calendar")
    */
    public function Calendar(Request $request)
    {
        return $this->render('home/calendar.html.twig', [
           
        ]);
    }

    /**
    * Frequent questions page
    * @Route("/faq", name="faq")
    */
    public function Faq(Request $request)
    {
        return $this->render('home/faq.html.twig', [
           
        ]);
    }
}