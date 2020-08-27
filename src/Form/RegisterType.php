<?php
namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegisterType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add("name", TextType::class, array(
            "label" => "Name"
        ));
        $builder->add("surname", TextType::class, array(
            "label" => "Surname"
        ));
        $builder->add("email", EmailType::class, array(
            "label" => "Email"
        ));
        $builder->add("password", PasswordType::class, array(
            "label" => "Password"
        ));
        if ($options['require_role']) {
            $builder->add("role", ChoiceType::class, array(
                "label" => "Role",
                "choices" => array(
                    "userRoleGuestLabel" => "ROLE_GUEST",
                    "userRoleUserLabel" => "ROLE_USER",
                    "userRoleAdminLabel" => "ROLE_ADMIN",
                )
            ));
        }
        $builder->add("submit", SubmitType::class, array(
            "label" => $options['submit_label']
        ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // ...,
            'submit_label' => "Register",
            'require_role' => false,
            'translation_domain' => 'forms'
        ]);

        // you can also define the allowed types, allowed values and
        // any other feature supported by the OptionsResolver component
        $resolver->setAllowedTypes('require_role', 'bool');
    }

}
