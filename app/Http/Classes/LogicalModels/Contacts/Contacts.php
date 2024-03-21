<?php

namespace App\Http\Classes\LogicalModels\Contacts;

use App\Http\Classes\Helpers\TransformArray\TransformArrayHelper;
use App\Http\Classes\Structure\Lang;

class Contacts
{
    public function __construct(
        private ContactsModel $model,
    ){}
    public function getContactsInfo(): array
    {
        $data = $this->model->getContactsInfo();
        $contacts = $this->prepareContacts(
            contacts: $data['contacts'],
            contact_translations: $data['contact_translations'],
        );
        return [
            'contacts' => $contacts,
            'dic_contacts_type' => $data['dic_contacts_type'],
            'dic_contacts_social_type' => $data['dic_contacts_social_type'],
        ];
    }
    private function prepareContacts(array $contacts, array $contact_translations): array
    {
        $result = [];
        foreach ($contacts as $contact){
            $labelRu = TransformArrayHelper::callbackSearchFirstInArray(
                $contact_translations,
                function ($trans) use ($contact) {
                    return $contact['id'] === $trans['contact_id']
                        && $trans['locale'] === Lang::RUS;
                }
            );
            $labelEn = TransformArrayHelper::callbackSearchFirstInArray(
                $contact_translations,
                function ($trans) use ($contact) {
                    return $contact['id'] === $trans['contact_id']
                        && $trans['locale'] === Lang::ENG;
                }
            );
            $result[] = [
                'title_ru' => $labelRu['title'] ?? null,
                'title_en' => $labelEn['title'] ?? null,
                'address_ru' => $labelRu['address'] ?? null,
                'address_en' => $labelEn['address'] ?? null,
                ...$contact,
            ];
        }
        return $result;
    }
    public function edit(array $data): void
    {
        $this->model->edit($data);
    }
    public function add(array $data): void
    {
        $this->model->add($data);
    }
    public function delete(array $data): void
    {
        $this->model->delete($data['id']);
    }
}
