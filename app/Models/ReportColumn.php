<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportColumn extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'db_column', 'class', 'description', 'show_total', 'published', 'user_id'];
}
