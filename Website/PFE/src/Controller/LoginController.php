<?php
/**
 * ETML
 * Chyzhyk Aleh 
 * 14.11.2019
 * Controller class for login page
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
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Session\SessionInterface;


class LoginController extends AbstractController
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
    //TODO : comments
    /**
    * @Route("/login", name="login")
    */
    public function Login(Request $request)
    {
        $errors=array();
        $user = new TUser();
        
        $form = $this->createForm(LoginForm::class, $user);
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $user = $form->getData(); 
            $pwd = $user->getUsepwd();

            //TODO: ADD multiple users with random generated passwords for production
            
            //$user->setUsepwd(password_hash($user->getUsepwd(),PASSWORD_BCRYPT));
           // $entityManager = $this->getDoctrine()->getManager();
           // $entityManager->persist($user);
           // $entityManager->flush();
            
            $repository = $this->getDoctrine()->getRepository(TUser::class);
            // look for a single Product by name
            $foundUser = $repository->findOneBy(['uselogin' => $user->getUselogin()]);
            
            if (!$foundUser) {
                array_push($errors, "L'utilisateur inconnu.");
                return $this->render('account/login.html.twig', [
                    'form' => $form->createView(),
                    'errors'=>$errors,
                ]);
            }

            if(password_verify( $pwd, $foundUser->getUsepwd())){
                $this->session->set('username', $foundUser->getUselogin());
                $this->session->set('loggedin', true);
                $this->session->set('iduser', $foundUser->getIduser());
                return $this->redirectToRoute('admin');     
            }
            else{
                array_push($errors, "Le mot de passe est incorrect");
            }
        }
            
        return $this->render('account/login.html.twig', [
            'form' => $form->createView(),
            'errors'=>$errors,
        ]);
    }

     /**
    * @Route("/deconnecter", name="logout")
    */
    public function Disconnect(Request $request)
    {
        if($this->session->has('loggedin')){
            $this->session->remove('username');
            $this->session->remove('loggedin');
            $this->session->remove('iduser');
        }
            
        return $this->redirectToRoute('index');   
    }
}