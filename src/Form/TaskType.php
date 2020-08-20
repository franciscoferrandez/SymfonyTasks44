<?php
namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class TaskType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add("title", TextType::class, array(
            "label" => "Título"
        ));
        $builder->add("content", TextareaType::class, array(
            "label" => "Contenido"
        ));
        $builder->add("priority", ChoiceType::class, array(
            "label" => "Prioridad",
            "choices" => array(
                "Alta" => "HIGH",
                "Media" => "MEDIUM",
                "Baja" => "LOW",
            )
        ));
        $builder->add("hours", TextType::class, array(
            "label" => "Horas"
        ));
        $builder->add("submit", SubmitType::class, array(
            "label" => "Registro"
        ));
    }

}
