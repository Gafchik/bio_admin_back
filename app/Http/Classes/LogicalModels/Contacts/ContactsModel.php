<?php

namespace App\Http\Classes\LogicalModels\Contacts;

use App\Models\MySql\Biodeposit\{
    Dic_contacts_social_type,
    Dic_contacts_type,
    Contacts,
    Contact_translations,
};

class ContactsModel
{
    public function __construct(
        private Dic_contacts_type $dicContactsType,
        private Dic_contacts_social_type $dicContactsSocialType,
        private Contacts $contacts,
        private Contact_translations $contactTranslations,
    ){}
    public function getContactsInfo(): array
    {
        return [
            'dic_contacts_type' => $this->dicContactsType->get()->toArray(),
            'dic_contacts_social_type' => $this->dicContactsSocialType->get()->toArray(),
            'contacts' => $this->contacts->get()->toArray(),
            'contact_translations' => $this->contactTranslations->get()->toArray(),
        ];
    }
}
