<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaloonService extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'saloon_id', 'status'];
}
