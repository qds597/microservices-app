<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class Roles extends Model
{
    use HasFactory;
    protected $fillable = [
        'name_roles',
    ];
}