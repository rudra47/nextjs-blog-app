<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Saloon extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'phone', 'address', 'latitude', 'longitude', 'status'];

    public function tags() {
        return $this->belongsToMany(Tag::class);
    }
}
