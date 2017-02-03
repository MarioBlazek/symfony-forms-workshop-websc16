<?php

namespace Contacts\Infrastructure\Web\Form;

use Contacts\Application\Contact\ModifyContact;
use Contacts\Domain\Contact\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\DataMapperInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints as Assert;

class ModifyContactType extends AbstractType implements DataMapperInterface
{
    /**
     * @inheritdoc
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('submit', SubmitType::class, [
            'label' => 'Propose',
        ]);

        $builder->setDataMapper($this);
    }

    /**
     * @inheritdoc
     */
    public function mapDataToForms($data, $forms)
    {
        if (!$data instanceof Contact) {
            return;
        }

        $forms = iterator_to_array($forms);

        $forms['firstName']->setData($data->getFirstName());
        $forms['lastName']->setData($data->getLastName());
        $forms['dateOfBirth']->setData($data->getDateOfBirth());
        $forms['address']->setData($data->getAddress());
        $forms['email']->setData($data->getEmail());
        $forms['phoneNumber']->setData($data->getPhoneNumber());
        $forms['notes']->setData($data->getNotes());
        $forms['organizationId']->setData($data->getOrganizationId());
    }

    /**
     * @inheritdoc
     */
    public function mapFormsToData($forms, &$data)
    {
        if (!$data instanceof Contact) {
            return;
        }

        $forms = iterator_to_array($forms);

        $data = new ModifyContact(
            $data->getId(),
            [
                Contact::FIELD_FIRST_NAME => $forms['firstName']->getData(),
                Contact::FIELD_LAST_NAME => $forms['lastName']->getData(),
                Contact::FIELD_DATE_OF_BIRTH => $forms['dateOfBirth']->getData(),
                Contact::FIELD_EMAIL => $forms['email']->getData(),
                Contact::FIELD_ADDRESS => $forms['address']->getData(),
                Contact::FIELD_PHONE_NUMBER => $forms['phoneNumber']->getData(),
                Contact::FIELD_NOTES => $forms['notes']->getData(),
                Contact::FIELD_ORGANIZATION_ID => $forms['organizationId']->getData(),
            ]
        );
    }

    /**
     * @inheritdoc
     */
    public function getParent()
    {
        return GenericContactType::class;
    }
}
