<?php

namespace Main\Validation\Rules;

use Main\Models\User;
use Main\Models\Admin;
use Respect\Validation\Rules\AbstractRule;

class EmailAvailable extends AbstractRule
{
    
    public function validate($input)
    {
        return ! User::where('email', $input)->exists();
    }
}