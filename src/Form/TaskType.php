<?php

namespace App\Form;

use App\Entity\Customer;
use App\Entity\Task;
use App\Entity\User;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Security;

class TaskType extends AbstractType
{

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
            "label" => "Content",
            'required' => false,
            'empty_data' => '',
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

        $formModifier = function (FormInterface $form, User $user = null) {
            $positions = null === $user ? [] : $user->getCustomers();
            $form->add('customer', EntityType::class, [
                'class' => Customer::class,
                'placeholder' => '',
                'choices' => $positions,
                'choice_label' => 'name'
            ]);
        };

        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) use ($formModifier) {
                // this would be your entity, i.e. SportMeetup
                $data = $event->getData();
                $formModifier($event->getForm(), $data->getUser());
            }
        );

        if (false) {  // versión sin ajax

        } else {


            if ($builder->has('user')) {
                $builder->get('user')->addEventListener(
                    FormEvents::POST_SUBMIT,
                    function (FormEvent $event) use ($formModifier) {

//                    $form = $event->getForm();
//                    $data = $form->getData();
//
//                    $form->getParent()->add('customer', EntityType::class, [
//                        'class' => Customer::class,
//                        'placeholder' => '',
//                        'choices' => $data->getCustomers(),
//                        'choice_label' => 'name'
//                    ]);

                        // --------------------------
                        // It's important here to fetch $event->getForm()->getData(), as
                        // $event->getData() will get you the client data (that is, the ID)
                        $sport = $event->getForm()->getData();

                        // since we've added the listener to the child, we'll have to pass on
                        // the parent to the callback functions!
                        $formModifier($event->getForm()->getParent(), $sport);
                    }
                );
            }
        }

        $builder->add('customer', null);

        $builder->add("submit", SubmitType::class, array(
            'translation_domain' => 'forms',
            "label" => "Save"
        ));
    }

    public
    function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Task::class,
            'translation_domain' => 'forms',
            'edit' => false,
            'isAdmin' => false,
            'isOwner' => false,
        ]);
    }

}
