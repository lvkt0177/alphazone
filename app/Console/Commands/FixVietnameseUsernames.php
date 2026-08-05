<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class FixVietnameseUsernames extends Command
{
    protected $signature = 'users:fix-vietnamese-usernames {--apply : Thực sự cập nhật DB, mặc định chỉ xem trước (dry-run)}';

    protected $description = 'Rà & sửa lại username bị sót dấu tiếng Việt do bug NFC/NFD (không đổi mật khẩu)';

    public function handle(): int
    {
        $apply = (bool) $this->option('apply');

        $allUsers = User::orderBy('id')->get();
        $rows = [];
        $updates = [];

        foreach ($allUsers as $user) {
            $cleaned = str_replace(' ', '', remove_vietnamese_accents($user->name));

            if ($cleaned === $user->name) {
                continue;
            }

            $newName = $cleaned;
            $i = 2;

            while (User::where('name', $newName)->where('id', '!=', $user->id)->exists()) {
                $newName = $cleaned.$i;
                $i++;
            }

            $rows[] = [$user->id, $user->name, $newName];
            $updates[] = ['id' => $user->id, 'old' => $user->name, 'new' => $newName];
        }

        if (empty($rows)) {
            $this->info('Không có username nào bị lỗi dấu tiếng Việt.');

            return self::SUCCESS;
        }

        $this->table(['ID', 'Username cũ (lỗi)', 'Username mới (đề xuất)'], $rows);

        if (! $apply) {
            $this->warn('Đây là chế độ xem trước — CHƯA cập nhật gì cả.');
            $this->line('Chạy lại kèm --apply để thực sự cập nhật: php artisan users:fix-vietnamese-usernames --apply');

            return self::SUCCESS;
        }

        if (! $this->confirm('Xác nhận cập nhật '.count($updates).' tài khoản như bảng trên?')) {
            $this->info('Đã huỷ, không có gì thay đổi.');

            return self::SUCCESS;
        }

        DB::transaction(function () use ($updates) {
            foreach ($updates as $u) {
                User::where('id', $u['id'])->update(['name' => $u['new']]);
            }
        });

        $this->info('Đã cập nhật xong '.count($updates).' tài khoản.');

        return self::SUCCESS;
    }
}