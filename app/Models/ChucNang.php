<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ChucNang extends Model
{
    protected $table = 'chuc_nangs';

    protected $fillable = [
        'key',
        'ten',
    ];

    public function userPermissions(): HasMany
    {
        return $this->hasMany(UserPermission::class);
    }
}