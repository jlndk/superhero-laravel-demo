<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Superhero extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'alter_ego', 'first_appeared',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    // protected $casts = [
    //     'first_appeared' => 'int',
    // ];
}
