<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Option extends Model
{
    use HasFactory;

    protected $fillable = [
        'title'
    ];

    public function optionValues(): HasMany
    {
        return $this->hasMany(OptionValue::class);
    }
}
