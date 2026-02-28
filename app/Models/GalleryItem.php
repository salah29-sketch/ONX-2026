<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GalleryItem extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'description', 'category', 'image_path','show_in_homepage'];

}
