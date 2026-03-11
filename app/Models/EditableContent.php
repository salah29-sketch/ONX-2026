<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EditableContent extends Model
{
    protected $table = 'editable_contents';

    protected $fillable = [
        'key',
        'locale',
        'content',
    ];
}
