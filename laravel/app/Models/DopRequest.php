<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DopRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'admin_id',
        'work_order',
        'current_dop',
        'dop_to_update',
        'serial_number',
        'requester_name',
        'requester_branch',
        'reason',
        'case_type',
        'warranty_card_url',
        'invoice_url',
        'status',
        'submitted_at',
    ];

    protected $casts = [
        'submitted_at' => 'datetime',
        'current_dop' => 'date',
        'dop_to_update' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }
}
