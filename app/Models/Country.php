<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Country extends Model
{
    use HasFactory;

    protected $fillable = ['code', 'name'];

    public function statistics(): HasMany
    {
        return $this->hasMany(Statistics::class, 'country_id', 'id');
    }
}
