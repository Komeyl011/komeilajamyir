<?php

namespace App\Models\CafeMenuApi;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ApiModel extends Model
{
    protected static string $tablePrefix = 'api_';

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->table = static::$tablePrefix . Str::snake(class_basename($this));
    }
}
