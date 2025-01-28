<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Report extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'description', 'published', 'user_id',
        'show_meta', 'show_print_user', 'show_print_date', 'select_clause', 'from_clause', 
        'where_clause', 'order_clause', 'groupby_clause', 'having_clause', 'project_id'];

    public function columns(): HasMany
    {
        return $this->hasMany(ReportColumn::class, 'report_id', 'id');
    }

    public function params(): HasMany
    {
        return $this->hasMany(ReportParam::class, 'report_id', 'id');
    }
    
}
