<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'title',
        'description',
        'status'
    ];

    public const STATUSES = [
        'new'       => 'Новая',
        'progress'  => 'В работе',
        'complete'  => 'Выполнена'
    ];
}
