<?php

namespace App\Rules;

use Closure;
use DateTime;
use Illuminate\Contracts\Validation\ValidationRule;

class Birthday implements ValidationRule
{
    /**
     * Run the validation rule.
     */

    public $format = "m-d-Y";

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {

        $dt = DateTime::createFromFormat($this->format, $value);

        // https://www.php.net/manual/en/datetimeimmutable.getlasterrors.php
        if (!$dt || $dt::getLastErrors()) {
            $fail('The :attribute must be valid date of format: ' . $this->format);
        }
    }
}
