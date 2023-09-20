<?php
namespace App\Validator;

use Symfony\Component\Validator\Constraint;

#[\Attribute]
class RegexPhone extends Constraint
{
    public string $message = "Veuillez saisir un N° de téléphone valide ('+33' ou '0' suivi de 9 chiffres).";
}