<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'attr' => ['placeholder' => 'app.form.contact.name'],
                'label' => 'app.form.contact.name',
            ])
            ->add('surname', TextType::class, [
                'attr' => ['placeholder' => 'app.form.contact.surname'],
                'label' => 'app.form.contact.surname',
            ])
            ->add('phone', TelType::class, [
                'attr' => ['placeholder' => 'app.form.contact.phone'],
                'label' => 'app.form.contact.phone',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            'csrf_token_id' => 'add_contact',
        ]);
    }

}
