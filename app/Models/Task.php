<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'description', 'status_id', 'severity_id',
        'developer_id', 'created_by', 'start_date', 'due_date', 'finish_date',
    ];

    public function status() { return $this->belongsTo(Status::class); }
    public function severity() { return $this->belongsTo(Severity::class); }
    public function developer() { return $this->belongsTo(User::class, 'developer_id'); }
    public function creator() { return $this->belongsTo(User::class, 'created_by'); }
    public function comments() { return $this->hasMany(Comment::class); }
}
