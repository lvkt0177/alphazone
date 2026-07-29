@push('styles')
    <link rel="stylesheet" href="{{ asset('css/pages/sodo-designer.css') }}">
@endpush

<div class="sodo-wrap">
    <div class="sodo-palette" id="sodoPalette">
        <div class="sodo-palette-group">
            <div class="sodo-palette-label">Nấm</div>
            <div class="sodo-palette-row">
                <div class="sodo-palette-item" draggable="true" data-type="nam" data-color="blue" title="Nấm xanh biển">
                    <svg viewBox="0 0 34 34"><circle cx="17" cy="17" r="13" fill="#0ffdfd"></circle><circle cx="17" cy="17" r="4" fill="#111111"></circle></svg>
                </div>
                <div class="sodo-palette-item" draggable="true" data-type="nam" data-color="green" title="Nấm xanh lá">
                    <svg viewBox="0 0 34 34"><circle cx="17" cy="17" r="13" fill="#0af15f"></circle><circle cx="17" cy="17" r="4" fill="#111111"></circle></svg>
                </div>
                <div class="sodo-palette-item" draggable="true" data-type="nam" data-color="yellow" title="Nấm vàng">
                    <svg viewBox="0 0 34 34"><circle cx="17" cy="17" r="13" fill="#fffc32"></circle><circle cx="17" cy="17" r="4" fill="#111111"></circle></svg>
                </div>
                <div class="sodo-palette-item" draggable="true" data-type="nam" data-color="orange" title="Nấm cam">
                    <svg viewBox="0 0 34 34"><circle cx="17" cy="17" r="13" fill="#ffcf66"></circle><circle cx="17" cy="17" r="4" fill="#111111"></circle></svg>
                </div>
            </div>
        </div>

        <div class="sodo-palette-group">
            <div class="sodo-palette-label">Côn</div>
            <div class="sodo-palette-row">
                <div class="sodo-palette-item" draggable="true" data-type="con" data-color="blue" title="Côn xanh biển">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" style="color:#0ffdfd">
                        <path d="M0 0h16v16H0z" fill="none"></path>
                        <path fill="currentColor" d="M7.03 1.88c.252-1.01 1.688-1.01 1.94 0l2.905 11.62H14a.5.5 0 0 1 0 1H2a.5.5 0 0 1 0-1h2.125z"></path>
                    </svg>
                </div>
                <div class="sodo-palette-item" draggable="true" data-type="con" data-color="green" title="Côn xanh lá">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" style="color:#0af15f">
                        <path d="M0 0h16v16H0z" fill="none"></path>
                        <path fill="currentColor" d="M7.03 1.88c.252-1.01 1.688-1.01 1.94 0l2.905 11.62H14a.5.5 0 0 1 0 1H2a.5.5 0 0 1 0-1h2.125z"></path>
                    </svg>
                </div>
                <div class="sodo-palette-item" draggable="true" data-type="con" data-color="yellow" title="Côn vàng">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" style="color:#fffc32">
                        <path d="M0 0h16v16H0z" fill="none"></path>
                        <path fill="currentColor" d="M7.03 1.88c.252-1.01 1.688-1.01 1.94 0l2.905 11.62H14a.5.5 0 0 1 0 1H2a.5.5 0 0 1 0-1h2.125z"></path>
                    </svg>
                </div>
                <div class="sodo-palette-item" draggable="true" data-type="con" data-color="orange" title="Côn cam">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" style="color:#ffcf66">
                        <path d="M0 0h16v16H0z" fill="none"></path>
                        <path fill="currentColor" d="M7.03 1.88c.252-1.01 1.688-1.01 1.94 0l2.905 11.62H14a.5.5 0 0 1 0 1H2a.5.5 0 0 1 0-1h2.125z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="sodo-palette-group">
            <div class="sodo-palette-label">Người / Bóng</div>
            <div class="sodo-palette-row">
                <div class="sodo-palette-item" draggable="true" data-type="nguoi" data-color="blue" title="Người xanh biển">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" style="color:#0ffdfd">
                        <path d="M0 0h24v24H0z" fill="none"></path>
                        <path fill="currentColor" d="M12 2a2 2 0 0 1 2 2a2 2 0 0 1-2 2a2 2 0 0 1-2-2a2 2 0 0 1 2-2m-1.5 5h3a2 2 0 0 1 2 2v5.5H14V22h-4v-7.5H8.5V9a2 2 0 0 1 2-2"></path>
                    </svg>
                </div>
                <div class="sodo-palette-item" draggable="true" data-type="nguoi" data-color="green" title="Người xanh lá">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" style="color:#0af15f">
                        <path d="M0 0h24v24H0z" fill="none"></path>
                        <path fill="currentColor" d="M12 2a2 2 0 0 1 2 2a2 2 0 0 1-2 2a2 2 0 0 1-2-2a2 2 0 0 1 2-2m-1.5 5h3a2 2 0 0 1 2 2v5.5H14V22h-4v-7.5H8.5V9a2 2 0 0 1 2-2"></path>
                    </svg>
                </div>
                <div class="sodo-palette-item" draggable="true" data-type="nguoi" data-color="yellow" title="Người vàng">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" style="color:#fffc32">
                        <path d="M0 0h24v24H0z" fill="none"></path>
                        <path fill="currentColor" d="M12 2a2 2 0 0 1 2 2a2 2 0 0 1-2 2a2 2 0 0 1-2-2a2 2 0 0 1 2-2m-1.5 5h3a2 2 0 0 1 2 2v5.5H14V22h-4v-7.5H8.5V9a2 2 0 0 1 2-2"></path>
                    </svg>
                </div>
                <div class="sodo-palette-item" draggable="true" data-type="nguoi" data-color="orange" title="Người cam">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" style="color:#ffcf66">
                        <path d="M0 0h24v24H0z" fill="none"></path>
                        <path fill="currentColor" d="M12 2a2 2 0 0 1 2 2a2 2 0 0 1-2 2a2 2 0 0 1-2-2a2 2 0 0 1 2-2m-1.5 5h3a2 2 0 0 1 2 2v5.5H14V22h-4v-7.5H8.5V9a2 2 0 0 1 2-2"></path>
                    </svg>
                </div>
                <div class="sodo-palette-item" draggable="true" data-type="bong" data-color="" title="Bóng">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64">
                        <path d="M0 0h64v64H0z" fill="none"></path>
                        <circle cx="32" cy="32" r="29.3" fill="#ffffff"></circle>
                        <path fill="#4a4e51" d="M61.9 32c0-.7.2-10.9-5.8-17.5c-.3-.6-1.5-3-5.6-5.9C47.8 6.5 45 5 44.7 4.8S39.4 2 33.4 2c-.5 0-.9 0-1.4.1c-4.6-.1-8.8 1.1-11.9 2.5c-3.2 1.4-5.3 2.8-5.5 3c-3.4 1.9-9.9 9.5-10.4 13.6c-2.1 2.6-3.8 14.5 0 21.7c2.7 10 12.7 15 13.5 15.4c.5.3 5.9 3.7 12.6 3.7h.9c.6.1 1.1.1 1.7.1c7.2 0 18-5.1 20.2-9.1c6.2-4.6 9.4-16.2 8.8-21M17.8 47.1c-2.9-4.6-4.5-10.7-4.9-12.1c.9-1.4 5.4-8 7.9-10c1.4.3 7.5 1.4 13.2 2.4c.7 1.9 3.9 10 4.8 13.2c-1 1.2-4.9 5.7-8.7 9.2c-4.1.1-11-2.3-12.3-2.7m36-32.5c0 .4-.1 2-.9 3.9c-1.5-.8-5.3-2.4-10.6-2.7c-.8-1.2-3.8-5.3-8.5-8.1c.6-1.3 1.5-2.8 2.1-3.3c.2 0 .4-.1.8-.1c2.5 0 6.9 1.7 7.3 1.8c.4.2 8.3 4.4 9.8 8.5M11.8 34c-3.4-.6-5.5-1.6-6.1-2c-1.3-4.6-.2-9.6-.1-10.3c1.3-2.2 4.8-8 7.2-9.1c2.4-.5 5.5.1 6.7.4c-.1 1.6-.3 6.1.3 10.9c-2.6 2.2-6.9 8.5-8 10.1M31.7 3.5c.8.1 1.9.2 2.7.5c-.8 1-1.6 2.5-1.9 3.3c-1.6.3-7.5 1.4-12.2 4.4c-.9-.2-3.8-.9-6.5-.7c.7-1.3 1.7-2.2 1.8-2.3c.3-.3 7.4-5.3 16.1-5.2m19.1 38.1c-1.2 0-5.7-.3-10.6-1.5c-.9-3.3-4.1-11.4-4.8-13.3c3.1-4.4 6.1-8.5 6.9-9.7c5.7.4 9.7 2.5 10.5 2.9c3.3 5.3 4 10.7 4.1 11.6c-1.8 5.5-5.2 9.2-6.1 10M3.7 28.5c.1 1.3.3 2.6.7 3.9c-.3.9-.6 1.8-.7 2.7c-.3-2.3-.3-4.6 0-6.6M18.5 57l-.4.6zc-2.5-1.2-4.4-4-5.2-5.1c1.5-1.5 3.4-2.9 4.1-3.4c1.6.6 8.3 2.8 12.6 2.8c.7 1 3.1 4 6 6.4c-1.8 1.8-4.4 2.6-4.9 2.8c-6.8.2-12.6-3.5-12.6-3.5m16.3 3.4c.9-.5 1.9-1.2 2.7-2.1c1.3-.2 6.9-1.1 11.9-4.8c.3 0 .9.1 1.5.1c-3.1 2.9-10.5 6.2-16.1 6.8M50.2 52c1.8-4.7 1.7-8.3 1.6-9.4c1-1 4.4-4.6 6.3-10.1c1 .2 1.7.4 2 .6c.1.4.3 1.3.2 2.7c-.8 5-3.4 12.6-8.1 15.9c-.5.3-1.3.4-2 .3"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="sodo-palette-group">
            <div class="sodo-palette-label">Nhân sự</div>
            <div class="sodo-palette-row">
                <div class="sodo-palette-item" draggable="true" data-type="giaovien" data-color="" title="Thầy giáo">
                    <svg viewBox="0 0 34 34"><circle cx="17" cy="17" r="13" fill="#111111"></circle><text x="17" y="22" font-size="14" fill="#ffffff" text-anchor="middle">C</text></svg>
                </div>
                <div class="sodo-palette-item" draggable="true" data-type="hotro" data-color="" title="Hỗ trợ">
                    <svg viewBox="0 0 34 34"><circle cx="17" cy="17" r="13" fill="#111111"></circle><text x="17" y="22" font-size="14" fill="#ffffff" text-anchor="middle">A</text></svg>
                </div>
            </div>
        </div>

        <div class="text-2 sodo-palette-hint">Kéo vật dụng vào sân. Chuột phải vào vật đã đặt để xoá.</div>
    </div>

    <div class="sodo-canvas-wrap">
        <svg id="gaCanvas" viewBox="0 0 1040 600" class="sodo-canvas">
            <rect x="40" y="40" width="960" height="520" fill="#4d8a35"></rect>
            @for ($i = 0; $i < 16; $i++)
                @if ($i % 2 === 0)
                    <rect x="{{ 40 + $i * 60 }}" y="40" width="60" height="520" fill="#5a9c3f"></rect>
                @endif
            @endfor
            <rect x="40" y="40" width="960" height="520" fill="none" stroke="#ffffff" stroke-width="3"></rect>
            <line x1="520" y1="40" x2="520" y2="560" stroke="#ffffff" stroke-width="2.5"></line>
            <circle cx="520" cy="300" r="70" fill="none" stroke="#ffffff" stroke-width="2"></circle>
            <circle cx="520" cy="300" r="4" fill="#ffffff"></circle>
            <path d="M 40 40 A 278 278 0 0 1 40 560" fill="none" stroke="#ffffff" stroke-width="2"></path>
            <path d="M 1000 40 A 278 278 0 0 0 1000 560" fill="none" stroke="#ffffff" stroke-width="2"></path>
            <circle cx="280" cy="300" r="4" fill="#ffffff"></circle>
            <circle cx="760" cy="300" r="4" fill="#ffffff"></circle>
            <rect x="24" y="255" width="16" height="90" fill="none" stroke="#ffffff" stroke-width="2"></rect>
            <rect x="1000" y="255" width="16" height="90" fill="none" stroke="#ffffff" stroke-width="2"></rect>

            <g id="gaObjectsLayer"></g>
            <g id="gaArrowsLayer"></g>
        </svg>
    </div>
</div>

<div id="gaContextMenu" class="sodo-context-menu">
    <button type="button" id="gaContextMenuDelete"><i class="ri-delete-bin-line"></i> Xoá</button>
</div>

@push('scripts')
    <script src="{{ asset('js/pages/sodo-designer.js') }}"></script>
@endpush