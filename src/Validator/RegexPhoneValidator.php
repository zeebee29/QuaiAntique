<?php
//src/Validator/RegexPhoneValidator.php
namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

class RegexPhoneValidator extends ConstraintValidator
{
  private $phoneRegex;

  public function __construct(string $phoneRegex)
  {
    $this->phoneRegex = $phoneRegex;
  }

  public function validate(mixed $value, Constraint $constraint): void
  {
    if (!$constraint instanceof RegexPhone) {
        throw new UnexpectedTypeException($constraint, ContainsAlphanumeric::class);
    }

    // custom constraints should ignore null and empty values to allow
    // other constraints (NotBlank, NotNull, etc.) to take care of that
    if (null === $value || '' === $value) {
        return;
    }

    if (!is_string($value)) {
        // throw this exception if your validator cannot handle the passed type so that it can be marked as invalid
        throw new UnexpectedValueException($value, 'string');

        // separate multiple types using pipes
        // throw new UnexpectedValueException($value, 'string|int');
    }

    if (!preg_match($this->phoneRegex, $value)) {
      $this->context->buildViolation($constraint->message)
          ->addViolation();
    }
  }
}