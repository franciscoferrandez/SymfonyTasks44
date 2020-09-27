<?php

namespace App\Form;

use App\Entity\City;

use App\Entity\Region;
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

class RegionType extends AbstractType
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
        ))->add("submit", SubmitType::class, array(
            'translation_domain' => 'forms',
            "label" => "Save"
        ));
    }

    public
    function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Region::class,
            'translation_domain' => 'forms',
            'edit' => false,
            'isAdmin' => false,
            'isOwner' => false,
        ]);
    }

}
