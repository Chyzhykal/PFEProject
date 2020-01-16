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
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class DayForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dayname', TextType::class)
            ->add('daydescription', TextareaType::class, ['required'=>false])
            ->add('daydate', DateType::class, array('invalid_message' => 'La date n\'est pas valide', 
            'widget' => 'choice',
            'years' => range(date('Y'), date('Y')+100),
            ))
            ->add('dayBegintime', TimeType::class, ['invalid_message' => 'L\'heure n\'est pas valide',
            'minutes' => range(0, 59, 15),
            ])
            ->add('dayEndtime', TimeType::class, ['invalid_message' => 'L\'heure n\'est pas valide',
            'minutes' => range(0, 59, 15),
            ])
            ->add('dayrepeat', CheckboxType::class, ['required'=>false])
            ->add('submit', SubmitType::class, ['label' => 'Sauvegarder']);
    }
}
