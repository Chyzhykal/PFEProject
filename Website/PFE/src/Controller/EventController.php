<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Entity\TEvent;
use Symfony\Component\HttpFoundation\Request;
use App\tempEntity\TempEvent;
use App\Entity\TEventPriority;

class EventController extends AbstractController
{
    private $session;
    //TODO : FINISH With twig events template
    //TODO : RANDOM colors for event, but all dark for being able to see white text on it - if have time
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
     * @Route("/activity-detail/{idActivity}", methods={"GET"}, name="activityDetail")
     * @param int $idActivity
     */
    public function index(int $idActivity)
    {
        if(!($this->session->has('loggedin') && $this->session->get('loggedin')==true)){
            return $this->redirectToRoute('index');     
        }
        return $this->render('events/theming.html.twig', [
        ]);
    }

    /**
    * @Route("/new-event", name="newevent")
    */
    public function addEvent(Request $request)
    {
        if(!($this->session->has('loggedin') && $this->session->get('loggedin')==true)){
            return $this->redirectToRoute('index');     
        }   

        $repository = $this->getDoctrine()->getRepository(TEventPriority::class);
        $priorities = $repository->findAll();
        
        $activity = new TempEvent();
        $form = $this->createForm(EventForm::class, $activity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $activity = $form->getData(); 

            $activity->setFkday($this->session->get('idDay'));


            

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
    }

    /**
     * @Route("/remove-event", name="removeEvent")
     */
    public function removeEvent()
    {
        if(!($this->session->has('loggedin') && $this->session->get('loggedin')==true)){
            return $this->redirectToRoute('index');     
        }
        return $this->render('days/dayDetail.html.twig', [
        ]);
    }

      /**
     * @Route("/event-modify", name="eventModify")
     */
    public function modifyEvent()
    {
        if(!($this->session->has('loggedin') && $this->session->get('loggedin')==true)){
            return $this->redirectToRoute('index');     
        }
        return $this->render('events/modifyEvent.html.twig', [
            
        ]);
    }
}
