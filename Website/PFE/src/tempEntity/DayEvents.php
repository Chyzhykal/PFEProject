<?php

namespace App\tempEntity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use App\Entity\TUser;

/**
 * DayEvents
 *
 * 
 */
class DayEvents
{

    private $events;

    public function getEvents()
    {
        return $this->events;
    }

    public function setEvents($events)
    {
        $this->events = $events;
    }

    public function addEvent(TempEventNext $event)
    {
        array_push($this->events, $event);
    }

}
