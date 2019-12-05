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
use App\Entity\TUser;
use Doctrine\ORM\EntityNotFoundException;
use App\Form\LoginForm;

class LoginController extends AbstractController
{
    /**
    * @Route("/login", name="login")
    */
    public function Login(Request $request)
    {

        $user = new TUser();
        
        $form = $this->createForm(LoginForm::class, $user);
        
        $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $entUser = new TUser();
            $user = $form->getData();

            $user->setUsepwd(password_hash($user->getUsepwd(),PASSWORD_BCRYPT));
            
            $repository = $this->getDoctrine()->getRepository(TUser::class);

            // look for a single Product by name
            $foundUser = $repository->findOneBy(['uselogin' => $user->getUselogin()]);

            if (!$foundUser) {
                return $this->render('account/login.html.twig', [
                    'form' => $form->createView(),
                ]);
            }
            
            if($foundUser->getUsepwd()!=$user->getUsepwd()){
                throw new UnauthorizedHttpException('Mot de passe incorrect');
            }
            return $this->redirectToRoute('index');      
        }
            
        return $this->render('account/login.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}