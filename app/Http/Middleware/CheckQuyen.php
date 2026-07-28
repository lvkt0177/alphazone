<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckQuyen
{
    public function handle(Request $request, Closure $next, string $chucNangKey, string $hanhDong = 'xem'): Response
    {
        if (! hasQuyen($chucNangKey, $hanhDong)) {
            abort(403, 'Bạn không có quyền truy cập chức năng này.');
        }

        return $next($request);
    }
}