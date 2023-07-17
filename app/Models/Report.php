<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'db_table', 'sort_by', 'description', 'published', 'user_id',
        'show_meta', 'show_print_user', 'show_print_date'];
}
