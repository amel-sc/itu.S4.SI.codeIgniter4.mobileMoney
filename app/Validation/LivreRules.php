<?php

namespace App\Validation;

class LivreRules
{
    public function year_not_future($value): bool
    {
        return $value <= date('Y');
    }
}