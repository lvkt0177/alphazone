<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>500 — Lỗi máy chủ</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>
  :root{
    --ink:#1a1a1a;
    --muted:#6b6b76;
    --violet:#5b21b6;
    --violet-deep:#3c1361;
    --violet-tint:#f3eefc;
    --gold:#f4c430;
    --paper:#ffffff;
    --line:#ece8f5;
  }

  *{margin:0;padding:0;box-sizing:border-box;}

  html,body{
    height:100%;
    background:var(--paper);
    color:var(--ink);
    font-family:'Be Vietnam Pro', sans-serif;
    overflow-x:hidden;
  }

  body{
    display:flex;
    align-items:center;
    justify-content:center;
    min-height:100vh;
    padding:40px 24px;
  }

  .wrap{
    width:100%;
    max-width:1080px;
    display:grid;
    grid-template-columns:1.05fr 1fr;
    align-items:center;
    gap:48px;
  }

  .eyebrow{
    display:inline-flex;
    align-items:center;
    gap:8px;
    font-size:13px;
    font-weight:600;
    letter-spacing:.08em;
    color:var(--violet);
    text-transform:uppercase;
    margin-bottom:22px;
  }
  .eyebrow::before{
    content:"";
    width:7px;height:7px;
    border-radius:50%;
    background:var(--gold);
    box-shadow:0 0 0 3px var(--violet-tint);
  }

  .code{
    font-weight:800;
    font-size:clamp(72px,11vw,128px);
    line-height:0.9;
    letter-spacing:-.03em;
    color:var(--ink);
    margin-bottom:8px;
  }
  .code span{ color:var(--violet); }

  h1{
    font-weight:700;
    font-size:clamp(22px,3vw,30px);
    margin-bottom:14px;
    letter-spacing:-.01em;
  }

  p.desc{
    font-weight:400;
    font-size:16px;
    line-height:1.65;
    color:var(--muted);
    max-width:440px;
    margin-bottom:8px;
  }

  .reason{
    display:flex;
    align-items:center;
    gap:10px;
    margin:22px 0 30px;
    padding:12px 16px;
    background:var(--violet-tint);
    border:1px solid var(--line);
    border-radius:10px;
    font-size:14px;
    color:var(--violet-deep);
    max-width:440px;
  }
  .reason svg{flex:0 0 auto;}

  .actions{
    display:flex;
    gap:14px;
    flex-wrap:wrap;
  }

  .btn{
    appearance:none;
    border:none;
    cursor:pointer;
    font-family:inherit;
    font-weight:600;
    font-size:15px;
    padding:14px 26px;
    border-radius:999px;
    transition:transform .18s ease, box-shadow .18s ease, background .18s ease;
  }
  .btn-primary{
    background:var(--violet);
    color:#fff;
    box-shadow:0 8px 20px -8px rgba(91,33,182,.55);
  }
  .btn-primary:hover{ background:var(--violet-deep); transform:translateY(-2px); box-shadow:0 12px 24px -8px rgba(91,33,182,.6); }
  .btn-ghost{
    background:transparent;
    color:var(--ink);
    border:1.5px solid var(--line);
  }
  .btn-ghost:hover{ border-color:var(--violet); color:var(--violet); transform:translateY(-2px); }

  .contact{
    margin-top:26px;
    font-size:13.5px;
    color:var(--muted);
  }
  .contact a{ color:var(--violet); font-weight:600; text-decoration:none; }
  .contact a:hover{ text-decoration:underline; }

  .code-id{
    margin-top:10px;
    font-size:12.5px;
    color:var(--muted);
    font-family:monospace;
  }
  .code-id b{ color:var(--ink); font-weight:600; }

  /* Illustration */
  .stage{
    position:relative;
    display:flex;
    align-items:flex-end;
    justify-content:center;
    height:420px;
  }

  .ground{
    position:absolute;
    bottom:26px;
    left:0; right:0;
    height:2px;
    background:var(--line);
  }

  .server-wrap{
    position:relative;
    width:180px;
    animation:shake 3.2s ease-in-out infinite;
  }
  @keyframes shake{
    0%,88%,100%{ transform:translate(0,0) rotate(0deg); }
    90%{ transform:translate(-2px,0) rotate(-0.6deg); }
    92%{ transform:translate(2px,0) rotate(0.6deg); }
    94%{ transform:translate(-1.5px,0) rotate(-0.4deg); }
    96%{ transform:translate(1.5px,0) rotate(0.4deg); }
    98%{ transform:translate(0,0) rotate(0deg); }
  }

  .rack{
    position:relative;
    width:100%;
    background:var(--violet-deep);
    border:3px solid var(--violet);
    border-radius:16px;
    padding:14px;
    box-shadow:0 20px 40px -18px rgba(60,19,97,.45);
  }

  .unit{
    height:38px;
    background:rgba(255,255,255,.06);
    border:1px solid rgba(255,255,255,.12);
    border-radius:6px;
    margin-bottom:8px;
    display:flex;
    align-items:center;
    padding:0 10px;
    gap:8px;
    position:relative;
  }
  .unit:last-child{ margin-bottom:0; }

  .dot{
    width:6px;height:6px;
    border-radius:50%;
    background:#5fd97a;
  }
  .unit.err .dot{
    background:#ff5c5c;
    animation:blinkred 1.1s ease-in-out infinite;
  }
  @keyframes blinkred{
    0%,100%{ opacity:1; }
    50%{ opacity:.25; }
  }

  .bars{
    display:flex;
    gap:3px;
    margin-left:auto;
  }
  .bars i{
    width:3px;
    background:rgba(255,255,255,.35);
    border-radius:2px;
  }
  .unit .bars i:nth-child(1){height:8px;}
  .unit .bars i:nth-child(2){height:12px;}
  .unit .bars i:nth-child(3){height:6px;}
  .unit.err .bars i{ background:#ff5c5c; }

  .crack{
    position:absolute;
    top:-6px; left:38%;
    width:26px; height:52px;
    opacity:.9;
  }

  .spark{
    position:absolute;
    top:-10px; right:22px;
    width:22px; height:22px;
  }

  .badge-x{
    position:absolute;
    top:-14px; right:-14px;
    width:34px; height:34px;
    background:var(--gold);
    border-radius:50%;
    display:flex;
    align-items:center;
    justify-content:center;
    box-shadow:0 6px 14px -6px rgba(0,0,0,.35);
  }

  .grass{
    position:absolute;
    bottom:22px;
    width:14px; height:16px;
  }
  .grass.g1{ left:-38px; }
  .grass.g2{ right:-42px; }
  .grass svg{ width:100%; height:100%; }

  @media (max-width:820px){
    .wrap{ grid-template-columns:1fr; text-align:center; }
    .actions{ justify-content:center; }
    p.desc, .reason{ margin-left:auto; margin-right:auto; }
    .stage{ height:340px; margin-top:12px; }
  }

  @media (prefers-reduced-motion:reduce){
    .server-wrap{ animation:none; }
    .unit.err .dot{ animation:none; }
  }
</style>
</head>
<body>

<div class="wrap">

  <div class="text-col">
    <div class="eyebrow">Mã lỗi 500</div>
    <div class="code">5<span>0</span>0</div>
    <h1>Lỗi máy chủ nội bộ</h1>
    <p class="desc">
      Đã có sự cố xảy ra ở phía máy chủ khi xử lý yêu cầu của bạn.
      Đây không phải lỗi do bạn gây ra.
    </p>

    <div class="reason">
      <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
        <path d="M12 2L3 6v6c0 5 3.8 8.7 9 10 5.2-1.3 9-5 9-10V6l-9-4z" stroke="#5b21b6" stroke-width="1.8" stroke-linejoin="round"/>
        <path d="M12 8v5" stroke="#5b21b6" stroke-width="1.8" stroke-linecap="round"/>
        <circle cx="12" cy="16" r="1" fill="#5b21b6"/>
      </svg>
      Hệ thống đang gặp sự cố tạm thời, vui lòng thử lại sau ít phút.
    </div>

    <div class="actions">
      <button class="btn btn-primary" onclick="window.location.reload()">Thử lại</button>
      <button class="btn btn-ghost" onclick="window.location.href='/'">Về trang chủ</button>
    </div>

    <p class="contact">
      Sự cố vẫn tiếp diễn? Liên hệ bộ phận hỗ trợ kỹ thuật.
    </p>
    <p class="code-id">Mã tham chiếu: <b>ERR-500-<span id="ref"></span></b></p>
  </div>

  <div class="stage">
    <div class="ground"></div>
    <div class="server-wrap">
      <div class="grass g1"><svg viewBox="0 0 14 16"><path d="M2 16C2 10 4 6 2 0" stroke="#c9c2e6" stroke-width="1.5" fill="none"/><path d="M7 16C7 9 9 5 7 0" stroke="#c9c2e6" stroke-width="1.5" fill="none"/><path d="M12 16C12 11 13 7 12 2" stroke="#c9c2e6" stroke-width="1.5" fill="none"/></svg></div>
      <div class="grass g2"><svg viewBox="0 0 14 16"><path d="M2 16C2 10 4 6 2 0" stroke="#c9c2e6" stroke-width="1.5" fill="none"/><path d="M7 16C7 9 9 5 7 0" stroke="#c9c2e6" stroke-width="1.5" fill="none"/><path d="M12 16C12 11 13 7 12 2" stroke="#c9c2e6" stroke-width="1.5" fill="none"/></svg></div>

      <div class="rack">
        <div class="badge-x">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
            <path d="M6 6l12 12M18 6L6 18" stroke="#1a1a1a" stroke-width="2.4" stroke-linecap="round"/>
          </svg>
        </div>
        <div class="unit"><span class="dot"></span><div class="bars"><i></i><i></i><i></i></div></div>
        <div class="unit err"><span class="dot"></span><div class="bars"><i></i><i></i><i></i></div></div>
        <div class="unit"><span class="dot"></span><div class="bars"><i></i><i></i><i></i></div></div>
        <div class="unit err"><span class="dot"></span><div class="bars"><i></i><i></i><i></i></div></div>
      </div>
    </div>
  </div>

</div>

<script>
  document.getElementById('ref').textContent = Math.random().toString(36).slice(2,8).toUpperCase();
</script>

</body>
</html>