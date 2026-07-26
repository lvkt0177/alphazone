<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>503 · Mèo cưng đang bận</title>
<style>
  @import url('https://fonts.googleapis.com/css2?family=Quicksand:wght@500;600;700&family=Inter:wght@400;500;600&display=swap');

  :root{
    --bg-1: #0c0e1f;
    --bg-2: #1a1440;
    --card: #191c3a;
    --card-2: #20244a;
    --ink: #eef0fb;
    --ink-dim: #9aa0c4;
    --violet: #6c63ff;
    --violet-soft: #4b447f;
    --red: #ef4a63;
    --red-deep: #d63653;
    --green-eye: #7bffa0;
    --outline: rgba(180, 190, 230, 0.16);
  }

  *{ box-sizing:border-box; }
  html,body{ margin:0; padding:0; height:100%; }

  body{
    min-height:100vh;
    font-family:'Inter', sans-serif;
    background: radial-gradient(1100px 700px at 15% 10%, #211a4d 0%, transparent 55%),
                linear-gradient(160deg, var(--bg-2) 0%, var(--bg-1) 70%);
    color: var(--ink);
    display:flex;
    flex-direction:column;
    overflow-x:hidden;
  }

  /* ---------- header ---------- */
  header{
    display:flex; align-items:center; justify-content:space-between;
    padding: 28px clamp(20px,5vw,64px) 0;
  }
  .icon-btn{
    width:38px; height:38px;
    display:flex; align-items:center; justify-content:center;
    border-radius:50%;
    color: var(--ink-dim);
    cursor:pointer;
    transition: background .2s ease, color .2s ease;
  }
  .icon-btn:hover{ background: rgba(255,255,255,0.06); color: var(--ink); }
  .icon-btn svg{ width:19px; height:19px; }

  /* ---------- main ---------- */
  main{
    flex:1;
    display:flex;
    align-items:center;
    justify-content:center;
    padding: 20px clamp(20px,5vw,64px) 48px;
  }

  .stage{
    position:relative;
    width:100%;
    max-width: 1180px;
    min-height: 560px;
    display:flex;
    align-items:center;
    border-radius: 28px;
    overflow:hidden;
  }

  /* organic blob card */
  .blob{
    position:absolute; inset:0;
    z-index:0;
  }
  .blob svg{ width:100%; height:100%; }
  .blob-shape{
    fill: var(--card);
    animation: breathe 9s ease-in-out infinite;
    transform-origin: 60% 50%;
  }
  @keyframes breathe{
    0%,100%{ transform: scale(1); }
    50%{ transform: scale(1.012); }
  }

  /* ---------- copy ---------- */
  .copy{
    position:relative; z-index:2;
    width: 100%;
    max-width: 380px;
    padding: 0 0 0 clamp(24px, 4vw, 64px);
  }
  .copy .code{
    font-family:'Quicksand', sans-serif;
    font-weight:700;
    font-size: clamp(38px, 5vw, 50px);
    letter-spacing:-.01em;
    margin: 0 0 12px;
    color: var(--ink);
  }
  .copy .code span{ color: var(--red); }
  .copy p{
    font-size:14.5px;
    line-height:1.6;
    color: var(--ink-dim);
    margin: 0 0 28px;
    max-width: 300px;
  }
  .btn{
    display:inline-flex;
    align-items:center;
    gap:8px;
    font-family:'Inter', sans-serif;
    font-weight:600;
    font-size:14px;
    color:#fff;
    background: linear-gradient(135deg, var(--red), var(--red-deep));
    border:none;
    padding: 13px 26px;
    border-radius: 30px;
    cursor:pointer;
    box-shadow: 0 10px 26px -8px rgba(239,74,99,.55);
    transition: transform .18s ease, box-shadow .18s ease;
  }
  .btn:hover{ transform: translateY(-2px); box-shadow: 0 14px 30px -8px rgba(239,74,99,.7); }
  .btn svg{ width:15px; height:15px; animation: spin 3.5s linear infinite paused; }
  .btn:hover svg{ animation-play-state: running; }
  @keyframes spin{ to{ transform: rotate(360deg); } }

  /* ---------- illustration ---------- */
  .illus{
    position:relative; z-index:2;
    flex: 1;
    height: 560px;
    display:flex; align-items:flex-end; justify-content:center;
  }
  .illus svg{ width: 92%; max-width: 520px; height:auto; overflow:visible; }

  .dot{ animation: twinkle 3s ease-in-out infinite; }
  .dot.d2{ animation-delay:.6s; }
  .dot.d3{ animation-delay:1.2s; }
  @keyframes twinkle{
    0%,100%{ opacity:.35; transform:scale(1); }
    50%{ opacity:1; transform:scale(1.25); }
  }

  .lamp-group{ animation: swing 4.5s ease-in-out infinite; transform-origin: 50% 0%; }
  @keyframes swing{
    0%,100%{ transform: rotate(-2.5deg); }
    50%{ transform: rotate(2.5deg); }
  }
  .lamp-glow{ animation: glow 3s ease-in-out infinite; }
  @keyframes glow{
    0%,100%{ opacity:.35; }
    50%{ opacity:.7; }
  }

  .cat-tail{ animation: tail 3.2s ease-in-out infinite; transform-origin: 260px 300px; }
  @keyframes tail{
    0%,100%{ transform: rotate(0deg); }
    50%{ transform: rotate(4deg); }
  }
  .cat-eyes{ animation: blink 4.8s ease-in-out infinite; transform-origin:center; }
  @keyframes blink{
    0%, 92%, 100%{ transform: scaleY(1); }
    95%{ transform: scaleY(0.12); }
  }
  .yarn{ animation: roll 5s ease-in-out infinite; transform-origin: 400px 400px; }
  @keyframes roll{
    0%,100%{ transform: rotate(0deg); }
    50%{ transform: rotate(-8deg); }
  }
  .string{ stroke-dasharray: 4 5; animation: dash 6s linear infinite; }
  @keyframes dash{ to{ stroke-dashoffset: -80; } }

  .cactus{ animation: sway 6s ease-in-out infinite; transform-origin: 460px 420px; }
  @keyframes sway{
    0%,100%{ transform: rotate(-1.4deg); }
    50%{ transform: rotate(1.4deg); }
  }

  @media (max-width: 880px){
    .stage{ flex-direction:column; min-height:auto; padding-top:36px; }
    .copy{ max-width:100%; padding: 0 24px; text-align:center; }
    .copy p{ max-width:100%; margin-left:auto; margin-right:auto; }
    .illus{ height:auto; margin-top: 8px; }
  }

  @media (prefers-reduced-motion: reduce){
    *{ animation: none !important; }
  }
</style>
</head>
<body>

<header>
  <div class="icon-btn" aria-label="menu">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M4 6h16M4 12h16M4 18h16"/></svg>
  </div>
  <div class="icon-btn" aria-label="search">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><circle cx="11" cy="11" r="7"/><path d="M21 21l-4.3-4.3"/></svg>
  </div>
</header>

<main>
  <div class="stage">

    <div class="blob">
      <svg viewBox="0 0 1180 560" preserveAspectRatio="none">
        <path class="blob-shape" d="M0,60
          C120,-10 340,0 470,55
          C640,125 720,10 900,25
          C1060,38 1180,120 1180,240
          L1180,560 L0,560 Z"/>
      </svg>
    </div>

    <div class="copy">
      <h1 class="code">Error <span>503</span></h1>
      <p>Trang web hiện đang bảo trì, vui lòng quay lại sau.</p>
      <button class="btn" onclick="location.reload()">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"><path d="M21 12a9 9 0 1 1-3-6.7"/><path d="M21 4v6h-6"/></svg>
        Tải lại
      </button>
    </div>

    <div class="illus">
      <svg viewBox="0 0 560 500">

        <!-- floating dots -->
        <circle class="dot" cx="90" cy="70" r="5" fill="#ef4a63"/>
        <circle class="dot d2" cx="470" cy="120" r="4" fill="#7bffa0"/>
        <circle class="dot d3" cx="510" cy="300" r="4.5" fill="#6c63ff"/>

        <!-- wall frame -->
        <g>
          <rect x="70" y="140" width="58" height="72" rx="10" fill="none" stroke="#3a3f6e" stroke-width="3"/>
          <path d="M84 195 L100 172 L112 186 L124 165" fill="none" stroke="#4b447f" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
          <circle cx="112" cy="158" r="6" fill="#4b447f"/>
        </g>

        <!-- hanging lamp -->
        <g class="lamp-group">
          <line x1="330" y1="0" x2="330" y2="80" stroke="#3a3f6e" stroke-width="3"/>
          <path d="M300 80 L360 80 L348 110 L312 110 Z" fill="#2a2f5c" stroke="#4b447f" stroke-width="2.5" stroke-linejoin="round"/>
          <ellipse class="lamp-glow" cx="330" cy="150" rx="55" ry="60" fill="#fddc6c" opacity="0.4"/>
          <circle cx="330" cy="112" r="4" fill="#fddc6c"/>
        </g>

        <!-- cactus -->
        <g class="cactus">
          <rect x="440" y="405" width="60" height="26" rx="6" fill="#2a2f5c" stroke="#4b447f" stroke-width="2.5"/>
          <path d="M462 405 C462 350 476 330 470 300 M470 300 C470 300 486 305 486 330 C486 350 470 355 470 355"
                fill="none" stroke="#3fae7a" stroke-width="10" stroke-linecap="round"/>
          <path d="M462 380 C462 380 445 378 445 360 C445 345 458 342 458 342"
                fill="none" stroke="#3fae7a" stroke-width="8" stroke-linecap="round"/>
        </g>

        <!-- yarn ball with string -->
        <g>
          <path class="string" d="M370 400 C 330 420, 300 380, 250 360" fill="none" stroke="#ef4a63" stroke-width="2"/>
          <g class="yarn">
            <circle cx="390" cy="400" r="30" fill="#ef4a63"/>
            <path d="M365 388 C385 378 400 392 415 384" fill="none" stroke="#d63653" stroke-width="2"/>
            <path d="M362 402 C384 398 400 412 418 402" fill="none" stroke="#d63653" stroke-width="2"/>
            <path d="M368 416 C388 424 402 410 412 420" fill="none" stroke="#d63653" stroke-width="2"/>
          </g>
        </g>

        <!-- cat -->
        <g>
          <!-- tail -->
          <path class="cat-tail" d="M260 300 C 210 300 190 350 220 390 C 235 410 260 400 258 380"
                fill="none" stroke="#242849" stroke-width="16" stroke-linecap="round"/>

          <!-- body -->
          <path d="M150 460
                   C140 380 165 320 235 320
                   C305 320 330 380 320 460
                   Z"
                fill="#242849"/>

          <!-- ears -->
          <path d="M168 330 L150 275 L200 305 Z" fill="#242849"/>
          <path d="M302 330 L322 275 L272 305 Z" fill="#242849"/>
          <path d="M172 320 L162 288 L192 305 Z" fill="#3a3f6e"/>
          <path d="M298 320 L308 288 L278 305 Z" fill="#3a3f6e"/>

          <!-- head -->
          <ellipse cx="235" cy="345" rx="72" ry="62" fill="#242849"/>

          <!-- face highlight -->
          <ellipse cx="235" cy="365" rx="46" ry="32" fill="#2c3159"/>

          <!-- eyes -->
          <g class="cat-eyes">
            <ellipse cx="208" cy="345" rx="10" ry="13" fill="#7bffa0"/>
            <ellipse cx="264" cy="345" rx="10" ry="13" fill="#7bffa0"/>
            <ellipse cx="208" cy="348" rx="3.4" ry="6" fill="#0c0e1f"/>
            <ellipse cx="264" cy="348" rx="3.4" ry="6" fill="#0c0e1f"/>
          </g>

          <!-- nose -->
          <path d="M228 372 L242 372 L235 380 Z" fill="#ef4a63"/>

          <!-- whiskers -->
          <g stroke="#5a5f92" stroke-width="1.6" stroke-linecap="round">
            <line x1="150" y1="368" x2="112" y2="360"/>
            <line x1="150" y1="378" x2="112" y2="380"/>
            <line x1="320" y1="368" x2="358" y2="360"/>
            <line x1="320" y1="378" x2="358" y2="380"/>
          </g>

          <!-- front paws -->
          <ellipse cx="205" cy="450" rx="20" ry="14" fill="#2c3159"/>
          <ellipse cx="265" cy="450" rx="20" ry="14" fill="#2c3159"/>
        </g>

      </svg>
    </div>

  </div>
</main>

</body>
</html>