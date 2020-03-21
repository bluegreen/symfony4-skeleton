<?php

declare(strict_types=1);

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class PersonType.
 *
 * @author Radosław Skrzypczak <radoslaw.skrzypczak@pearfly.pl>
 */
class PersonType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options) : void
    {
        $builder->add('firstName', TextType::class, [
            'label' => 'Imię',
            'required' => true
        ]);
        $builder->add('lastName', TextType::class, [
            'label' => 'Nazwisko',
            'required' => true
        ]);
        $builder->add('age', NumberType::class, [
            'label'=> 'Wiek',
            'required' => true,
            'html5' => true
        ]);
        $builder->add('email', EmailType::class, [
            'label'=> 'E-mail',
            'required' => true
        ]);
        $builder->add('dataProcessingAgreement', CheckboxType::class, [
            'label'=> 'Wyrażam zgodę na przetwarzanie danych',
            'required' => true
        ]);
        $builder->add('btnAdd', SubmitType::class, [
            'label'=> 'Wyślij'
        ]);
    }

    public function configureOptions(OptionsResolver $resolver) : void
    {
    }
}
