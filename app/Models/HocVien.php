<?php

namespace App\Models;

use App\Enum\GioiTinh;
use App\Enum\TrangThaiHocVien;
use App\Traits\SearchableUnaccented;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class HocVien extends Model
{
    use HasFactory, SearchableUnaccented;

    protected $table = 'hoc_viens';

    protected $fillable = [
        'ma_so', 'ho_ten', 'nickname', 'ngay_sinh', 'gioi_tinh', 'chieu_cao', 'can_nang', 'sdt',
        'truong', 'dia_chi', 'ghi_chu', 'avatar', 'trang_thai', 'tu_hoc_vien_trai_nghiem_id',
    ];

    protected $appends = ['avatar_url'];

    protected $casts = [
        'ngay_sinh' => 'date',
        'gioi_tinh' => GioiTinh::class,
        'trang_thai' => TrangThaiHocVien::class,
    ];

    public function coSos(): BelongsToMany
    {
        return $this->belongsToMany(CoSo::class, 'hoc_vien_co_so', 'hoc_vien_id', 'co_so_id')->withTimestamps();
    }

    public function traiNghiemGoc(): BelongsTo
    {
        return $this->belongsTo(HocVienTraiNghiem::class, 'tu_hoc_vien_trai_nghiem_id');
    }

    public function getAvatarUrlAttribute(): string
    {
        return $this->avatar
            ? Storage::url($this->avatar)
            : 'https://ui-avatars.com/api/?name='.urlencode($this->ho_ten).'&background=6C5DD3&color=fff&bold=true';
    }

    public function diemDanhs(): HasMany
    {
        return $this->hasMany(DiemDanh::class);
    }

    public function hocPhis(): HasMany
    {
        return $this->hasMany(HocPhi::class);
    }
}
