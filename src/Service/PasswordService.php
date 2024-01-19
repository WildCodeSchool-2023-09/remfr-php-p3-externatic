<?php

namespace App\Service;

class PasswordService
{
    public function checkPasswordStrength(string $password): bool
    {
        $validate = true;

        // Il y a au moins une majuscule
        if (!(preg_match('/[A-Z]/', $password))) {
            $validate = false;
        }

        // Il y a au moins une minuscule
        if (!(preg_match('/[a-z]/', $password))) {
            $validate = false;
        }

        // Il y a au moins un chiffre
        if (!(preg_match('/[0-9]/', $password))) {
            $validate = false;
        }

        // Il y a au moins un caractère spécial
        if (!(preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $password))) {
            $validate = false;
        }

        return $validate;
    }
}
