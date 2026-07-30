@if ($ga->so_do && (!empty($ga->so_do['objects']) || !empty($ga->so_do['arrows'])))
    <div class="giaoan-thumb">
        <svg viewBox="0 0 1040 600" preserveAspectRatio="xMidYMid slice">
            <rect x="0" y="0" width="1040" height="600" fill="#4d8a35"></rect>
            <rect x="40" y="40" width="960" height="520" fill="#4d8a35"></rect>
            @for ($i = 0; $i < 16; $i++)
                @if ($i % 2 === 0)
                    <rect x="{{ 40 + $i * 60 }}" y="40" width="60" height="520" fill="#5a9c3f"></rect>
                @endif
            @endfor
            <rect x="40" y="40" width="960" height="520" fill="none" stroke="#ffffff" stroke-width="3"></rect>
            <line x1="520" y1="40" x2="520" y2="560" stroke="#ffffff" stroke-width="2.5">
            </line>
            <circle cx="520" cy="300" r="70" fill="none" stroke="#ffffff" stroke-width="2"></circle>
            <circle cx="520" cy="300" r="4" fill="#ffffff"></circle>
            <path d="M 40 120 A 192 192 0 0 1 40 480" fill="none" stroke="#ffffff" stroke-width="2"></path>
            <path d="M 1000 120 A 192 192 0 0 0 1000 480" fill="none" stroke="#ffffff" stroke-width="2"></path>
            <circle cx="280" cy="300" r="4" fill="#ffffff"></circle>
            <circle cx="760" cy="300" r="4" fill="#ffffff"></circle>
            <rect x="24" y="255" width="16" height="90" fill="none" stroke="#ffffff" stroke-width="2"></rect>
            <rect x="1000" y="255" width="16" height="90" fill="none" stroke="#ffffff" stroke-width="2">
            </rect>
            {!! \App\Support\SoDoRenderer::render($ga->so_do, $mauSac) !!}
        </svg>
    </div>
@else
    <span class="text-2">—</span>
@endif
