<?php

namespace Modules\Voyager\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends \TCG\Voyager\Models\User
{
    use HasFactory;

    protected $fillable = [];
    
    protected static function newFactory()
    {
        return \Modules\Voyager\Database\factories\UserFactory::new();
    }
}
