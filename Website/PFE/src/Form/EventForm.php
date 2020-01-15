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

class EventForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('priority', ChoiceType::class)
            ->add('name', TextType::Class)
            ->add('author', TextType::class)
            ->add('class', TextType::class)
            ->add('totalPlaces', NumberType::class)
            ->add('description', TextareaType::class)
            ->add('beginTime', TimeType::class)
            ->add('endTime', TimeType::class)
            ->add('submit', SubmitType::class, ['label' => 'Créer']);
    }
}
