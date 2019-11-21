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

class HomeController extends AbstractController
{
    /**
    * @Route("/")
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
    * @Route("/calendar")
    */
    public function Calendar(Request $request)
    {
        
    }
    /**
    * @Route("/faq")
    */
    public function Faq(Request $request)
    {
    
    }
}