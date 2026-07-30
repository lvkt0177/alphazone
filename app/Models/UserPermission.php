<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserPermission extends Model
{
    protected $table = 'user_permissions';

    protected $fillable = [
        'user_id',
        'chuc_nang_id',
        'xem',
        'them',
        'sua',
        'xoa',
    ];

    protected $casts = [
        'xem' => 'boolean',
        'them' => 'boolean',
        'sua' => 'boolean',
        'xoa' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function chucNang(): BelongsTo
    {
        return $this->belongsTo(ChucNang::class);
    }
}
