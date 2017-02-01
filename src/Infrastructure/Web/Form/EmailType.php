<?php

namespace Contacts\Infrastructure\Web\Form;

use Contacts\Domain\Value\Email;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class EmailType extends AbstractType implements DataTransformerInterface
{
    /**
     * @inheritdoc
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addModelTransformer($this);
    }

    /**
     * @inheritdoc
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'constraints' => new Assert\Email(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function getParent()
    {
        return \Symfony\Component\Form\Extension\Core\Type\EmailType::class;
    }

    /**
     * @inheritdoc
     */
    public function getBlockPrefix()
    {
        return 'custom_email';
    }

    /**
     * @inheritdoc
     */
    public function transform($value)
    {
        if (is_null($value)) {
            return null;
        }

        if ($value instanceof Email) {
            return $value->toString();
        }

        throw new TransformationFailedException();
    }

    /**
     * @inheritdoc
     */
    public function reverseTransform($value)
    {
        if (is_null($value)) {
            return null;
        }

        if (is_string($value)) {
            return Email::fromString($value);
        }

        throw new TransformationFailedException();
    }
}
