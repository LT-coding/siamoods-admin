<?php

namespace App\Rules;

use App\Models\User;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class UniqueWithoutTrashed implements Rule
{
    protected string $table;
    protected string $model;
    protected string $column;
    protected $ignoreId;

    public function __construct($table, $model, $column, $ignoreId)
    {
        $this->table = $table;
        $this->model = $model;
        $this->column = $column;
        $this->ignoreId = $ignoreId;
    }

    public function passes($attribute, $value): bool
    {
        $query = DB::table($this->table)
            ->where($this->column, $value)
            ->where('id', '<>', $this->ignoreId);

        // Exclude trashed records
        if (class_exists($this->model)) {
            $model = new $this->model;
            if (in_array('Illuminate\Database\Eloquent\SoftDeletes', class_uses($model))) {
                $query->whereNull('deleted_at');
            }
        }

        return $query->count() === 0;
    }

    public function message()
    {
        return 'The :attribute has already been taken.';
    }
}
