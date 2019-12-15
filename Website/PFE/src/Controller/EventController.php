<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class EventController extends AbstractController
{

    private $session;
    //TODO : FINISH With twig events template
    //TODO : RANDOM colors for event, but all dark for being able to see white text on it
    //TODO : CONTROLLER event blocks, based on given example create kind of the same blocks
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
            return $this->render('events/theming.html.twig', [
            ]);
        }
        
    }
      /**
     * @Route("/new-event", name="newevent")
     */
  /*  public function addEvent(Request $request)
    {
        $event = new TempEvent();
        
        $form = $this->createForm(EventForm::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $event = $form->getData(); 

            
            // $user->setUsepwd(password_hash($user->getUsepwd(),PASSWORD_BCRYPT));
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
            
        return $this->render('events/eventCreate.html.twig', [
            'form' => $form->createView(),
            'errors'=>$errors,
        ]);
    }*/

    /**
     * @Route("/remove-event", name="removeEvent")
     */
    public function removeEvent()
    {
        if($this->session->get('loggedin')){
            return $this->render('days/dayDetail.html.twig', [
            ]);
        }
    }

     /**
     * @Route("/event-detail", name="eventDetail")
     */
    public function showEvent()
    {
        if($this->session->get('loggedin')){
            return $this->render('events/eventDetail.html.twig', [
              
            ]);
        }
    }

      /**
     * @Route("/event-modify", name="eventModify")
     */
    public function modifyEvent()
    {
        if($this->session->get('loggedin')){
            return $this->render('events/modifyEvent.html.twig', [
              
            ]);
        }
    }
}
