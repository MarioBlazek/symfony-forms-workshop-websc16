<?php

namespace Contacts\Infrastructure\Web\Form;

use Contacts\Domain\Value\PhoneNumber;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class PhoneNumberType extends AbstractType implements DataTransformerInterface
{
    public function buildForm(FormBuilderInterface $formBuilder, array $options)
    {
        $formBuilder->addModelTransformer($this);
    }
    /**
     * @inheritdoc
     */
    public function getParent()
    {
        return TextType::class;
    }

    /**
     * @inheritdoc
     */
    public function transform($value)
    {
        if (is_null($value)) {
            return null;
        }

        if ($value instanceof PhoneNumber) {
            return (string)$value;
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
            return PhoneNumber::fromString($value);
        }

        throw new TransformationFailedException();
    }
}
