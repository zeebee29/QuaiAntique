<?php
namespace App\Validator;

use Symfony\Component\Validator\Constraint;

#[\Attribute]
class RegexPassword extends Constraint
{
    public string $message = '8 caractères minimum avec au moins un chiffre, une lettre et un caractère spécial (#?!@$%^&*-).';
}