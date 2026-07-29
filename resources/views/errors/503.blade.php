<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>503 — Hệ thống đang bảo trì</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <style>
        :root {
            --ink: #1a1a1a;
            --muted: #6b6b76;
            --violet: #5b21b6;
            --violet-deep: #3c1361;
            --violet-tint: #f3eefc;
            --gold: #f4c430;
            --paper: #ffffff;
            --line: #ece8f5;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html,
        body {
            height: 100%;
            background: var(--paper);
            color: var(--ink);
            font-family: 'Be Vietnam Pro', sans-serif;
            overflow-x: hidden;
        }

        body {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 40px 24px;
        }

        .wrap {
            width: 100%;
            max-width: 1080px;
            display: grid;
            grid-template-columns: 1.05fr 1fr;
            align-items: center;
            gap: 48px;
        }

        .eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: .08em;
            color: var(--violet);
            text-transform: uppercase;
            margin-bottom: 22px;
        }

        .eyebrow::before {
            content: "";
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: var(--gold);
            box-shadow: 0 0 0 3px var(--violet-tint);
        }

        .code {
            font-weight: 800;
            font-size: clamp(72px, 11vw, 128px);
            line-height: 0.9;
            letter-spacing: -.03em;
            color: var(--ink);
            margin-bottom: 8px;
        }

        .code span {
            color: var(--violet);
        }

        h1 {
            font-weight: 700;
            font-size: clamp(22px, 3vw, 30px);
            margin-bottom: 14px;
            letter-spacing: -.01em;
        }

        p.desc {
            font-weight: 400;
            font-size: 16px;
            line-height: 1.65;
            color: var(--muted);
            max-width: 440px;
            margin-bottom: 8px;
        }

        .reason {
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 22px 0 18px;
            padding: 12px 16px;
            background: var(--violet-tint);
            border: 1px solid var(--line);
            border-radius: 10px;
            font-size: 14px;
            color: var(--violet-deep);
            max-width: 440px;
        }

        .reason svg {
            flex: 0 0 auto;
        }

        .retry {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 30px;
            font-size: 14px;
            color: var(--muted);
        }

        .retry .count {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 34px;
            height: 26px;
            padding: 0 8px;
            border-radius: 999px;
            background: var(--ink);
            color: #fff;
            font-weight: 700;
            font-size: 13px;
            font-variant-numeric: tabular-nums;
        }

        .actions {
            display: flex;
            gap: 14px;
            flex-wrap: wrap;
        }

        .btn {
            appearance: none;
            border: none;
            cursor: pointer;
            font-family: inherit;
            font-weight: 600;
            font-size: 15px;
            padding: 14px 26px;
            border-radius: 999px;
            transition: transform .18s ease, box-shadow .18s ease, background .18s ease;
        }

        .btn-primary {
            background: var(--violet);
            color: #fff;
            box-shadow: 0 8px 20px -8px rgba(91, 33, 182, .55);
        }

        .btn-primary:hover {
            background: var(--violet-deep);
            transform: translateY(-2px);
            box-shadow: 0 12px 24px -8px rgba(91, 33, 182, .6);
        }

        .btn-ghost {
            background: transparent;
            color: var(--ink);
            border: 1.5px solid var(--line);
        }

        .btn-ghost:hover {
            border-color: var(--violet);
            color: var(--violet);
            transform: translateY(-2px);
        }

        .contact {
            margin-top: 26px;
            font-size: 13.5px;
            color: var(--muted);
        }

        .contact a {
            color: var(--violet);
            font-weight: 600;
            text-decoration: none;
        }

        .contact a:hover {
            text-decoration: underline;
        }

        /* Illustration */
        .stage {
            position: relative;
            display: flex;
            align-items: flex-end;
            justify-content: center;
            height: 420px;
        }

        .ground {
            position: absolute;
            bottom: 26px;
            left: 0;
            right: 0;
            height: 2px;
            background: var(--line);
        }

        .rig-wrap {
            position: relative;
            width: 250px;
            animation: float 5s ease-in-out infinite;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-6px);
            }
        }

        .server {
            position: relative;
            width: 210px;
            margin: 0 auto;
            background: var(--violet-deep);
            border: 3px solid var(--violet);
            border-radius: 18px;
            box-shadow: 0 20px 40px -18px rgba(60, 19, 97, .45);
            padding: 16px 18px;
        }

        .rack-row {
            display: flex;
            align-items: center;
            gap: 10px;
            height: 30px;
            border-radius: 6px;
            background: rgba(255, 255, 255, .06);
            margin-bottom: 10px;
            padding: 0 12px;
        }

        .rack-row:last-child {
            margin-bottom: 0;
        }

        .led {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #4b2a86;
        }

        .led.on {
            background: var(--gold);
            box-shadow: 0 0 8px 1px rgba(244, 196, 48, .7);
            animation: pulse 1.6s ease-in-out infinite;
        }

        .led.on.d1 {
            animation-delay: .2s;
        }

        .led.on.d2 {
            animation-delay: .6s;
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: .25;
            }
        }

        .bars {
            display: flex;
            align-items: center;
            gap: 3px;
            margin-left: auto;
        }

        .bars span {
            width: 3px;
            background: #c9b6f0;
            border-radius: 2px;
            animation: bar 1.4s ease-in-out infinite;
        }

        .bars span:nth-child(1) {
            height: 6px;
            animation-delay: 0s;
        }

        .bars span:nth-child(2) {
            height: 11px;
            animation-delay: .2s;
        }

        .bars span:nth-child(3) {
            height: 8px;
            animation-delay: .4s;
        }

        .bars span:nth-child(4) {
            height: 14px;
            animation-delay: .6s;
        }

        @keyframes bar {

            0%,
            100% {
                transform: scaleY(.4);
            }

            50% {
                transform: scaleY(1);
            }
        }

        .gear {
            position: absolute;
            right: -22px;
            bottom: -22px;
            width: 64px;
            height: 64px;
            animation: spin 6s linear infinite;
            filter: drop-shadow(0 6px 12px rgba(0, 0, 0, .2));
        }

        @keyframes spin {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        .zzz {
            position: absolute;
            top: -34px;
            right: 6px;
            font-weight: 800;
            color: var(--violet);
            font-size: 15px;
            opacity: 0;
            animation: zfloat 3.2s ease-in infinite;
        }

        .zzz.z1 {
            animation-delay: 0s;
            right: 2px;
        }

        .zzz.z2 {
            font-size: 11px;
            animation-delay: .6s;
            right: -16px;
            top: -24px;
        }

        .zzz.z3 {
            font-size: 19px;
            animation-delay: 1.2s;
            right: 16px;
            top: -46px;
        }

        @keyframes zfloat {
            0% {
                opacity: 0;
                transform: translateY(0) scale(.8);
            }

            20% {
                opacity: .85;
            }

            100% {
                opacity: 0;
                transform: translateY(-26px) scale(1.1);
            }
        }

        .tape {
            position: absolute;
            left: -28px;
            right: -28px;
            height: 24px;
            background: repeating-linear-gradient(-45deg,
                    var(--gold),
                    var(--gold) 12px,
                    #1a1a1a 12px,
                    #1a1a1a 14px);
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 10px -4px rgba(0, 0, 0, .25);
            transform: rotate(-2deg);
        }

        .tape span {
            background: var(--gold);
            padding: 0 10px;
            font-size: 10.5px;
            font-weight: 800;
            letter-spacing: .05em;
            color: #1a1a1a;
            white-space: nowrap;
        }

        .tape.t1 {
            top: -10px;
        }

        .tape.t2 {
            bottom: -10px;
            transform: rotate(2deg);
        }

        .grass {
            position: absolute;
            bottom: 22px;
            width: 14px;
            height: 16px;
        }

        .grass.g1 {
            left: -46px;
        }

        .grass.g2 {
            right: -46px;
        }

        .grass svg {
            width: 100%;
            height: 100%;
        }

        @media (max-width:820px) {
            .wrap {
                grid-template-columns: 1fr;
                text-align: center;
            }

            .actions {
                justify-content: center;
            }

            p.desc,
            .reason,
            .retry {
                margin-left: auto;
                margin-right: auto;
            }

            .retry {
                justify-content: center;
            }

            .stage {
                height: 340px;
                margin-top: 12px;
            }
        }

        @media (prefers-reduced-motion:reduce) {

            .rig-wrap,
            .gear,
            .led.on,
            .bars span,
            .zzz {
                animation: none;
            }

            .zzz {
                opacity: 0;
            }
        }
    </style>
</head>

<body>

    <div class="wrap">

        <div class="text-col">
            <div class="eyebrow">Mã lỗi 503</div>
            <div class="code">5<span>0</span>3</div>
            <h1>Hệ thống đang bảo trì</h1>
            <p class="desc">
                Dịch vụ tạm thời không khả dụng do đang được nâng cấp hoặc bảo trì.
                Chúng tôi sẽ sớm hoạt động trở lại, mong bạn thông cảm.
            </p>

            <div class="reason">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                    <path
                        d="M12 2v4M12 18v4M4.9 4.9l2.8 2.8M16.3 16.3l2.8 2.8M2 12h4M18 12h4M4.9 19.1l2.8-2.8M16.3 7.7l2.8-2.8"
                        stroke="#5b21b6" stroke-width="1.8" stroke-linecap="round" />
                    <circle cx="12" cy="12" r="4" stroke="#5b21b6" stroke-width="1.8" />
                </svg>
                Đội kỹ thuật đang xử lý, hệ thống sẽ quay lại trong ít phút.
            </div>

            <div class="retry">
                Tự động thử lại sau <span class="count" id="countdown">30</span> giây
            </div>

            <div class="actions">
                <button class="btn btn-primary" onclick="window.location.reload()">Tải lại trang</button>
            </div>
        </div>

        <div class="stage">
            <div class="ground"></div>
            <div class="rig-wrap">
                <div class="grass g1"><svg viewBox="0 0 14 16">
                        <path d="M2 16C2 10 4 6 2 0" stroke="#c9c2e6" stroke-width="1.5" fill="none" />
                        <path d="M7 16C7 9 9 5 7 0" stroke="#c9c2e6" stroke-width="1.5" fill="none" />
                        <path d="M12 16C12 11 13 7 12 2" stroke="#c9c2e6" stroke-width="1.5" fill="none" />
                    </svg></div>
                <div class="grass g2"><svg viewBox="0 0 14 16">
                        <path d="M2 16C2 10 4 6 2 0" stroke="#c9c2e6" stroke-width="1.5" fill="none" />
                        <path d="M7 16C7 9 9 5 7 0" stroke="#c9c2e6" stroke-width="1.5" fill="none" />
                        <path d="M12 16C12 11 13 7 12 2" stroke="#c9c2e6" stroke-width="1.5" fill="none" />
                    </svg></div>

                <div class="zzz z1">z</div>
                <div class="zzz z2">z</div>
                <div class="zzz z3">Z</div>

                <div class="server">
                    <div class="tape t1"><span>ĐANG BẢO TRÌ HỆ THỐNG</span></div>

                    <div class="rack-row">
                        <div class="led on d1"></div>
                        <div class="led on d2"></div>
                        <div class="led"></div>
                        <div class="bars"><span></span><span></span><span></span><span></span></div>
                    </div>
                    <div class="rack-row">
                        <div class="led on"></div>
                        <div class="led"></div>
                        <div class="led on d2"></div>
                        <div class="bars"><span></span><span></span><span></span><span></span></div>
                    </div>
                    <div class="rack-row">
                        <div class="led"></div>
                        <div class="led on d1"></div>
                        <div class="led"></div>
                        <div class="bars"><span></span><span></span><span></span><span></span></div>
                    </div>

                    <div class="tape t2"><span>VUI LÒNG QUAY LẠI SAU</span></div>

                    <svg class="gear" viewBox="0 0 48 48" fill="none">
                        <path
                            d="M24 4l2.6 4.4 5-1.4 1 5.1 5.1 1-1.4 5 4.4 2.6-3.1 4.3 3.1 4.3-4.4 2.6 1.4 5-5.1 1-1 5.1-5-1.4L24 44l-2.6-4.4-5 1.4-1-5.1-5.1-1 1.4-5-4.4-2.6 3.1-4.3L6.3 21 4 24l2.3-3.1L4 24l2.3-3.1L4 24"
                            fill="var(--gold)" opacity="0" />
                        <path
                            d="M24 3.5c.7 0 1.4.4 1.7 1.1l1.7 3.4 3.6-1c.9-.3 1.9.1 2.4.9l2 3.3c.5.8.4 1.8-.2 2.5l-2.4 2.9 2.4 2.9c.6.7.7 1.7.2 2.5l-2 3.3c-.5.8-1.5 1.2-2.4.9l-3.6-1-1.7 3.4c-.3.7-1 1.1-1.7 1.1h-.0c-.7 0-1.4-.4-1.7-1.1l-1.7-3.4-3.6 1c-.9.3-1.9-.1-2.4-.9l-2-3.3c-.5-.8-.4-1.8.2-2.5l2.4-2.9-2.4-2.9c-.6-.7-.7-1.7-.2-2.5l2-3.3c.5-.8 1.5-1.2 2.4-.9l3.6 1 1.7-3.4c.3-.7 1-1.1 1.7-1.1z"
                            fill="var(--gold)" />
                        <circle cx="24" cy="24" r="6.5" fill="var(--violet-deep)" />
                    </svg>
                </div>
            </div>
        </div>

    </div>

    <script>
        (function() {
            var seconds = 30;
            var el = document.getElementById('countdown');
            var timer = setInterval(function() {
                seconds -= 1;
                if (seconds <= 0) {
                    clearInterval(timer);
                    window.location.reload();
                    return;
                }
                el.textContent = seconds;
            }, 1000);
        })();
    </script>

</body>

</html>
