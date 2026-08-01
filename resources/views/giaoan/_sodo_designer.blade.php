@push('styles')
    <link rel="stylesheet" href="{{ asset('css/pages/sodo-designer.css') }}">
@endpush

<div class="sodo-wrap">
    <div class="sodo-palette" id="sodoPalette">
        <div class="sodo-palette-top">
            <span class="sodo-palette-top-title">Vật dụng</span>
            <i class="ri-settings-3-line sodo-settings-icon" onclick="openModal('gaMauSacModal')" title="Cài đặt vật dụng"></i>
        </div>

        <div class="sodo-palette-group">
            <div class="sodo-palette-label">Nấm</div>
            <div class="sodo-palette-row">
                <div class="sodo-palette-item" draggable="true" data-type="nam" data-color="blue" title="Nấm xanh biển">
                    <svg viewBox="0 0 34 34">
                        <circle cx="17" cy="17" r="13" fill="{{ $mauSac['blue'] }}"></circle>
                        <circle cx="17" cy="17" r="4" fill="#111111"></circle>
                    </svg>
                </div>
                <div class="sodo-palette-item" draggable="true" data-type="nam" data-color="green" title="Nấm xanh lá">
                    <svg viewBox="0 0 34 34">
                        <circle cx="17" cy="17" r="13" fill="{{ $mauSac['green'] }}"></circle>
                        <circle cx="17" cy="17" r="4" fill="#111111"></circle>
                    </svg>
                </div>
                <div class="sodo-palette-item" draggable="true" data-type="nam" data-color="yellow" title="Nấm vàng">
                    <svg viewBox="0 0 34 34">
                        <circle cx="17" cy="17" r="13" fill="{{ $mauSac['yellow'] }}"></circle>
                        <circle cx="17" cy="17" r="4" fill="#111111"></circle>
                    </svg>
                </div>
                <div class="sodo-palette-item" draggable="true" data-type="nam" data-color="orange" title="Nấm cam">
                    <svg viewBox="0 0 34 34">
                        <circle cx="17" cy="17" r="13" fill="{{ $mauSac['orange'] }}"></circle>
                        <circle cx="17" cy="17" r="4" fill="#111111"></circle>
                    </svg>
                </div>
            </div>
        </div>

        <div class="sodo-palette-group">
            <div class="sodo-palette-label">Côn</div>
            <div class="sodo-palette-row">
                <div class="sodo-palette-item" draggable="true" data-type="con" data-color="blue" title="Côn xanh biển">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" style="color:{{ $mauSac['blue'] }}">
                        <path d="M0 0h16v16H0z" fill="none"></path>
                        <path fill="currentColor"
                            d="M7.03 1.88c.252-1.01 1.688-1.01 1.94 0l2.905 11.62H14a.5.5 0 0 1 0 1H2a.5.5 0 0 1 0-1h2.125z">
                        </path>
                    </svg>
                </div>
                <div class="sodo-palette-item" draggable="true" data-type="con" data-color="green" title="Côn xanh lá">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" style="color:{{ $mauSac['green'] }}">
                        <path d="M0 0h16v16H0z" fill="none"></path>
                        <path fill="currentColor"
                            d="M7.03 1.88c.252-1.01 1.688-1.01 1.94 0l2.905 11.62H14a.5.5 0 0 1 0 1H2a.5.5 0 0 1 0-1h2.125z">
                        </path>
                    </svg>
                </div>
                <div class="sodo-palette-item" draggable="true" data-type="con" data-color="yellow" title="Côn vàng">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" style="color:{{ $mauSac['yellow'] }}">
                        <path d="M0 0h16v16H0z" fill="none"></path>
                        <path fill="currentColor"
                            d="M7.03 1.88c.252-1.01 1.688-1.01 1.94 0l2.905 11.62H14a.5.5 0 0 1 0 1H2a.5.5 0 0 1 0-1h2.125z">
                        </path>
                    </svg>
                </div>
                <div class="sodo-palette-item" draggable="true" data-type="con" data-color="orange" title="Côn cam">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" style="color:{{ $mauSac['orange'] }}">
                        <path d="M0 0h16v16H0z" fill="none"></path>
                        <path fill="currentColor"
                            d="M7.03 1.88c.252-1.01 1.688-1.01 1.94 0l2.905 11.62H14a.5.5 0 0 1 0 1H2a.5.5 0 0 1 0-1h2.125z">
                        </path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="sodo-palette-group">
            <div class="sodo-palette-label">Người / Bóng</div>
            <div class="sodo-palette-row">
                <div class="sodo-palette-item" draggable="true" data-type="nguoi" data-color="" title="Người (X)">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 34 34">
                        <circle cx="17" cy="17" r="15" fill="#4d8a35"></circle>
                        <g transform="translate(17,17)" fill="#ffffff">
                            <rect x="-11" y="-2.5" width="22" height="5" rx="2.5" transform="rotate(45)"></rect>
                            <rect x="-11" y="-2.5" width="22" height="5" rx="2.5" transform="rotate(-45)"></rect>
                        </g>
                    </svg>
                </div>
                <div class="sodo-palette-item" draggable="true" data-type="bong" data-color="" title="Bóng">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64">
                        <path d="M0 0h64v64H0z" fill="none"></path>
                        <circle cx="32" cy="32" r="29.3" fill="#ffffff"></circle>
                        <path fill="#4a4e51"
                            d="M61.9 32c0-.7.2-10.9-5.8-17.5c-.3-.6-1.5-3-5.6-5.9C47.8 6.5 45 5 44.7 4.8S39.4 2 33.4 2c-.5 0-.9 0-1.4.1c-4.6-.1-8.8 1.1-11.9 2.5c-3.2 1.4-5.3 2.8-5.5 3c-3.4 1.9-9.9 9.5-10.4 13.6c-2.1 2.6-3.8 14.5 0 21.7c2.7 10 12.7 15 13.5 15.4c.5.3 5.9 3.7 12.6 3.7h.9c.6.1 1.1.1 1.7.1c7.2 0 18-5.1 20.2-9.1c6.2-4.6 9.4-16.2 8.8-21M17.8 47.1c-2.9-4.6-4.5-10.7-4.9-12.1c.9-1.4 5.4-8 7.9-10c1.4.3 7.5 1.4 13.2 2.4c.7 1.9 3.9 10 4.8 13.2c-1 1.2-4.9 5.7-8.7 9.2c-4.1.1-11-2.3-12.3-2.7m36-32.5c0 .4-.1 2-.9 3.9c-1.5-.8-5.3-2.4-10.6-2.7c-.8-1.2-3.8-5.3-8.5-8.1c.6-1.3 1.5-2.8 2.1-3.3c.2 0 .4-.1.8-.1c2.5 0 6.9 1.7 7.3 1.8c.4.2 8.3 4.4 9.8 8.5M11.8 34c-3.4-.6-5.5-1.6-6.1-2c-1.3-4.6-.2-9.6-.1-10.3c1.3-2.2 4.8-8 7.2-9.1c2.4-.5 5.5.1 6.7.4c-.1 1.6-.3 6.1.3 10.9c-2.6 2.2-6.9 8.5-8 10.1M31.7 3.5c.8.1 1.9.2 2.7.5c-.8 1-1.6 2.5-1.9 3.3c-1.6.3-7.5 1.4-12.2 4.4c-.9-.2-3.8-.9-6.5-.7c.7-1.3 1.7-2.2 1.8-2.3c.3-.3 7.4-5.3 16.1-5.2m19.1 38.1c-1.2 0-5.7-.3-10.6-1.5c-.9-3.3-4.1-11.4-4.8-13.3c3.1-4.4 6.1-8.5 6.9-9.7c5.7.4 9.7 2.5 10.5 2.9c3.3 5.3 4 10.7 4.1 11.6c-1.8 5.5-5.2 9.2-6.1 10M3.7 28.5c.1 1.3.3 2.6.7 3.9c-.3.9-.6 1.8-.7 2.7c-.3-2.3-.3-4.6 0-6.6M18.5 57l-.4.6zc-2.5-1.2-4.4-4-5.2-5.1c1.5-1.5 3.4-2.9 4.1-3.4c1.6.6 8.3 2.8 12.6 2.8c.7 1 3.1 4 6 6.4c-1.8 1.8-4.4 2.6-4.9 2.8c-6.8.2-12.6-3.5-12.6-3.5m16.3 3.4c.9-.5 1.9-1.2 2.7-2.1c1.3-.2 6.9-1.1 11.9-4.8c.3 0 .9.1 1.5.1c-3.1 2.9-10.5 6.2-16.1 6.8M50.2 52c1.8-4.7 1.7-8.3 1.6-9.4c1-1 4.4-4.6 6.3-10.1c1 .2 1.7.4 2 .6c.1.4.3 1.3.2 2.7c-.8 5-3.4 12.6-8.1 15.9c-.5.3-1.3.4-2 .3">
                        </path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="sodo-palette-group">
            <div class="sodo-palette-label">Nhân sự</div>
            <div class="sodo-palette-row">
                <div class="sodo-palette-item" draggable="true" data-type="giaovien" data-color=""
                    title="Thầy giáo">
                    <svg viewBox="0 0 34 34">
                        <circle cx="17" cy="17" r="13" fill="#111111"></circle><text x="17" y="22"
                            font-size="14" fill="#ffffff" text-anchor="middle">C</text>
                    </svg>
                </div>
                <div class="sodo-palette-item" draggable="true" data-type="hotro" data-color="" title="Hỗ trợ">
                    <svg viewBox="0 0 34 34">
                        <circle cx="17" cy="17" r="13" fill="#111111"></circle><text x="17" y="22"
                            font-size="14" fill="#ffffff" text-anchor="middle">A</text>
                    </svg>
                </div>
            </div>
        </div>

        <div class="text-2 sodo-palette-hint">Kéo vật dụng vào sân. Chuột phải vào vật đã đặt để xoá.</div>

        <button type="button" class="btn btn-outline sodo-clear-all-btn" id="sodoClearAllBtn">
            <i class="ri-delete-bin-line"></i> Xoá tất cả
        </button>
    </div>

    <div class="sodo-canvas-wrap">
        <div class="sodo-toolbar" id="sodoToolbar">
            <button type="button" class="sodo-tool-btn active" data-tool="select" title="Chọn / Di chuyển">
                <i class="ri-cursor-line"></i> Chọn
            </button>
            <button type="button" class="sodo-tool-btn" data-tool="chuyen" title="Nét liền - Chuyền">
                <i class="ri-arrow-right-line"></i> Chuyền
            </button>
            <button type="button" class="sodo-tool-btn" data-tool="sut" title="Sút">
                <i class="ri-arrow-right-double-line"></i> Sút
            </button>
            <button type="button" class="sodo-tool-btn" data-tool="dan_bong" title="Nét đứt - Dẫn bóng">
                <i class="ri-route-line"></i> Dẫn bóng
            </button>
        </div>

        <svg id="gaCanvas" viewBox="0 0 1040 600" class="sodo-canvas">
            <rect x="40" y="40" width="960" height="520" fill="#4d8a35"></rect>
            @for ($i = 0; $i < 16; $i++)
                @if ($i % 2 === 0)
                    <rect x="{{ 40 + $i * 60 }}" y="40" width="60" height="520" fill="#5a9c3f"></rect>
                @endif
            @endfor
            <rect x="40" y="40" width="960" height="520" fill="none" stroke="#ffffff" stroke-width="3">
            </rect>
            <line x1="520" y1="40" x2="520" y2="560" stroke="#ffffff" stroke-width="2.5">
            </line>
            <circle cx="520" cy="300" r="70" fill="none" stroke="#ffffff" stroke-width="2"></circle>
            <circle cx="520" cy="300" r="4" fill="#ffffff"></circle>
            <path d="M 40 120 A 192 192 0 0 1 40 480" fill="none" stroke="#ffffff" stroke-width="2"></path>
            <path d="M 1000 120 A 192 192 0 0 0 1000 480" fill="none" stroke="#ffffff" stroke-width="2"></path>
            <circle cx="280" cy="300" r="4" fill="#ffffff"></circle>
            <circle cx="760" cy="300" r="4" fill="#ffffff"></circle>
            <rect x="24" y="255" width="16" height="90" fill="none" stroke="#ffffff" stroke-width="2">
            </rect>
            <rect x="1000" y="255" width="16" height="90" fill="none" stroke="#ffffff" stroke-width="2">
            </rect>


            <g id="gaObjectsLayer"></g>
            <g id="gaArrowsLayer"></g>
        </svg>
    </div>
