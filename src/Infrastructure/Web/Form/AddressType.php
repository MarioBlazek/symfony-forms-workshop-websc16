<?php

namespace Contacts\Infrastructure\Web\Form;

use Contacts\Domain\Value\Address;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\DataMapperInterface;
use Symfony\Component\Form\Exception;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;

class AddressType extends AbstractType implements DataMapperInterface
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('street', TextType::class, [
            'required' => false,
        ]);

        $builder->add('postalCode', TextType::class, [
            'required' => false,
        ]);

        $builder->add('city', TextType::class, [
            'required' => false,
        ]);

        $builder->add('countryCode', CountryType::class, [
            'required' => false,
        ]);

        $builder->setDataMapper($this);
    }

    /**
     * @inheritdoc
     */
    public function mapDataToForms($data, $forms)
    {
        $forms = iterator_to_array($forms);

        if (!$data instanceof Address) {
            return;
        }

        $forms['street']->setData($data->getStreet());
        $forms['postalCode']->setData($data->getPostalCode());
        $forms['city']->setData($data->getCity());
        $forms['countryCode']->setData($data->getCountryCode());
    }

    /**
     * @inheritdoc
     */
    public function mapFormsToData($forms, &$data)
    {
        $forms = iterator_to_array($forms);

        $isEmpty = function($empty, FormInterface $form) {
            return $empty && $form->isEmpty();
        };


        if(array_reduce($forms, $isEmpty, true)) {
            $data = null;

            return;
        }

        $data = new Address(
            $forms['street']->getData(),
            $forms['postalCode']->getData(),
            $forms['city']->getData(),
            $forms['countryCode']->getData()
        );
    }
}
