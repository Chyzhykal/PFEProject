<?php
/**
 * ETML
 * Chyzhyk Aleh 
 * 14.11.2019
 * Controller class for home pages (Home, Calendar, F.A.Q.)
 */

// src/Controller/LoginController.php


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


class LoginController extends AbstractController
{
    /**
    * @Route("/login")
    */
    public function Login(Request $request)
    {
    
    }

    /**
    * @Route("/login-check")
    */
    public function LoginCheck(Request $request)
    {
    
    }
}