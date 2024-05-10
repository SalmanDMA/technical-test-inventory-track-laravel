<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'availability',
        'image',
        'quantity'
    ];

    public function activities()
    {
        return $this->hasMany(Activity::class);
    }
}