</div>

<div id="gaContextMenu" class="sodo-context-menu">
    <button type="button" id="gaContextMenuEdit" style="display:none;"><i class="ri-edit-line"></i> Chỉnh
        sửa</button>
    <button type="button" id="gaContextMenuDelete"><i class="ri-delete-bin-line"></i> Xoá</button>
</div>

<div class="overlay" id="gaSoModal">
    <div class="modal">
        <div class="modal-head">
            <h3>Sửa số thứ tự</h3>
            <i class="ri-close-line" onclick="closeModal('gaSoModal')"></i>
        </div>
        <div class="modal-body">
            <div class="field">
                <label>Số thứ tự</label>
                <input type="number" id="gaSoInput" min="1">
            </div>
        </div>
        <div class="modal-foot">
            <button type="button" class="btn btn-outline" onclick="closeModal('gaSoModal')">Huỷ</button>
            <button type="button" class="btn btn-primary" id="gaSoSaveBtn"><i class="ri-save-line"></i>
                Lưu</button>
        </div>
    </div>
</div>

<div class="overlay" id="gaMauSacModal">
    <div class="modal modal-cai-dat-vat-dung">
        <div class="modal-head">
            <h3>Cài đặt vật dụng</h3>
            <i class="ri-close-line" onclick="closeModal('gaMauSacModal')"></i>
        </div>
        <div class="modal-body">
            <div class="form-grid">
                <div class="field">
                    <label>Màu 1</label>
                    <input type="color" id="gaMauBlue" value="{{ $mauSac['blue'] }}">
                </div>
                <div class="field">
                    <label>Màu 2</label>
                    <input type="color" id="gaMauGreen" value="{{ $mauSac['green'] }}">
                </div>
                <div class="field">
                    <label>Màu 3</label>
                    <input type="color" id="gaMauYellow" value="{{ $mauSac['yellow'] }}">
                </div>
                <div class="field">
                    <label>Màu 4</label>
                    <input type="color" id="gaMauOrange" value="{{ $mauSac['orange'] }}">
                </div>
            </div>

            <hr class="ga-size-divider">
            <div class="ga-size-title">Kích thước vật dụng</div>

            <div class="ga-size-field">
                <div class="ga-size-preview">
                    <svg viewBox="0 0 130 130" width="60" height="60">
                        <g transform="translate(65,65)">
                            <g class="ga-size-scale" data-group="nam" transform="scale({{ $kichThuoc['nam'] / 100 }})">
                                <circle r="16" fill="{{ $mauSac['blue'] }}"></circle>
                                <circle r="5" fill="#111111"></circle>
                            </g>
                        </g>
                    </svg>
                </div>
                <div class="ga-size-controls">
                    <div class="ga-size-row">
                        <label>Nấm</label>
                        <span class="ga-size-value" id="gaSizeNamValue">{{ $kichThuoc['nam'] }}%</span>
                    </div>
                    <input type="range" min="50" max="200" step="5" id="gaSizeNam" data-group="nam"
                        value="{{ $kichThuoc['nam'] }}">
                </div>
            </div>

            <div class="ga-size-field">
                <div class="ga-size-preview">
                    <svg viewBox="0 0 130 130" width="60" height="60">
                        <g transform="translate(65,65)">
                            <g class="ga-size-scale" data-group="con" transform="scale({{ $kichThuoc['con'] / 100 }})">
                                <svg x="-25" y="-25" width="50" height="50" viewBox="0 0 16 16">
                                    <path fill="{{ $mauSac['green'] }}"
                                        d="M7.03 1.88c.252-1.01 1.688-1.01 1.94 0l2.905 11.62H14a.5.5 0 0 1 0 1H2a.5.5 0 0 1 0-1h2.125z">
                                    </path>
                                </svg>
                            </g>
                        </g>
                    </svg>
                </div>
                <div class="ga-size-controls">
                    <div class="ga-size-row">
                        <label>Côn</label>
                        <span class="ga-size-value" id="gaSizeConValue">{{ $kichThuoc['con'] }}%</span>
                    </div>
                    <input type="range" min="50" max="200" step="5" id="gaSizeCon" data-group="con"
                        value="{{ $kichThuoc['con'] }}">
                </div>
            </div>

            <div class="ga-size-field">
                <div class="ga-size-preview">
                    <svg viewBox="0 0 130 130" width="60" height="60">
                        <g transform="translate(65,65)">
                            <g class="ga-size-scale" data-group="nguoi"
                                transform="scale({{ $kichThuoc['nguoi'] / 100 }})">
                                <circle r="32" fill="#4d8a35"></circle>
                                <svg x="-30" y="-30" width="60" height="60" viewBox="0 0 24 24">
                                    <g transform="translate(12,12)" fill="#ffffff">
                                        <rect x="-11" y="-2.5" width="22" height="5" rx="2.5" transform="rotate(45)">
                                        </rect>
                                        <rect x="-11" y="-2.5" width="22" height="5" rx="2.5" transform="rotate(-45)">
                                        </rect>
                                    </g>
                                </svg>
                            </g>
                        </g>
                    </svg>
                </div>
                <div class="ga-size-controls">
                    <div class="ga-size-row">
                        <label>Người</label>
                        <span class="ga-size-value" id="gaSizeNguoiValue">{{ $kichThuoc['nguoi'] }}%</span>
                    </div>
                    <input type="range" min="50" max="200" step="5" id="gaSizeNguoi" data-group="nguoi"
                        value="{{ $kichThuoc['nguoi'] }}">
                </div>
            </div>

            <div class="ga-size-field">
                <div class="ga-size-preview">
                    <svg viewBox="0 0 130 130" width="60" height="60">
                        <g transform="translate(65,65)">
                            <g class="ga-size-scale" data-group="bong"
                                transform="scale({{ $kichThuoc['bong'] / 100 }})">
                                <svg x="-16" y="-16" width="32" height="32" viewBox="0 0 64 64">
                                    <circle cx="32" cy="32" r="29.3" fill="#ffffff"></circle>
                                    <path fill="#4a4e51"
                                        d="M61.9 32c0-.7.2-10.9-5.8-17.5c-.3-.6-1.5-3-5.6-5.9C47.8 6.5 45 5 44.7 4.8S39.4 2 33.4 2c-.5 0-.9 0-1.4.1c-4.6-.1-8.8 1.1-11.9 2.5c-3.2 1.4-5.3 2.8-5.5 3c-3.4 1.9-9.9 9.5-10.4 13.6c-2.1 2.6-3.8 14.5 0 21.7c2.7 10 12.7 15 13.5 15.4c.5.3 5.9 3.7 12.6 3.7h.9c.6.1 1.1.1 1.7.1c7.2 0 18-5.1 20.2-9.1c6.2-4.6 9.4-16.2 8.8-21M17.8 47.1c-2.9-4.6-4.5-10.7-4.9-12.1c.9-1.4 5.4-8 7.9-10c1.4.3 7.5 1.4 13.2 2.4c.7 1.9 3.9 10 4.8 13.2c-1 1.2-4.9 5.7-8.7 9.2c-4.1.1-11-2.3-12.3-2.7m36-32.5c0 .4-.1 2-.9 3.9c-1.5-.8-5.3-2.4-10.6-2.7c-.8-1.2-3.8-5.3-8.5-8.1c.6-1.3 1.5-2.8 2.1-3.3c.2 0 .4-.1.8-.1c2.5 0 6.9 1.7 7.3 1.8c.4.2 8.3 4.4 9.8 8.5M11.8 34c-3.4-.6-5.5-1.6-6.1-2c-1.3-4.6-.2-9.6-.1-10.3c1.3-2.2 4.8-8 7.2-9.1c2.4-.5 5.5.1 6.7.4c-.1 1.6-.3 6.1.3 10.9c-2.6 2.2-6.9 8.5-8 10.1M31.7 3.5c.8.1 1.9.2 2.7.5c-.8 1-1.6 2.5-1.9 3.3c-1.6.3-7.5 1.4-12.2 4.4c-.9-.2-3.8-.9-6.5-.7c.7-1.3 1.7-2.2 1.8-2.3c.3-.3 7.4-5.3 16.1-5.2m19.1 38.1c-1.2 0-5.7-.3-10.6-1.5c-.9-3.3-4.1-11.4-4.8-13.3c3.1-4.4 6.1-8.5 6.9-9.7c5.7.4 9.7 2.5 10.5 2.9c3.3 5.3 4 10.7 4.1 11.6c-1.8 5.5-5.2 9.2-6.1 10M3.7 28.5c.1 1.3.3 2.6.7 3.9c-.3.9-.6 1.8-.7 2.7c-.3-2.3-.3-4.6 0-6.6M18.5 57l-.4.6zc-2.5-1.2-4.4-4-5.2-5.1c1.5-1.5 3.4-2.9 4.1-3.4c1.6.6 8.3 2.8 12.6 2.8c.7 1 3.1 4 6 6.4c-1.8 1.8-4.4 2.6-4.9 2.8c-6.8.2-12.6-3.5-12.6-3.5m16.3 3.4c.9-.5 1.9-1.2 2.7-2.1c1.3-.2 6.9-1.1 11.9-4.8c.3 0 .9.1 1.5.1c-3.1 2.9-10.5 6.2-16.1 6.8M50.2 52c1.8-4.7 1.7-8.3 1.6-9.4c1-1 4.4-4.6 6.3-10.1c1 .2 1.7.4 2 .6c.1.4.3 1.3.2 2.7c-.8 5-3.4 12.6-8.1 15.9c-.5.3-1.3.4-2 .3">
                                    </path>
                                </svg>
                            </g>
                        </g>
                    </svg>
                </div>
                <div class="ga-size-controls">
                    <div class="ga-size-row">
                        <label>Bóng</label>
                        <span class="ga-size-value" id="gaSizeBongValue">{{ $kichThuoc['bong'] }}%</span>
                    </div>
                    <input type="range" min="50" max="200" step="5" id="gaSizeBong" data-group="bong"
                        value="{{ $kichThuoc['bong'] }}">
                </div>
            </div>

            <div class="ga-size-field">
                <div class="ga-size-preview">
                    <svg viewBox="0 0 130 130" width="60" height="60">
                        <g transform="translate(65,65)">
                            <g class="ga-size-scale" data-group="nhansu"
                                transform="scale({{ $kichThuoc['nhansu'] / 100 }})">
                                <circle r="16" fill="#111111"></circle>
                                <text y="6" font-size="16" fill="#ffffff" text-anchor="middle">C</text>
                            </g>
                        </g>
                    </svg>
                </div>
                <div class="ga-size-controls">
                    <div class="ga-size-row">
                        <label>Nhân sự (Thầy giáo / Hỗ trợ)</label>
                        <span class="ga-size-value" id="gaSizeNhansuValue">{{ $kichThuoc['nhansu'] }}%</span>
                    </div>
                    <input type="range" min="50" max="200" step="5" id="gaSizeNhansu" data-group="nhansu"
                        value="{{ $kichThuoc['nhansu'] }}">
                </div>
            </div>
        </div>
        <div class="modal-foot">
            <button type="button" class="btn btn-outline" onclick="closeModal('gaMauSacModal')">Huỷ</button>
            <button type="button" class="btn btn-primary" id="gaMauSacSaveBtn"><i class="ri-save-line"></i>
                Lưu</button>
        </div>
    </div>
</div>

<script>
    window.__gaMauSac = @json($mauSac);
    window.__gaMauSacUrl = @json(route('giaoan.mausac.update'));
    window.__gaKichThuoc = @json($kichThuoc);
    window.__gaKichThuocUrl = @json(route('giaoan.kichthuoc.update'));
    window.__gaCsrfToken = @json(csrf_token());
</script>

@push('scripts')
    <script src="{{ asset('js/pages/sodo-designer.js') }}"></script>
@endpush