<?php
// src/Form/Event.php
namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class EventForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('evename', TextType::class)
            ->add('evetype', TextType::Class)
            ->add('eveauthor', TextType::class)
            ->add('eveclass', TextType::class)
            ->add('evetotplacenum', NumberType::class)
            ->add('evedescription', TextType::class)
            ->add('evebegintime', TimeType::class)
            ->add('eveendtime', TimeType::class)
            ->add('submit', SubmitType::class, ['label' => 'Créer']);
    }

    
}
