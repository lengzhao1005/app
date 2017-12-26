<?php

namespace App\Moldes;


use App\Models\Model;

class Category extends Model
{
    protected $fillable = [
        'name', 'description',
    ];
}
