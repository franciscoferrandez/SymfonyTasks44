<?php


namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;

class UserPasswordChangeType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add("old_password", PasswordType::class, array(
            "label" => "Current Password",
            "mapped" => false,
        ));

        $builder->add('password', RepeatedType::class, [
            'type' => PasswordType::class,
            'invalid_message' => 'The password fields must match.',
            'options' => ['attr' => ['class' => 'password-field']],
            'required' => true,
            'first_options' => ['label' => 'New Password'],
            'second_options' => ['label' => 'Repeat New Password'],
            'constraints' => [
                new NotBlank(),
                new Length(['min' => 8]),
            ],
        ]);

        $builder->add("submit", SubmitType::class, array(
            "label" => $options['submit_label']
        ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'submit_label' => "Change password",
            'translation_domain' => 'forms'
        ]);

        // you can also define the allowed types, allowed values and
        // any other feature supported by the OptionsResolver component
        // $resolver->setAllowedTypes('require_role', 'bool');
    }

}
