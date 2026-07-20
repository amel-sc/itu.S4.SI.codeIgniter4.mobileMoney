<?php

namespace App\Validation;

class CommentaireRules
{
    public function text_not_empty($value): bool
    {
        return trim($value) !== "";
    }
}