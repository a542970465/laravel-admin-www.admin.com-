<?php

namespace App\Admin\Entitys;

use Illuminate\Database\Eloquent\Model;


class Movie extends Model
{
    const TABLE      = 'movies';
    protected $table = Movie::TABLE;
}
