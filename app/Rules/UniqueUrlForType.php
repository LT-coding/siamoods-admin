<?php

namespace App\Rules;

use App\Models\Meta;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Database\Eloquent\Model;

class UniqueUrlForType implements Rule
{
    protected string $type;
    protected mixed $ignoreId;

    public function __construct($type, $ignoreId)
    {
        $this->type = $type;
        $this->ignoreId = $ignoreId;
    }

    public function passes($attribute, $value): bool
    {
        // Check if the URL is unique within the same type
        $query = Meta::query()
            ->where('type', $this->type)
            ->where('url', $value);

        if (!is_null($this->ignoreId)) {
            $query->where('model_id', '!=', $this->ignoreId);
        }

        return $query->count() === 0;
    }

    public function message(): string
    {
        return 'URL-ը չի կարող կրկնվել';
    }
}
