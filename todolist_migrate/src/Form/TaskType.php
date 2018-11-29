<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 28/11/2018
 * Time: 21:51
 */

namespace App\Form;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilder;

class TaskType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, array('required' => true,))
            ->add('content', TextType::class, array('required' => true,))
            ->add('priority', CheckboxType::class, array('required' => false,))
            ->add('done', CheckboxType::class, array('required' => false,))
            ->add('user', ChoiceType::class, array(
                'choices' => $options[0],
            ))
            ->add('save', SubmitType::class, array('label' => 'Ajouter la tache'));
    }
}