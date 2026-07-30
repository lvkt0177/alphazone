<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Enum\RoleUser;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'ho_ten',
        'password',
        'role',
        'giao_vien_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'role' => RoleUser::class,
        ];
    }

    private ?array $quyenMapCache = null;

    public function giaoVien(): BelongsTo
    {
        return $this->belongsTo(GiaoVien::class, 'giao_vien_id');
    }

    public function permissions(): HasMany
    {
        return $this->hasMany(UserPermission::class);
    }
   
    public function quyenMap(): array
    {
        if ($this->quyenMapCache !== null) {
            return $this->quyenMapCache;
        }

        $map = [];
        foreach ($this->permissions()->with('chucNang')->get() as $quyen) {
            if ($quyen->chucNang) {
                $map[$quyen->chucNang->key] = [
                    'xem' => (bool) $quyen->xem,
                    'them' => (bool) $quyen->them,
                    'sua' => (bool) $quyen->sua,
                    'xoa' => (bool) $quyen->xoa,
                ];
            }
        }

        return $this->quyenMapCache = $map;
    }

    public function hasQuyen(string $chucNangKey, string $hanhDong = 'xem'): bool
    {
        if ($this->role === RoleUser::ADMIN) {
            return true;
        }

        return $this->quyenMap()[$chucNangKey][$hanhDong] ?? false;
    }
}