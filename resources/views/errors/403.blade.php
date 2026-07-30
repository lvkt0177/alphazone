<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>403 — Không có quyền truy cập</title>
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

  .gate-wrap{
    position:relative;
    width:230px;
    animation:float 5s ease-in-out infinite;
  }
  @keyframes float{
    0%,100%{ transform:translateY(0); }
    50%{ transform:translateY(-6px); }
  }

  .post{
    position:absolute;
    bottom:26px;
    width:8px;
    height:120px;
    background:#e3ddf4;
    border-radius:4px;
  }
  .post.left{ left:-6px; }
  .post.right{ right:-6px; }

  .door{
    position:relative;
    width:100%;
    height:260px;
    background:var(--violet-deep);
    border:3px solid var(--violet);
    border-radius:115px 115px 8px 8px;
    box-shadow:0 20px 40px -18px rgba(60,19,97,.45);
  }

  .eyes{
    position:absolute;
    top:78px; left:0; right:0;
    display:flex;
    justify-content:center;
    gap:26px;
  }
  .eye{
    width:16px; height:3px;
    background:#f3eefc;
    border-radius:2px;
    animation:blink 4s ease-in-out infinite;
  }
  @keyframes blink{
    0%,92%,100%{ transform:scaleY(1); }
    95%{ transform:scaleY(0.2); }
  }

  .lock{
    position:absolute;
    left:50%; top:150px;
    transform:translateX(-50%);
    width:34px; height:34px;
    background:var(--gold);
    border-radius:8px;
    display:flex;
    align-items:center;
    justify-content:center;
    box-shadow:0 6px 14px -6px rgba(0,0,0,.35);
  }

  .tape{
    position:absolute;
    left:-30px; right:-30px;
    height:26px;
    background:repeating-linear-gradient(
      -45deg,
      var(--gold),
      var(--gold) 12px,
      #1a1a1a 12px,
      #1a1a1a 14px
    );
    background-color:var(--gold);
    display:flex;
    align-items:center;
    justify-content:center;
    box-shadow:0 4px 10px -4px rgba(0,0,0,.25);
    transform:rotate(-2deg);
  }
  .tape span{
    background:var(--gold);
    padding:0 10px;
    font-size:11px;
    font-weight:800;
    letter-spacing:.06em;
    color:#1a1a1a;
    white-space:nowrap;
  }
  .tape.t1{ top:118px; }
  .tape.t2{ top:158px; transform:rotate(2deg); }

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
    .gate-wrap{ animation:none; }
    .eye{ animation:none; }
  }
</style>
</head>
<body>

<div class="wrap">

  <div class="text-col">
    <div class="eyebrow">Mã lỗi 403</div>
    <div class="code">4<span>0</span>3</div>
    <h1>Không có quyền truy cập</h1>
    <p class="desc">
      Bạn không có quyền sử dụng chức năng này. Trang bạn vừa cố mở
      hiện chỉ dành cho những tài khoản được cấp phép truy cập.
    </p>

    <div class="reason">
      <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
        <path d="M12 2L3 6v6c0 5 3.8 8.7 9 10 5.2-1.3 9-5 9-10V6l-9-4z" stroke="#5b21b6" stroke-width="1.8" stroke-linejoin="round"/>
        <path d="M12 8v5" stroke="#5b21b6" stroke-width="1.8" stroke-linecap="round"/>
        <circle cx="12" cy="16" r="1" fill="#5b21b6"/>
      </svg>
      Khu vực này được bảo vệ theo phân quyền tài khoản.
    </div>

    <div class="actions">
      <button class="btn btn-primary" onclick="window.location.href='/'">Về trang chủ</button>
    </div>
  </div>

  <div class="stage">
    <div class="ground"></div>
    <div class="gate-wrap">
      <div class="post left"></div>
      <div class="post right"></div>
      <div class="grass g1"><svg viewBox="0 0 14 16"><path d="M2 16C2 10 4 6 2 0" stroke="#c9c2e6" stroke-width="1.5" fill="none"/><path d="M7 16C7 9 9 5 7 0" stroke="#c9c2e6" stroke-width="1.5" fill="none"/><path d="M12 16C12 11 13 7 12 2" stroke="#c9c2e6" stroke-width="1.5" fill="none"/></svg></div>
      <div class="grass g2"><svg viewBox="0 0 14 16"><path d="M2 16C2 10 4 6 2 0" stroke="#c9c2e6" stroke-width="1.5" fill="none"/><path d="M7 16C7 9 9 5 7 0" stroke="#c9c2e6" stroke-width="1.5" fill="none"/><path d="M12 16C12 11 13 7 12 2" stroke="#c9c2e6" stroke-width="1.5" fill="none"/></svg></div>

      <div class="door">
        <div class="eyes">
          <div class="eye"></div>
          <div class="eye"></div>
        </div>
        <div class="lock">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
            <rect x="5" y="11" width="14" height="10" rx="2" fill="#1a1a1a"/>
            <path d="M8 11V8a4 4 0 0 1 8 0v3" stroke="#1a1a1a" stroke-width="2"/>
          </svg>
        </div>
        <div class="tape t1"><span>KHÔNG PHẬN SỰ MIỄN VÀO</span></div>
        <div class="tape t2"><span>KHU VỰC HẠN CHẾ</span></div>
      </div>
    </div>
  </div>

</div>

</body>
</html>