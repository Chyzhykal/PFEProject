<?php
/**
 * ETML
 * Author : Chyzhyk Aleh
 * Date : 16.01.2020
 * Description : 
 */
namespace App\EntityHelpers;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\tempEntity\TempEvent;
use App\Form\EventForm;

class EventHelper
{

    /**
     * 
     */
    public static function make_entity_transition_as_array($events)
    {
        $convertedEvents=array();
        foreach($events as $event){
            $idEvent=$event->getIdevent();
            $name=$event->getEvename();
            $intervenant=$event->getEveauthor();
            $class=$event->getEveclass();
            $totalPlaces=$event->getEvetotplacenum();
            $leftPlaces=$event->getEveplaceleft();
            $description=$event->getEvedescription();
            $beginTime=$event->getEvebegintime()->format('H\hi');
            $endTime=$event->getEveendtime()->format('H\hi');
            $idDay=$event->getFkday()->getIdday();
            $creator=$event->getFkuser()->getUselogin();
            $participants=$event->getFkparticipant();
            $priority=$event->getFkpriority()->getEvepriname();
            $priorityCode=$event->getFkpriority()->getEvepricode();
            $isMerged=$event->getIsmerged();
            $isMaster=$event->getIsmaster();
            
            array_push($convertedEvents, array(
                'idEvent'=>$idEvent ,
                'intervenant'=>$intervenant ,
                'name'=>$name ,
                'class'=>$class ,
                'totalPlaces'=>$totalPlaces ,
                'leftPlaces'=>$leftPlaces ,
                'description'=>$description ,
                'beginTime'=>$beginTime ,
                'endTime'=>$endTime ,
                'idDay'=>$idDay ,
                'creator'=>$creator ,
                'participants'=>$participants ,
                'priority'=>$priority ,
                'priorityCode'=>$priorityCode ,
                'isMerged'=>$isMerged ,
                'isMaster'=>$isMaster ,
            ));
        }
        return $convertedEvents;
    }

     /**
     * 
     */
    public static function make_entity_transition_as_single($event)
    {
        $idEvent=$event->getIdevent();
        $name=$event->getEvename();
        $intervenant=$event->getEveauthor();
        $class=$event->getEveclass();
        $totalPlaces=$event->getEvetotplacenum();
        $leftPlaces=$event->getEveplaceleft();
        $description=$event->getEvedescription();
        $beginTime=$event->getEvebegintime()->format('H\hi');
        $endTime=$event->getEveendtime()->format('H\hi');
        $idDay=$event->getFkday()->getIdday();
        $creator=$event->getFkuser()->getUselogin();
        $participants=$event->getFkparticipant();
        $priority=$event->getFkpriority()->getEvepriname();
        $priorityCode=$event->getFkpriority()->getEvepricode();
        $isMerged=$event->getIsmerged();
        $isMaster=$event->getIsmaster();
        

        $convertedEvent= array(
            'idEvent'=>$idEvent ,
            'intervenant'=>$intervenant ,
            'name'=>$name ,
            'class'=>$class ,
            'totalPlaces'=>$totalPlaces ,
            'leftPlaces'=>$leftPlaces ,
            'description'=>$description ,
            'beginTime'=>$beginTime ,
            'endTime'=>$endTime ,
            'idDay'=>$idDay ,
            'creator'=>$creator ,
            'participants'=>$participants ,
            'priority'=>$priority ,
            'priorityCode'=>$priorityCode ,
            'isMerged'=>$isMerged ,
            'isMaster'=>$isMaster ,
        );
        return $convertedEvent;
    }
}
