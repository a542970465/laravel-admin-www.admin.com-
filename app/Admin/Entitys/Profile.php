<?php

namespace App\Admin\Entitys;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    //
    const TABLE = 'profiles';
    protected $table = Profile::TABLE;

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
