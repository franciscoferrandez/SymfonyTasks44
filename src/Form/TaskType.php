<?php
namespace App\Form;

use App\Entity\User;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Security;

class TaskType extends AbstractType {

    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

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

        if ($options['isAdmin']) {
            $builder->add('user', EntityType::class, [
                // looks for choices from this entity
                'class' => User::class,

                // uses the User.username property as the visible option string
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.name', 'ASC')
                        ->orderBy('u.surname', 'ASC');
                },
                'choice_label' => function ($user) {
                    return $user->getName() . " " . $user->getSurname();
                },
                'group_by' => "role",
                'required' => false,

                // used to render a select box, check boxes or radios
                // 'multiple' => true,
                // 'expanded' => true,
            ]);
        }

        $builder->add("submit", SubmitType::class, array(
            'translation_domain' => 'forms',
            "label" => "Save"
        ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'translation_domain' => 'forms',
            'edit' => false,
            'isAdmin' => false,
            'isOwner' => false,
        ]);
    }

}
