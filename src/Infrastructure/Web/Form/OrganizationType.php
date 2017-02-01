<?php

namespace Contacts\Infrastructure\Web\Form;

use Contacts\Domain\Organization\Organization;
use Contacts\Domain\Organization\OrganizationId;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class OrganizationType extends AbstractType
{
    /**
     * @inheritdoc
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', TextType::class, [
            'constraints' => [
                new Assert\NotBlank([
                    'message' => 'Organization name must not be blank.',
                ]),
                new Assert\Length([
                    'min' => 2,
                    'minMessage' => 'Organization name must be longer than 1 character.',
                ]),
            ],
        ]);

        $builder->add('submit', SubmitType::class);
    }

    /**
     * @inheritdoc
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Organization::class,
            'empty_data' => function () {
                return new Organization(OrganizationId::generate());
            }
        ]);
    }
}
