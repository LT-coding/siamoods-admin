<?php

namespace App\Rules;

use App\Enums\StatusTypes;
use App\Models\Subscriber;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class UniqueSubscriberEmail implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  Closure(string): PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        //
    }

    public function passes($attribute, $value): bool
    {
        // Check if the email exists in the subscribers table
        return !Subscriber::query()->where(['email' => $value, 'status' => StatusTypes::active->value])->exists();
    }

    public function message(): string
    {
        return 'Նշված էլ․ հասցեն արդեն բաժանորդագրված է։';
    }
}
