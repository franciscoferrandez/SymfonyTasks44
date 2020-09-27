<?php

namespace App\Form;

use App\Entity\City;

use App\Entity\Region;
use App\Entity\Venue;
use App\Repository\RegionRepository;
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

class VenueType extends AbstractType
{

    private $security;
    private $regionRepository;

    public function __construct(Security $security, RegionRepository $regionRepository)
    {
        $this->security = $security;
        $this->regionRepository = $regionRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $regions = $this->regionRepository->findAll();

        $builder->add("name", TextType::class, array(
            "label" => "Name"
        ))
            ->add('region', EntityType::class, [
                'label' => 'Region',
                'class'         => Region::class,
                'choice_label'  => 'name',
                'choices' => $regions,
                'empty_data' => null,
                'required' => false,
//                'query_builder' => function (EntityRepository $er) {
//                    return $er->createQueryBuilder('r')
//                        ->orderBy('r.name', 'ASC');
//                },
            ])
            ->add('city');


        $builder->add("submit", SubmitType::class, array(
            'translation_domain' => 'forms',
            "label" => "Save"
        ));

        $formModifier = function (FormInterface $form, Region $region = null) {
            $cities = null === $region ? array() : $region->getCities();

            $form->add('city', EntityType::class, array(
                'class' => City::class,
                'placeholder' => '',
                'choices' => $cities,
                'label' => 'City',
                'choice_label'  => 'name',
                'empty_data' => null,
                'required' => false,
            ));
        };

        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) use ($formModifier) {
                $data = $event->getData();
                $formModifier($event->getForm(), $data->getRegion());
            }
        );

        $builder->get('region')->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) use ($formModifier) {
                $region = $event->getForm()->getData();
                $formModifier($event->getForm()->getParent(), $region);
            }
        );

    }

    public
    function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Venue::class,
            'translation_domain' => 'forms',
            'edit' => false,
            'isAdmin' => false,
            'isOwner' => false,
        ]);
    }

}
