<?php

namespace App\Form;

use App\Entity\Expense;
use App\Entity\Tricount;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ExpenseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $users = $options['data']->getTricount()->getUsers();
        $builder
            ->add('Title')
            ->add('CreatedAt')
            ->add('Amount')
            ->add('Payer', EntityType::class, [
                'class' => User::class,
                'choices' => $users,
                'choice_label' => 'name',
            ])
            ->add('Participant', EntityType::class, [
                'class' => User::class,
                'choices' => $users,
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true
            ])
            ->add('Tricount', EntityType::class, [
                'class' => Tricount::class,
                'choice_label' => 'title',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Expense::class,
        ]);
    }
}
