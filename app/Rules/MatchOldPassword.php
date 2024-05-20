<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class MatchOldPassword implements Rule
{
    public function passes($attribute, $value): bool
    {
        $user = Auth::user();
        return Hash::check($value, $user->password);
    }

    public function message(): string
    {
        return 'Հին գաղտնաբառը սխալ է։';
    }
}
