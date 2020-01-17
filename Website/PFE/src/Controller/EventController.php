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
use App\tempEntity\TempEventNext;
use App\Entity\TDay;
use App\Entity\TUser;
use App\tempEntity\DayEvents;
use App\Form\EventNextForm;
use \Doctrine\Common\Collections\Criteria;
use App\Entity\TEventMerge;

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

        $name=$activity->getEvename();
        $priority=$activity->getFkpriority()->getEvepriname();
        $priorityCode=$activity->getFkpriority()->getEvepricode();
        $intervenant=$activity->getEveauthor();
        $class=$activity->getEveclass();
        $totalPlaces=$activity->getEvetotplacenum();
        $leftPlaces=$activity->getEveplaceleft();
        $description=$activity->getEvedescription();
        $beginTime=$activity->getEvebegintime()->format('H\hi');
        $endTime=$activity->getEveendtime()->format('H\hi');
        $dayName=$activity->getFkday()->getDayname();
        $idDay=$activity->getFkday()->getIdday();
        $creator=$activity->getFkuser()->getUselogin();
        $isMaster=$activity->getIsmaster();
        
        $repository = $this->getDoctrine()->getRepository(TEventMerge::class);
        $merges=null;
        $merge=null;
        if($isMaster){
            $merges = $repository->findBy(['fkeventmaster'=>$activity]);
        }
        else{
            $merge = $repository->findBy(['fkeventchild'=>$activity]);
            $merges = $repository->findBy(['fkeventmaster'=>$merge->getFkeventmaster()]);
        }
        $foundActivity=array(
            'priorityCode'=>$priorityCode,
            'idDay'=>$idDay,
            'idActivity'=>$idActivity,
            'name'=>$name,
            'priority'=>$priority,
            'intervenant'=>$intervenant,
            'class'=>$class,
            'totalPlaces'=>$totalPlaces,
            'leftPlaces'=>$leftPlaces,
            'description'=>$description,
            'beginTime'=>$beginTime,
            'endTime'=>$endTime,
            'dayName'=>$dayName,
            'creator'=>$creator,
            'mergesMaster'=>$merges,
            'mergeChild'=>$merge,
            'isMaster'=>$isMaster
        );


        return $this->render('events/eventDetail.html.twig', [
            'activity'=>$foundActivity,
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

        $errors=array();

        $activity = new TempEvent();
        $form = $this->createForm(EventForm::class, $activity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $activity = $form->getData(); 
            
            $event= new TEvent();
            
            $repository = $this->getDoctrine()->getRepository(TDay::class);
            $day = $repository->findOneBy(['idday'=>$this->session->get('idDay')]);

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

            $entityManager = $this->getDoctrine()->getManager();
            $event->setIsmaster(!getEventRelated());
            $entityManager->persist($event);
            $entityManager->flush();
            $idActivity = $event->getIdevent();

            if($activity->getEventRelated()==true){
                return $this->redirectToRoute('neweventNext',['idActivity' => $idActivity]);
            }

            return $this->redirectToRoute('activityDetail',['idActivity' => $idActivity]);
        }
            
        return $this->render('events/eventCreate.html.twig', [
            'form' => $form->createView(),
            'errors'=>$errors,
        ]);
    }

    /**
    * Next step of event creation - only whem event must be related to another event
    * @Route("/new-event-next/{idActivity}", methods={"GET", "POST"}, name="neweventNext")
    * @param int $idActivity
    */
    public function addEventNext(Request $request, int $idActivity)
    {
        if(!($this->session->has('loggedin') && $this->session->get('loggedin')==true)){
            return $this->redirectToRoute('index');     
        }   

        $entityManager = $this->getDoctrine()->getManager();
        $activityChild = $entityManager->getRepository(TEvent::class)->find($idActivity);

        $repository = $this->getDoctrine()->getRepository(TEvent::class);
        // Add a not equals parameter to your criteria
        $criteria = Criteria::create()
        ->andWhere(Criteria::expr()->eq('fkday', $activityChild->getFkday()))
        ->andWhere(Criteria::expr()->eq('ismaster', true));
        // Find all from the repository matching your criteria

        $activities=$repository->matching($criteria);
        $dayEvents= new DayEvents();
        $dayEvents->setEvents($activities);

        $tempEntity = new TempEventNext();
        $form = $this->createForm(EventNextForm::class, $tempEntity, [
            'events' => $dayEvents,
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $formData = $form->getData(); 

            $activityChild->setIsmerged($formData->getEventSuite());
            $entityManager->flush();

            $activityMaster=$formData->getRelatedEvent();

            $entityManager = $this->getDoctrine()->getManager();
            $merge = new TEventMerge();
            $merge->setFkeventmaster($activityMaster);
            $merge->setFkEventchild($activityChild);
            $entityManager->persist($merge);
            $entityManager->flush();

            return $this->redirectToRoute('activityDetail',['idActivity' => $idActivity]);
        }
            
        return $this->render('events/create-next.html.twig', [
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
}
