<?php
namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TaskType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add("title", TextType::class, array(
            "label" => "Title"
        ));
        $builder->add("content", TextareaType::class, array(
            "label" => "Content"
        ));
        $builder->add("priority", ChoiceType::class, array(
            "label" => "Priority",
            "choices" => array(
                "priorityHighLabel" => "HIGH",
                "priorityMediumLabel" => "MEDIUM",
                "priorityLowLabel" => "LOW",
            )
        ));
        $builder->add("status", ChoiceType::class, array(
            "label" => "Status",
            "choices" => array(
                "statusInboxLabel" => 0,
                "statusPendingLabel" => 10,
                "statusInProgressLabel" => 20,
                "statusRevisionLabel" => 30,
                "statusCompletedLabel" => 40,
            )
        ));
        $builder->add("hours", TextType::class, array(
            "label" => "Hours"
        ));
        $builder->add("submit", SubmitType::class, array(
            'translation_domain' => 'forms',
            "label" => "Save"
        ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'translation_domain' => 'forms'
        ]);
    }

}
