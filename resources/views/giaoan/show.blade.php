<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $giaoan->ten_tro_choi }} — Giáo án</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Inter', system-ui, sans-serif;
            background: #F5F6FA;
            color: #1E2022;
            padding: 30px 16px;
            line-height: 1.6;
        }

        .ga-doc {
            max-width: 1100px;
            margin: 0 auto;
            background: #fff;
            border-radius: 16px;
            padding: 40px;
            box-shadow: 0 2px 10px rgba(20, 20, 43, .06);
        }

        .ga-doc-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 16px;
            margin-bottom: 24px;
            padding-bottom: 18px;
            border-bottom: 2px solid #EBEDF3;
            flex-wrap: wrap;
        }

        .ga-doc-title {
            font-size: 26px;
            font-weight: 800;
        }

        .ga-doc-meta {
            font-size: 13px;
            color: #8B90A0;
            margin-top: 6px;
        }

        .ga-doc-actions {
            display: flex;
            gap: 10px;
        }

        .ga-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 9px 16px;
            border-radius: 8px;
            font-size: 13.5px;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            border: 1px solid #EBEDF3;
            background: #fff;
            color: #1E2022;
        }

        .ga-btn-primary {
            background: #6C5DD3;
            border-color: #6C5DD3;
            color: #fff;
        }

        .ga-section {
            margin-bottom: 28px;
        }

        .ga-section-title {
            font-size: 15px;
            font-weight: 700;
            margin-bottom: 8px;
            color: #6C5DD3;
        }

        .ga-section-body {
            font-size: 14px;
            white-space: pre-wrap;
        }

        .ga-sodo-wrap {
            border: 1px solid #EBEDF3;
            border-radius: 12px;
            overflow: hidden;
        }

        .ga-video-wrap video {
            width: 100%;
            border-radius: 12px;
            display: block;
        }

        @media print {
            body {
                background: #fff;
                padding: 0;
            }

            .ga-doc {
                box-shadow: none;
                padding: 0;
                max-width: 100%;
            }

            .ga-doc-actions {
                display: none;
            }
        }
    </style>
</head>

<body>
    <div class="ga-doc">
        <div class="ga-doc-header">
            <div>
                <div class="ga-doc-title">{{ $giaoan->ten_tro_choi }}</div>
                <div class="ga-doc-meta">
                    {{ $giaoan->cap_hoc->getLabel() }} · {{ $giaoan->loai_game->getLabel() }}
                    @if ($giaoan->chu_de)
                        · {{ $giaoan->chu_de->getLabelCoSo() }}
                    @endif
                </div>
            </div>
            <div class="ga-doc-actions">
                <button type="button" class="ga-btn ga-btn-primary" onclick="window.print()">
                    <i class="ri-printer-line"></i> In giáo án
                </button>
            </div>
        </div>

        @if ($giaoan->cach_choi)
            <div class="ga-section">
                <div class="ga-section-title">Cách chơi</div>
                <div class="ga-section-body">{{ $giaoan->cach_choi }}</div>
            </div>
        @endif

        @if ($giaoan->luat_choi)
            <div class="ga-section">
                <div class="ga-section-title">Luật chơi</div>
                <div class="ga-section-body">{{ $giaoan->luat_choi }}</div>
            </div>
        @endif

        @if ($sodoMarkup)
            <div class="ga-section">
                <div class="ga-section-title">Sơ đồ</div>
                <div class="ga-sodo-wrap">
                    <svg viewBox="0 0 1040 600" style="width:100%; display:block; background:#4d8a35;">
                        <rect x="0" y="0" width="1040" height="600" fill="#4d8a35"></rect>
                        <rect x="40" y="40" width="960" height="520" fill="#4d8a35"></rect>
                        @for ($i = 0; $i < 16; $i++)
                            @if ($i % 2 === 0)
                                <rect x="{{ 40 + $i * 60 }}" y="40" width="60" height="520" fill="#5a9c3f">
                                </rect>
                            @endif
                        @endfor
                        <rect x="40" y="40" width="960" height="520" fill="none" stroke="#ffffff"
                            stroke-width="3"></rect>
                        <line x1="520" y1="40" x2="520" y2="560" stroke="#ffffff"
                            stroke-width="2.5"></line>
                        <circle cx="520" cy="300" r="70" fill="none" stroke="#ffffff" stroke-width="2">
                        </circle>
                        <circle cx="520" cy="300" r="4" fill="#ffffff"></circle>
                        <path d="M 40 120 A 192 192 0 0 1 40 480" fill="none" stroke="#ffffff" stroke-width="2">
                        </path>
                        <path d="M 1000 120 A 192 192 0 0 0 1000 480" fill="none" stroke="#ffffff" stroke-width="2">
                        </path>
                        <circle cx="280" cy="300" r="4" fill="#ffffff"></circle>
                        <circle cx="760" cy="300" r="4" fill="#ffffff"></circle>
                        <rect x="24" y="255" width="16" height="90" fill="none" stroke="#ffffff"
                            stroke-width="2"></rect>
                        <rect x="1000" y="255" width="16" height="90" fill="none" stroke="#ffffff"
                            stroke-width="2"></rect>
                        {!! $sodoMarkup !!}
                    </svg>
                </div>
            </div>
        @endif

        @if ($giaoan->video_path)
            <div class="ga-section">
                <div class="ga-section-title">Video</div>
                <div class="ga-video-wrap">
                    <video controls src="{{ $giaoan->videoUrl() }}"></video>
                </div>
            </div>
        @endif
    </div>
</body>

</html>
