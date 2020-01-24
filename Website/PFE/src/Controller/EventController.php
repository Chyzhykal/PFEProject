<?php
/**
 * ETML
 * Author : Chyzhyk Aleh
 * Date : 16.01.2020
 * Description : Day controller - controls agenda, create, detail, modify and delete days for admin
 * NOTE : activity is the same thing as event, just different name
 */
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Entity\TEvent;
use Symfony\Component\HttpFoundation\Request;
use App\tempEntity\TempEvent;
use App\Entity\TEventPriority;
use App\Form\EventForm;
use App\tempEntity\TempEventNext;
use App\Entity\TDay;
use App\Entity\TUser;
use App\tempEntity\DayEvents;
use App\Form\EventNextForm;
use \Doctrine\Common\Collections\Criteria;
use App\Entity\TEventMerge;
use App\EntityHelpers\EventHelper;

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
     * @Route("/activity-detail/{idActivity}", methods={"GET","POST"}, name="activityDetail")
     * @param int $idActivity
     */
    public function index(int $idActivity)
    {
        if(!($this->session->has('loggedin') && $this->session->get('loggedin')==true)){
            return $this->redirectToRoute('index');     
        }

        $repository = $this->getDoctrine()->getRepository(TEvent::class);
        $activity = $repository->findOneBy(['idevent'=>$idActivity]);

        $foundActivity= EventHelper::make_entity_transition_as_single($activity);
        
        $repository = $this->getDoctrine()->getRepository(TEventMerge::class);
        $merges=null;
        $merge=null;
        if($foundActivity['isMaster']){
            $merges=array();
            $children = $repository->findBy(['fkeventmaster'=>$activity]);
            foreach($children as $child){
                array_push($merges, array('beginTime'=> $child->getFkeventchild()->getEvebegintime()->format('H\hi'), 'endTime'=>$child->getFkeventchild()->getEveendtime()->format('H\hi')));
            }
        }
        else{
            $parent = $repository->findOneBy(['fkeventchild'=>$activity]);
            $merge['id']=$parent->getFkeventmaster()->getIdevent();
            $merge['beginTime']=$parent->getFkeventmaster()->getEvebegintime()->format('H\hi');
            $merge['endTime']=$parent->getFkeventmaster()->getEveendtime()->format('H\hi');
        }
        
        $foundActivity['mergesAsMaster']=$merges;
        $foundActivity['mergeAsChild']=$merge;

        return $this->render('events/eventDetail.html.twig', [
            'activity'=>$foundActivity,
        ]);
    }

    /**
    * @Route("/select-event/{idDay}", methods={"GET","POST"}, name="selectevent")
    * @param int $idDay
    */
    public function selectEvent(int $idDay)
    {
        if(!($this->session->has('loggedin') && $this->session->get('loggedin')==true)){
            return $this->redirectToRoute('index');     
        }   

        $repository = $this->getDoctrine()->getRepository(TDay::class);
        $day = $repository->findOneBy(['idday'=> $idDay]);
        $repository = $this->getDoctrine()->getRepository(TEvent::class);
        // Add a not equals parameter to your criteria
        $criteria = Criteria::create()
        ->andWhere(Criteria::expr()->eq('fkday', $day))
        ->andWhere(Criteria::expr()->eq('ismaster', true));
        // Find all from the repository matching your criteria
        $activities=$repository->matching($criteria);
        $hasParents=true;
        if($activities[0]==null){
            $hasParents=false;
        }
        return $this->render('events/eventSelect.html.twig', [
            'idDay'=>$idDay,
            'hasParents'=>$hasParents
        ]);
    }

    /**
    * @Route("/new-event/{idDay}", methods={"GET","POST"}, name="newevent")
    * @param int $idDay
    */
    public function addEvent(Request $request, int $idDay)
    {
        //TODO : limit minutes to day value
        if(!($this->session->has('loggedin') && $this->session->get('loggedin')==true)){
            return $this->redirectToRoute('index');     
        }  
        $errors=array();

        $repository = $this->getDoctrine()->getRepository(TDay::class);
        $day = $repository->findOneBy(['idday'=> $idDay]);
        $activity = new TempEvent();
        $form = $this->createForm(EventForm::class, $activity, [
            'limitBeginH' => $day->getDaybegintime()->format('H'),
            'limitEndH' => $day->getDayendtime()->format('H'),
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $activity = $form->getData(); 
            
            $event= new TEvent();

            $repository = $this->getDoctrine()->getRepository(TUser::class);
            $user = $repository->findOneBy(['iduser'=> $this->session->get("iduser")]);
            
            $event->setFkday($day);
            $event->setFkpriority($activity->getPriority());
            $event->setEvename($activity->getName());
            $event->setEveauthor($activity->getAuthor());
            $event->setEveclass($activity->getClass());
            $event->setEvetotplacenum($activity->getTotalPlaces());
            $event->setEveplaceleft($activity->getTotalPlaces());
            $event->setEvedescription($activity->getDescription());
            $event->setEvebegintime($activity->getBeginTime());
            $event->setEveendtime($activity->getEndTime());
            $event->setFkuser($user);
            $event->setIsmaster(true);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($event);
            $entityManager->flush();
            $idActivity = $event->getIdevent();

            return $this->redirectToRoute('activityDetail',['idActivity' => $idActivity]);
        }
            
        return $this->render('events/eventCreate.html.twig', [
            'idDay'=>$idDay,
            'form' => $form->createView(),
            'errors'=>$errors,
        ]);
    }

    /**
    * Event creation - only when event must be related to another event
    * @Route("/new-event-next/{idDay}", methods={"GET","POST"}, name="neweventNext")
    * @param int $idDay
    */
    public function addEventNext(Request $request, int $idDay)
    {
        //TODO : add name for child activity
        //TODO : add event and day copy feature
        if(!($this->session->has('loggedin') && $this->session->get('loggedin')==true)){
            return $this->redirectToRoute('index');     
        }   

        $repository = $this->getDoctrine()->getRepository(TDay::class);
        $day = $repository->findOneBy(['idday'=> $idDay]);

        $repository = $this->getDoctrine()->getRepository(TUser::class);
        $user = $repository->findOneBy(['iduser'=> $this->session->get("iduser")]);

        $repository = $this->getDoctrine()->getRepository(TEvent::class);
        // Add a not equals parameter to your criteria
        $criteria = Criteria::create()
        ->andWhere(Criteria::expr()->eq('fkday', $day))
        ->andWhere(Criteria::expr()->eq('ismaster', true));
        // Find all from the repository matching your criteria

        $activities=$repository->matching($criteria);
        $dayEvents= new DayEvents();
        $dayEvents->setEvents($activities);

        $tempEntity = new TempEventNext();
        $form = $this->createForm(EventNextForm::class, $tempEntity, [
            'events' => $dayEvents,
            'limitBeginH' => $day->getDaybegintime()->format('H'),
            'limitEndH' => $day->getDayendtime()->format('H'),
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $formData = $form->getData(); 
            $activityMaster=$formData->getRelatedEvent();

            $entityManager = $this->getDoctrine()->getManager();
            $activityChild = new TEvent();
            $activityChild->setIsmerged(true);
            $activityChild->setFkday($day);
            $activityChild->setFkpriority($activityMaster->getFkpriority());
            $activityChild->setEvename($activityMaster->getEvename());
            $activityChild->setEveauthor($activityMaster->getEveauthor());
            $activityChild->setEveclass($activityMaster->getEveclass());
            $activityChild->setEvetotplacenum($activityMaster->getEvetotplacenum());
            $activityChild->setEveplaceleft($activityMaster->getEveplaceleft());
            $activityChild->setEvedescription($activityMaster->getEvedescription());
            $activityChild->setEvebegintime($formData->getBeginTime());
            $activityChild->setEveendtime($formData->getEndTime());
            $activityChild->setFkuser($user);
            $activityChild->setIsmaster(false);
            $entityManager->persist($activityChild);
            $entityManager->flush();

            $idActivity = $activityChild->getIdevent();
            
            $entityManager = $this->getDoctrine()->getManager();
            $merge = new TEventMerge();
            $merge->setFkeventmaster($activityMaster);
            $merge->setFkEventchild($activityChild);
            $entityManager->persist($merge);
            $entityManager->flush();

            return $this->redirectToRoute('activityDetail',['idActivity' => $idActivity]);
        }
            
        return $this->render('events/create-next.html.twig', [
            'idDay'=>$idDay,
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

    /* 
    


    {% for event in events %}
                      {% if event.beginTime == time.key %}
                        <div class="eventBlock">
                            {% if day.repeat == true %}
                                <img src={{asset('images/repeat.png')}} class="repeatIcon"/>
                            {% else %}
                                <img src={{asset('images/one.png')}} class="repeatIcon"/>
                            {% endif %}
                            <p class="dayName">Nom du jour : {{day.name}}</p>
                            <p class="dayDate">Date : {{day.date}}</p>
                            <p class="dayBegin">L'heure de début : {{day.beginTime}}</p>
                            <p class="dayEnd">L'heure de fin : {{day.endTime}}</p>
                            <a class="dayDetailBtn sitebtn" href={{ path('dayDetail', { idDay: day.idDay })}}>Afficher les détails</a>
                        </div>
                    {% endfor %}*/
}
