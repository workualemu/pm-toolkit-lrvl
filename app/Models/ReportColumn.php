<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportColumn extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'report_id', 'db_column', 'class', 'description', 'show_total', 'published', 'user_id'];

    public static function scopeGetByReport($query, $report_id)
    {
        return $query->where('report_id', '=', $report_id);
    }
}
