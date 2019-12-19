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

class DayForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dayname', TextType::class)
            ->add('daydate', DateType::class, ['invalid_message' => 'La date n\'est pas valide'])
            ->add('dayBegintime', TimeType::class, ['invalid_message' => 'L\'heure n\'est pas valide'])
            ->add('dayEndtime', TimeType::class, ['invalid_message' => 'L\'heure n\'est pas valide'])
            ->add('submit', SubmitType::class, ['label' => 'Sauvegarder']);
    }
}
