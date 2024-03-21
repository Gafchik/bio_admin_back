<?php

namespace App\Http\Classes\LogicalModels\Contacts;

use App\Http\Classes\Structure\CDateTime;
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
    public function edit(array $data): void
    {
        $this->contacts->getConnection()
            ->transaction(function () use ($data) {
                $this->contacts
                    ->where('id',$data['id'])
                    ->update([
                        'type' => $data['type'],
                        'email' => $data['email'],
                        'phone' => $data['phone'],
                        'url' => $data['url'],
                        'social_type' => $data['social_type'],
                        'status' => $data['status'],
                        'position' => $data['position'],
                        'updated_at' => CDateTime::getCurrentDate(),
                    ]);
                foreach ($data['lang'] as $lang => $fields)
                {
                    if(!empty($fields)){
                        $this->contactTranslations->updateOrCreate(
                            [
                                'contact_id' => $data['id'],
                                'locale' => $lang,
                            ],
                            [
                                'title' => $fields['title'] ?? null,
                                'address' => $fields['address'] ?? null,
                            ]
                        );
                    }
                }
            });
    }
    public function add(array $data): void
    {
        $this->contacts->getConnection()
            ->transaction(function () use ($data) {
                $id = $this->contacts->insertGetId([
                        'type' => $data['type'],
                        'email' => $data['email'],
                        'phone' => $data['phone'],
                        'url' => $data['url'],
                        'social_type' => $data['social_type'],
                        'status' => $data['status'],
                        'position' => $data['position'],
                        'created_at' => CDateTime::getCurrentDate(),
                        'updated_at' => CDateTime::getCurrentDate(),
                    ]);
                foreach ($data['lang'] as $lang => $fields)
                {
                    if(!empty($fields)){
                        $this->contactTranslations->updateOrCreate(
                            [
                                'contact_id' => $id,
                                'locale' => $lang,
                            ],
                            [
                                'title' => $fields['title'] ?? null,
                                'address' => $fields['address'] ?? null,
                            ]
                        );
                    }
                }
            });
    }
    public function delete(int $id): void
    {
        $this->contacts->getConnection()
            ->transaction(function () use ($id) {
                $this->contacts->where('id',$id)->delete();
                $this->contactTranslations->where('contact_id',$id)->delete();
            });
    }
}
