<?php

namespace App\Form;

use App\Entity\Application;
use App\Entity\AppPermission;
use App\Entity\AppRole;
use App\Entity\AppUser;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddAppPermissionFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('user', EntityType::class, [
                'class' => AppUser::class,
                'choice_label' => 'username',
            ])
            ->add('application', EntityType::class, [
                'class' => Application::class,
                'choice_label' => 'name',
            ])
            ->add('role', EntityType::class, [
                'class' => AppRole::class,
                'choice_label' => 'role',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => AppPermission::class,
        ]);
    }
}
