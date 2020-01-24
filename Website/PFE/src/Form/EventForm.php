<?php
/**
 * ETML
 * Author : Chyzhyk Aleh
 * Date : 16.01.2020
 * Description : Form for master event creation and modification
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
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('priority', EntityType::class, [
                'class' => TEventPriority::class,
                'choice_label' => 'evepriname',
            ])
            ->add('name', TextType::Class)
            ->add('author', TextType::class)
            ->add('class', TextType::class)
            ->add('totalPlaces', IntegerType::class,[
                'required' => true,
                'scale'    => 3,
                'attr'     => array('min'  => 0,'max'  => 1000,'step' => 1,)
                ])
            ->add('description', TextareaType::class)
            ->add('beginTime', TimeType::class, [
                'invalid_message' => 'Le temps n\'est pas valide',
                'placeholder' => [
                    'hour' => 'Heure', 'minute' => 'Minute'
                ],
                'minutes' => range(0,59, 15),
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
            'limitBeginH' => "0",
            'limitEndH' => "0",
        ]);
        $resolver->setAllowedTypes('limitBeginH', 'string');
        $resolver->setAllowedTypes('limitEndH', 'string');
    }
}
