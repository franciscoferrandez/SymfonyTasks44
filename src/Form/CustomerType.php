<?php


namespace App\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ColorType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CustomerType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add("name", TextType::class, array(
            "label" => "Name"
        ));
        $builder->add("commercialName", TextType::class, array(
            "label" => "Commercial Name",
            'empty_data' => '',
            'required' => false,
        ));
        $builder->add("acronym", TextType::class, array(
            "label" => "Acronym",
            'empty_data' => null,
            'required' => false,
        ));
        $builder->add("backColor", ColorType::class, array(
            "label" => "Background Color"
        ));
        $builder->add("foreColor", ColorType::class, array(
            "label" => "Text Color"
        ));
        $builder->add("submit", SubmitType::class, array(
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

