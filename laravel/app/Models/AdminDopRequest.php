<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminDopRequest extends Model
{
    use HasFactory;

    protected $table = 'admin_dop_requests';

    protected $fillable = [
        'admin_id',
        'work_order',
        'current_dop',
        'dop_to_update',
        'serial_number',
        'reason',
        'case_type',
        'warranty_card_url',
        'invoice_url',
        'status',
        'submitted_at',
    ];

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }
}
