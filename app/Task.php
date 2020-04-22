<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes; // SoftDelete

class Task extends Model
{
    protected $table = "tasks";

    // Mass Insert
    protected $fillable = ['descricao', 'done', 'user_id'];

    // Default Value de um campos
    protected $attributes = [
        'done' => false
    ];

    // SoftDelete
    // use SoftDeletes;
}
