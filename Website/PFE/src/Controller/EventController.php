<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Entity\TEvent;
use Symfony\Component\HttpFoundation\Request;
use App\tempEntity\TempEvent;
use App\Entity\TEventPriority;
use App\Form\EventForm;

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
        
        $activity = new TempEvent();
        $form = $this->createForm(EventForm::class, $activity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $activity = $form->getData(); 
            $event= new TEvent();
            
            $repository = $this->getDoctrine()->getRepository(TEventPriority::class);
            $priority = $repository->findOneBy(['evepriname'=>$activity->getPriority()]);

            $event->setFkday($this->session->get('idDay'));
            $event->setFkpriority($priority);
            $event->setEvename($activity->getName());
            $event->setEveauthor($activity->getAuthor());
            $event->setEveclass($activity->getClass());
            $event->setEvetotplacenum($activity->getTotalPlaces());
            $event->setEveplaceleft($activity->getTotalPlaces());
            $event->setEvedescription($activity->getDescription());
            $event->setEvebegintime($activity->getStartTime());
            $event->setEveendtime($activity->getEndTime());
            $event->setFkuser($this->session->get("idUser"));

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($event);
            $entityManager->flush();
        }
            
        return $this->render('events/eventCreate.html.twig', [
            'form' => $form->createView(),
            'errors'=>array(),
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
    /*{% for time in times %}
                <div class="time-block"> 
                    <div class="time-value"> 
                        {{time.value}}
                    </div>
                    {% for event in events %}
                        <div class="event">
                            <p class="eveName">{{day.name}}</p>
                            <p class="eveType">{{day.date}}</p>
                            <p class="eveAuthor">{{day.beginTime}}</p>
                            <p class="dayEnd">{{day.endTime}}</p>
                            <a class="dayDetailBtn" href="">Supprimer</a>
                            <a class="dayDetailBtn" href="">Modifier</a>
                        </div>
                {% endfor %}
                </div>
            {% endfor %}*/
}
