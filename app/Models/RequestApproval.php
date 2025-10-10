<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RequestApproval extends Model
{
    protected $fillable = [
        'module_type', 'module_id', 'approved_by', 'status', 'note', 'approved_at'
    ];

    public function approver() { return $this->belongsTo(User::class, 'approved_by'); }
}

