<?php

namespace App\Http\Classes\Helpers;

use Illuminate\Support\Facades\Hash;

final class PasswordHashHelper
{
    public static function generatePasswordHash(string $password): string
    {
        // Генерация хеша с указанием стоимости и собственной соли
        $cost = 10; // Настройте стоимость по вашим потребностям
        $salt = 'your_unique_salt_here'; // Замените на свою уникальную соль

        return Hash::make($password, [
            'rounds' => $cost,
            'salt' => $salt,
        ]);
    }
}
