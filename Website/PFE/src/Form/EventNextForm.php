<?php
/**
 * ETML
 * Author : Chyzhyk Aleh
 * Date : 16.01.2020
 * Description : Form for child event creation and modification
 */
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
            ->add('beginTime', TimeType::class, [
                'invalid_message' => 'Le temps n\'est pas valide',
                'placeholder' => [
                    'hour' => 'Heure', 'minute' => 'Minute'
                ],
                'minutes' => range(0,59,15),
                'hours' => range($options['limitBeginH'],$options['limitEndH']),
            ])
            ->add('endTime', TimeType::class, [
                'invalid_message' => 'Le temps n\'est pas valide',
                'placeholder' => [
                    'hour' => 'Heure', 'minute' => 'Minute'
                ],
                'minutes' => range(0,59, 15),
                'hours' => range($options['limitBeginH'],$options['limitEndH']),
            ])
            ->add('submit', SubmitType::class, ['label' => 'Créer']);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'events' =>new DayEvents(),
            'limitBeginH' => "0",
            'limitEndH' => "0",
        ]);
        $resolver->setAllowedTypes('events', 'App\tempEntity\DayEvents');
        $resolver->setAllowedTypes('limitBeginH', 'string');
        $resolver->setAllowedTypes('limitEndH', 'string');
    }
}
