<?php
// src/Form/Event.php
namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\TEventPriority;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use App\Entity\TEvent;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\tempEntity\DayEvents;

class EventNextForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('relatedEvent', EntityType::class, [
                'class' => TEvent::class,
                'choice_label' => 'evename',
                'choices' => $options['events']->getEvents(),
            ])
            ->add('eventSuite', CheckboxType::class, ['required'=>false])
            ->add('submit', SubmitType::class, ['label' => 'Créer']);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'events' =>new DayEvents()
        ]);
        $resolver->setAllowedTypes('events', 'App\tempEntity\DayEvents');
    }
}
