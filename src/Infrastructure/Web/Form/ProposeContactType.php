<?php

namespace Contacts\Infrastructure\Web\Form;

use Contacts\Application\Contact\ProposeContact;
use Contacts\Domain\Contact\Contact;
use Contacts\Domain\Contact\ContactId;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\DataMapperInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints as Assert;

class ProposeContactType extends AbstractType implements DataMapperInterface
{
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

    }

    /**
     * @inheritdoc
     */
    public function mapFormsToData($forms, &$data)
    {
        $forms = iterator_to_array($forms);

        $data = new ProposeContact(
            ContactId::generate(),
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
