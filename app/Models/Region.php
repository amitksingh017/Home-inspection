<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Region extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'text',
        'text_markdown',
        'short_description'
    ];
}
