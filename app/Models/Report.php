<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Report extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'db_table', 'sort_by', 'description', 'published', 'user_id',
        'show_meta', 'show_print_user', 'show_print_date'];

    public function columns(): HasMany
    {
        return $this->hasMany(ReportColumn::class, 'report_id', 'id');
    }

    public function params(): HasMany
    {
        return $this->hasMany(ReportParam::class, 'report_id', 'id');
    }
    
}
