<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Pimienta Express — en la hora del almuerzo</title>
<style>
  @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600&display=swap');

  :root{
    --bg-deep:#06241c;
    --bg-deep-2:#0a2e23;
    --green:#0c6b41;
    --green-bright:#16a85f;
    --green-soft:#1e8a5a;
    --cream:#f3f1e9;
    --cream-2:#ece7d8;
    --white:#ffffff;
    --muted:#9fb8ad;
    --ink:#142b22;
    --ink-soft:#4d6058;
    --amber:#e3a23b;
    --amber-deep:#c9852a;
    --line:rgba(20,43,34,0.14);
    --line-dark:rgba(255,255,255,0.12);
  }

  *{margin:0;padding:0;box-sizing:border-box;}
  html{scroll-behavior:smooth;}
  body{font-family:'Inter',sans-serif;background:var(--bg-deep);color:var(--cream);overflow-x:hidden;}
  a{text-decoration:none;color:inherit;}
  button{font-family:inherit;cursor:pointer;border:none;background:none;}
  img{display:block;max-width:100%;}
  .wrap{max-width:1320px;margin:0 auto;padding:0 48px;}
  h1,h2,h3{font-family:'Plus Jakarta Sans',sans-serif;}

  /* ===== PRELOADER ===== */
  #preloader{
    position:fixed;inset:0;z-index:99999;
    background:var(--bg-deep);
    display:flex;align-items:center;justify-content:center;
    transition:opacity 0.8s ease;
    overflow:hidden;
  }
  #preloader.hidden{opacity:0;pointer-events:none;}
  #preloader canvas{position:absolute;inset:0;pointer-events:none;}
  .loader-center{
    position:relative;z-index:10;
    display:flex;flex-direction:column;align-items:center;gap:28px;
  }
  .logo-ring{position:relative;width:148px;height:148px;display:flex;align-items:center;justify-content:center;}
  .ring-svg{position:absolute;inset:0;width:100%;height:100%;}
  .logo-circle{
    width:100px;height:100px;border-radius:50%;
    background:radial-gradient(circle at 38% 32%,var(--green-bright),var(--green) 70%);
    display:flex;align-items:center;justify-content:center;
    font-family:'Plus Jakarta Sans',sans-serif;font-weight:800;color:#fff;font-size:30px;
    position:relative;z-index:2;
    animation:logoPulse 2.4s ease-in-out infinite;
  }
  @keyframes logoPulse{
    0%,100%{transform:scale(1);box-shadow:0 0 0 0 rgba(22,168,95,0.5);}
    50%{transform:scale(1.07);box-shadow:0 0 0 22px rgba(22,168,95,0);}
  }
  .loader-brand{font-family:'Plus Jakarta Sans',sans-serif;font-weight:800;font-size:24px;color:#fff;letter-spacing:0.5px;text-align:center;animation:fadeUp .8s ease .3s both;}
  .loader-sub{font-size:12px;font-weight:500;color:var(--muted);letter-spacing:2px;text-transform:uppercase;margin-top:4px;text-align:center;animation:fadeUp .8s ease .5s both;}
  .loader-progress{width:200px;height:3px;background:rgba(255,255,255,0.1);border-radius:3px;overflow:hidden;animation:fadeUp .8s ease .7s both;}
  .loader-fill{height:100%;width:0%;border-radius:3px;background:linear-gradient(90deg,var(--green-bright),var(--amber));animation:fillGrow 3s cubic-bezier(.4,0,.2,1) .4s both;}
  @keyframes fillGrow{from{width:0%;}to{width:100%;}}
  .loader-dots{display:flex;gap:7px;animation:fadeUp .8s ease .9s both;}
  .loader-dot{width:6px;height:6px;border-radius:50%;background:var(--green-bright);animation:dotBounce 1.2s ease-in-out infinite;}
  .loader-dot:nth-child(2){animation-delay:.15s;background:var(--green-soft);}
  .loader-dot:nth-child(3){animation-delay:.30s;background:var(--muted);}
  @keyframes dotBounce{0%,100%{transform:translateY(0);opacity:.6;}50%{transform:translateY(-7px);opacity:1;}}
  .loader-status{font-size:11px;color:var(--muted);letter-spacing:1.5px;text-transform:uppercase;animation:fadeUp .8s ease 1s both;transition:opacity .35s;}
  @keyframes fadeUp{from{opacity:0;transform:translateY(10px);}to{opacity:1;transform:none;}}

  /* ===== NAV ===== */
  header{position:fixed;top:0;left:0;right:0;z-index:900;padding:22px 0;background:rgba(6,36,28,0.85);backdrop-filter:blur(14px);border-bottom:1px solid rgba(255,255,255,0.06);transition:padding .3s;}
  header.scrolled{padding:14px 0;}
  nav{display:flex;align-items:center;justify-content:space-between;}
  .logo{display:flex;align-items:center;gap:10px;font-family:'Plus Jakarta Sans',sans-serif;font-weight:800;font-size:20px;letter-spacing:.5px;color:var(--white);}
  .logo-mark{width:40px;height:40px;border-radius:50%;background:radial-gradient(circle at 35% 30%,var(--green-bright),var(--green) 70%);display:flex;align-items:center;justify-content:center;font-family:'Plus Jakarta Sans',sans-serif;font-weight:800;color:var(--white);font-size:15px;}
  .nav-links{display:flex;align-items:center;gap:32px;list-style:none;font-size:14px;font-weight:500;color:var(--cream);}
  .nav-links a{opacity:.88;position:relative;padding-bottom:4px;}
  .nav-links a::after{content:'';position:absolute;left:0;bottom:0;width:0;height:2px;background:var(--green-bright);transition:width .25s ease;}
  .nav-links a:hover::after{width:100%;}
  .nav-cta{padding:10px 22px;background:linear-gradient(180deg,var(--green-bright),var(--green));color:var(--white);border-radius:30px;font-size:13.5px;font-weight:600;transition:transform .2s,box-shadow .2s;}
  .nav-cta:hover{transform:translateY(-2px);box-shadow:0 12px 24px -8px rgba(22,168,95,.5);}
  .nav-mobile-btn{display:none;width:40px;height:40px;align-items:center;justify-content:center;border-radius:10px;border:1px solid var(--line-dark);color:var(--cream);}
  .nav-mobile-btn svg{width:20px;height:20px;}

  /* ===== HERO ===== */
  .hero{position:relative;min-height:100vh;display:flex;align-items:center;padding-top:100px;}
  .hero-grid{width:100%;display:grid;grid-template-columns:1.05fr 1fr;align-items:center;gap:20px;}
  .hero-copy{position:relative;z-index:10;}
  .eyebrow{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:13px;color:var(--green-bright);letter-spacing:2px;text-transform:uppercase;margin-bottom:16px;display:flex;align-items:center;gap:8px;}
  .eyebrow::before{content:'';width:20px;height:2px;background:var(--green-bright);display:inline-block;}
  .headline{font-family:'Plus Jakarta Sans',sans-serif;font-weight:500;font-size:62px;line-height:1.05;color:var(--white);letter-spacing:-1px;}
  .headline b{font-weight:800;}
  .sub{margin-top:24px;max-width:420px;color:var(--muted);font-size:15.5px;line-height:1.75;}
  .cta-row{display:flex;gap:14px;margin-top:36px;flex-wrap:wrap;}
  .btn{padding:15px 26px;border-radius:40px;font-size:14px;font-weight:600;display:inline-flex;align-items:center;gap:10px;transition:transform .2s ease,box-shadow .2s ease;}
  .btn-fill{background:linear-gradient(180deg,var(--green-bright),var(--green));color:var(--white);box-shadow:0 12px 24px -8px rgba(22,168,95,.5);}
  .btn-outline{background:var(--cream);color:var(--bg-deep);}
  .btn:hover{transform:translateY(-3px);}
  .btn-sm{padding:12px 20px;font-size:13px;}

  .strip{display:flex;gap:12px;margin-top:60px;flex-wrap:wrap;}
  .strip-item{width:100px;height:118px;border-radius:16px;background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.07);display:flex;align-items:center;justify-content:center;cursor:pointer;position:relative;overflow:hidden;transition:border-color .25s,background .25s,transform .25s;}
  .strip-item img{width:78%;height:78%;object-fit:contain;filter:drop-shadow(0 8px 10px rgba(0,0,0,.45));transition:transform .3s;}
  .strip-item:hover img{transform:scale(1.07) translateY(-2px);}
  .strip-item.active{border-color:var(--green-bright);background:rgba(22,168,95,0.12);}
  .strip-item.active::after{content:'';position:absolute;bottom:8px;left:50%;transform:translateX(-50%);width:18px;height:3px;border-radius:3px;background:var(--green-bright);}

  .hero-visual{position:relative;height:780px;display:flex;align-items:center;justify-content:center;}
  .panel{position:absolute;right:-48px;top:0;width:560px;height:780px;background:linear-gradient(155deg,var(--green-bright) 0%,var(--green) 55%,#064128 100%);border-radius:48px 0 0 48px;overflow:hidden;}
  .panel-label{position:absolute;top:0;right:38px;height:100%;display:flex;align-items:center;gap:18px;}
  .panel-label span{font-family:'Plus Jakarta Sans',sans-serif;font-weight:800;font-size:50px;letter-spacing:2px;writing-mode:vertical-rl;transform:rotate(180deg);color:rgba(255,255,255,0.95);white-space:nowrap;transition:opacity .4s;}
  .panel-label .ghost{color:transparent;-webkit-text-stroke:1px rgba(255,255,255,0.3);}

  .slider-stage{position:relative;width:540px;height:760px;z-index:5;display:flex;align-items:center;justify-content:center;}
  .slide{position:absolute;inset:0;display:flex;align-items:center;justify-content:center;opacity:0;transform:scale(.82) translateY(30px) rotate(-4deg);transition:opacity .55s cubic-bezier(.2,.8,.2,1),transform .55s cubic-bezier(.2,.8,.2,1);pointer-events:none;}
  .slide.active{opacity:1;transform:scale(1) translateY(0) rotate(-4deg);pointer-events:auto;}
  .slide img{width:auto;height:540px;max-width:420px;object-fit:contain;filter:drop-shadow(0 40px 40px rgba(0,0,0,.5));}

  .beans{position:absolute;width:140px;bottom:120px;left:18px;z-index:6;filter:drop-shadow(0 18px 18px rgba(0,0,0,.5));animation:float 5s ease-in-out infinite;}
  @keyframes float{0%,100%{transform:translateY(0) rotate(0deg);}50%{transform:translateY(-14px) rotate(4deg);}}

  .like-btn{position:absolute;top:48%;left:6px;z-index:7;width:52px;height:52px;border-radius:50%;background:var(--white);display:flex;align-items:center;justify-content:center;box-shadow:0 14px 30px -6px rgba(0,0,0,.5);cursor:pointer;transition:transform .2s;}
  .like-btn:hover{transform:scale(1.1);}
  .like-btn svg{width:22px;height:22px;}
  .like-btn path{fill:#d61f4e;}

  .slider-controls{position:absolute;bottom:40px;right:64px;z-index:8;display:flex;align-items:center;gap:18px;}
  .like-count{display:flex;align-items:center;gap:8px;color:var(--white);font-weight:700;font-size:16px;}
  .like-count svg{width:17px;height:17px;}
  .like-count path{fill:none;stroke:var(--white);stroke-width:2;}
  .arrow-group{display:flex;gap:8px;}
  .arrow-btn{width:42px;height:42px;border-radius:50%;background:rgba(255,255,255,0.12);border:1px solid rgba(255,255,255,0.25);display:flex;align-items:center;justify-content:center;color:var(--white);transition:background .2s,transform .2s;}
  .arrow-btn:hover{background:var(--white);color:var(--bg-deep);transform:translateY(-2px);}
  .arrow-btn.next{background:rgba(255,255,255,0.92);color:var(--bg-deep);}
  .arrow-btn svg{width:16px;height:16px;}

  .slide-dots{position:absolute;left:40px;bottom:40px;z-index:8;display:flex;flex-direction:column;gap:9px;}
  .slide-dots button{width:9px;height:9px;border-radius:50%;background:rgba(255,255,255,0.35);transition:all .3s;}
  .slide-dots button.active{background:var(--white);height:24px;border-radius:6px;}

  .caption{position:absolute;top:60px;left:50%;transform:translateX(-50%);text-align:center;z-index:8;width:100%;}
  .caption .name{font-family:'Plus Jakarta Sans',sans-serif;font-weight:800;font-size:24px;color:var(--bg-deep);background:var(--white);display:inline-block;padding:8px 22px;border-radius:30px;box-shadow:0 12px 24px -8px rgba(0,0,0,.3);}

  .blob{position:absolute;border-radius:50%;filter:blur(70px);opacity:.28;z-index:0;pointer-events:none;}
  .blob1{width:400px;height:400px;background:var(--green);top:-100px;left:-160px;}
  .blob2{width:300px;height:300px;background:var(--green);bottom:-60px;left:35%;opacity:.15;}

  /* ===== MARQUEE ===== */
  .marquee{background:var(--amber);color:var(--ink);padding:15px 0;overflow:hidden;position:relative;z-index:5;}
  .marquee-track{display:flex;width:max-content;animation:scrollTicker 28s linear infinite;}
  .marquee-track span{font-family:'Plus Jakarta Sans',sans-serif;font-weight:800;font-size:17px;letter-spacing:1px;padding:0 26px;display:flex;align-items:center;gap:26px;white-space:nowrap;}
  .marquee-track span::after{content:'•';opacity:.5;}
  @keyframes scrollTicker{from{transform:translateX(0);}to{transform:translateX(-50%);}}

  /* ===== SECTION BASICS ===== */
  section{position:relative;}
  .section-pad{padding:120px 0;}
  .tag{display:inline-flex;align-items:center;gap:8px;font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:12.5px;letter-spacing:1.5px;text-transform:uppercase;}
  .tag::before{content:'';width:18px;height:2px;background:currentColor;display:inline-block;}

  /* ===== ABOUT ===== */
  .about{background:var(--bg-deep);}
  .about-grid{display:grid;grid-template-columns:1fr 1fr;gap:80px;align-items:center;}
  .about .tag{color:var(--green-bright);}
  .about h2{font-size:42px;font-weight:500;line-height:1.15;margin-top:18px;color:var(--white);letter-spacing:-.5px;}
  .about h2 b{font-weight:800;}
  .about p.lead{margin-top:22px;color:var(--muted);font-size:15.5px;line-height:1.8;max-width:460px;}

  .ticket{margin-top:36px;background:var(--white);border-radius:4px;padding:26px 26px 30px;max-width:340px;position:relative;box-shadow:0 30px 50px -20px rgba(20,43,34,0.25);}
  .ticket::before,.ticket::after{content:'';position:absolute;left:0;right:0;height:14px;background:radial-gradient(circle,var(--cream) 7px,transparent 7.5px);background-size:24px 14px;background-repeat:repeat-x;}
  .ticket::before{top:-7px;} .ticket::after{bottom:-7px;}
  .ticket-head{display:flex;justify-content:space-between;align-items:baseline;border-bottom:1px dashed var(--line);padding-bottom:12px;margin-bottom:14px;}
  .ticket-head span:first-child{font-family:'Plus Jakarta Sans',sans-serif;font-weight:800;font-size:13px;letter-spacing:1px;color:var(--ink);}
  .ticket-head span:last-child{font-size:11px;color:var(--ink-soft);}
  .ticket-row{display:flex;justify-content:space-between;font-size:13.5px;padding:7px 0;color:var(--ink-soft);}
  .ticket-row b{color:var(--ink);font-weight:700;}
  .ticket-total{display:flex;justify-content:space-between;margin-top:12px;padding-top:12px;border-top:1px dashed var(--line);font-family:'Plus Jakarta Sans',sans-serif;font-weight:800;font-size:14px;color:var(--green);}

  .about-photo{position:relative;}
  .about-photo img{width:100%;border-radius:28px;height:520px;object-fit:cover;}
  .about-badge{position:absolute;bottom:-24px;left:-24px;background:var(--bg-deep);color:var(--cream);border-radius:50%;width:124px;height:124px;display:flex;align-items:center;justify-content:center;text-align:center;font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:12px;line-height:1.4;box-shadow:0 20px 40px -10px rgba(0,0,0,.35);}
  .about-badge b{display:block;font-size:26px;font-weight:800;color:var(--green-bright);}

  /* ===== STATS BAR ===== */
  .stats-bar{background:var(--green);padding:52px 0;}
  .stats-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:32px;text-align:center;}
  .stat-num{font-family:'Plus Jakarta Sans',sans-serif;font-weight:800;font-size:40px;color:var(--white);}
  .stat-label{font-size:13px;color:rgba(255,255,255,0.75);margin-top:4px;font-weight:500;}

  /* ===== BUFFET ===== */
  .buffet{background:var(--cream-2);color:var(--ink);}
  .buffet-grid{display:grid;grid-template-columns:.9fr 1.1fr;gap:70px;align-items:center;}
  .buffet .tag{color:var(--amber-deep);}
  .buffet h2{font-size:40px;font-weight:500;margin-top:16px;line-height:1.16;letter-spacing:-.5px;color:var(--ink);}
  .buffet h2 b{font-weight:800;}
  .buffet p.lead{margin-top:18px;color:var(--ink-soft);font-size:15px;line-height:1.75;max-width:420px;}

  .clock-wrap{position:relative;width:100%;max-width:420px;}
  .clock-photo{position:relative;border-radius:26px;overflow:hidden;height:420px;}
  .clock-photo img{width:100%;height:100%;object-fit:cover;}
  .clock-chip{position:absolute;left:-20px;bottom:32px;background:var(--white);border-radius:16px;padding:14px 18px;box-shadow:0 24px 50px -16px rgba(20,43,34,0.35);display:flex;align-items:center;gap:12px;min-width:190px;}
  .clock-chip .ico{width:36px;height:36px;border-radius:50%;background:var(--amber);display:flex;align-items:center;justify-content:center;flex-shrink:0;}
  .clock-chip .ico svg{width:17px;height:17px;stroke:var(--ink);fill:none;stroke-width:2;}
  .clock-chip b{display:block;font-size:13px;font-family:'Plus Jakarta Sans',sans-serif;font-weight:800;color:var(--ink);}
  .clock-chip span{font-size:11px;color:var(--ink-soft);}
  .clock-chip.top{left:auto;right:-16px;top:28px;bottom:auto;}

  .toggle{display:inline-flex;background:var(--white);border-radius:30px;padding:4px;border:1px solid var(--line);margin-top:32px;}
  .toggle button{padding:10px 22px;border-radius:24px;font-size:13.5px;font-weight:700;color:var(--ink-soft);transition:all .25s;}
  .toggle button.active{background:var(--bg-deep);color:var(--white);}

  .buffet-card{margin-top:26px;background:var(--white);border-radius:22px;padding:30px 32px;box-shadow:0 30px 60px -28px rgba(20,43,34,0.28);}
  .buffet-card-head{display:flex;justify-content:space-between;align-items:flex-start;gap:20px;flex-wrap:wrap;border-bottom:1px solid var(--line);padding-bottom:18px;margin-bottom:18px;}
  .buffet-card-head h3{font-size:20px;font-weight:700;color:var(--ink);}
  .buffet-card-head .hours{font-size:12px;color:var(--ink-soft);margin-top:5px;}
  .buffet-price{text-align:right;}
  .buffet-price b{font-family:'Plus Jakarta Sans',sans-serif;font-weight:800;font-size:28px;color:var(--green);display:block;}
  .buffet-price span{font-size:11px;color:var(--ink-soft);}
  .buffet-list{display:grid;grid-template-columns:1fr 1fr;gap:10px 22px;}
  .buffet-list li{list-style:none;display:flex;align-items:center;gap:9px;font-size:13.5px;color:var(--ink);}
  .buffet-list li svg{width:15px;height:15px;flex-shrink:0;stroke:var(--green-bright);fill:none;stroke-width:2.4;}
  .buffet-card .btn-fill{margin-top:24px;}

  /* ===== MENU ===== */
  .menu{background:var(--bg-deep-2);}
  .menu-head{text-align:center;max-width:560px;margin:0 auto;}
  .menu .tag{color:var(--green-bright);justify-content:center;display:flex;}
  .menu h2{font-size:42px;font-weight:500;margin-top:16px;letter-spacing:-.5px;color:var(--white);}
  .menu h2 b{font-weight:800;}

  .menu-tabs{display:flex;justify-content:center;gap:10px;margin-top:40px;flex-wrap:wrap;}
  .menu-tab{padding:10px 20px;border-radius:30px;font-size:13.5px;font-weight:600;border:1px solid var(--line-dark);color:var(--muted);transition:all .25s;}
  .menu-tab.active{background:var(--green-bright);color:var(--bg-deep);border-color:var(--green-bright);}
  .menu-tab:hover{border-color:var(--green-bright);color:var(--cream);}

  .menu-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:22px;margin-top:48px;}
  .menu-card{background:var(--bg-deep);border:1px solid var(--line-dark);border-radius:18px;overflow:hidden;position:relative;transition:transform .3s,border-color .3s;}
  .menu-card:hover{transform:translateY(-6px);border-color:var(--green-bright);}
  .menu-card .pic{height:188px;overflow:hidden;background:var(--green);}
  .menu-card .pic img{width:100%;height:100%;object-fit:cover;transition:transform .4s;}
  .menu-card:hover .pic img{transform:scale(1.08);}
  .menu-card .body{padding:18px 20px 22px;}
  .menu-card .row{display:flex;justify-content:space-between;align-items:baseline;gap:8px;}
  .menu-card h3{font-size:16px;font-weight:700;color:var(--white);}
  .menu-card .price{font-family:'Plus Jakarta Sans',sans-serif;font-weight:800;color:var(--green-bright);font-size:15px;white-space:nowrap;}
  .menu-card p{margin-top:7px;font-size:12.5px;color:var(--muted);line-height:1.6;}
  .menu-card .spice{position:absolute;top:12px;right:12px;background:var(--amber);color:var(--ink);font-size:10px;font-weight:800;letter-spacing:.5px;padding:4px 9px;border-radius:20px;}
  .menu-card .add-btn{margin-top:14px;padding:9px 18px;border-radius:30px;background:rgba(22,168,95,.15);color:var(--green-bright);font-size:12.5px;font-weight:700;border:1px solid rgba(22,168,95,.3);transition:all .2s;width:100%;}
  .menu-card .add-btn:hover{background:var(--green-bright);color:var(--bg-deep);}

  /* ===== GALLERY ===== */
  .gallery{background:var(--cream);color:var(--ink);}
  .gallery-head{display:flex;justify-content:space-between;align-items:flex-end;gap:24px;flex-wrap:wrap;}
  .gallery .tag{color:var(--green);}
  .gallery h2{font-size:38px;font-weight:500;margin-top:14px;letter-spacing:-.5px;max-width:440px;color:var(--ink);}
  .gallery h2 b{font-weight:800;}
  .gallery p{color:var(--ink-soft);font-size:14px;max-width:300px;line-height:1.7;}
  .gallery-grid{display:grid;grid-template-columns:repeat(4,1fr);grid-auto-rows:140px;gap:14px;margin-top:44px;}
  .gallery-grid img{width:100%;height:100%;object-fit:cover;border-radius:14px;transition:transform .4s,filter .4s;}
  .gallery-grid a{display:block;overflow:hidden;border-radius:14px;}
  .gallery-grid a:hover img{transform:scale(1.06);}
  .g1{grid-column:span 2;grid-row:span 2;}
  .g4{grid-column:span 2;}
  .g6{grid-row:span 2;}

  /* ===== REVIEWS ===== */
  .reviews{background:var(--bg-deep);}
  .reviews .tag{color:var(--green-bright);}
  .reviews h2{font-size:38px;font-weight:500;margin-top:16px;letter-spacing:-.5px;max-width:480px;color:var(--white);}
  .reviews h2 b{font-weight:800;}
  .review-row{display:grid;grid-template-columns:repeat(3,1fr);gap:22px;margin-top:52px;}
  .review-card{background:var(--bg-deep-2);border:1px solid var(--line-dark);border-radius:18px;padding:28px 26px;}
  .stars{color:var(--amber);font-size:15px;letter-spacing:2px;}
  .review-card p{margin-top:14px;font-size:14px;line-height:1.75;color:var(--cream);opacity:.9;}
  .reviewer{display:flex;align-items:center;gap:12px;margin-top:22px;}
  .reviewer img{width:40px;height:40px;border-radius:50%;object-fit:cover;}
  .reviewer .who b{display:block;font-size:13px;font-weight:700;color:var(--white);}
  .reviewer .who span{font-size:12px;color:var(--muted);}

  /* ===== RESERVE ===== */
  .reserve{background:linear-gradient(155deg,var(--bg-deep),var(--green) 50%,#073d28);overflow:hidden;}
  .reserve-grid{display:grid;grid-template-columns:1.1fr .9fr;gap:60px;align-items:center;}
  .reserve .tag{color:rgba(255,255,255,.85);}
  .reserve h2{font-size:40px;font-weight:500;margin-top:16px;letter-spacing:-.5px;line-height:1.18;color:var(--white);}
  .reserve h2 b{font-weight:800;}
  .reserve p.lead{margin-top:20px;color:rgba(255,255,255,.8);max-width:420px;font-size:15px;line-height:1.75;}
  .reserve-info{display:flex;gap:32px;margin-top:32px;flex-wrap:wrap;}
  .reserve-info div{font-size:13px;color:rgba(255,255,255,.85);}
  .reserve-info b{display:block;font-family:'Plus Jakarta Sans',sans-serif;font-weight:800;font-size:14px;margin-bottom:3px;color:var(--white);}

  .reserve-form{background:var(--white);color:var(--ink);border-radius:24px;padding:34px;box-shadow:0 40px 70px -20px rgba(0,0,0,.4);}
  .reserve-form h3{font-size:18px;font-weight:700;color:var(--ink);}
  .field-row{display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-top:18px;}
  .field{display:flex;flex-direction:column;gap:6px;}
  .field label{font-size:11.5px;font-weight:600;color:var(--ink-soft);}
  .field input,.field select,.field textarea{border:1px solid var(--line);border-radius:10px;padding:11px 13px;font-family:inherit;font-size:13.5px;color:var(--ink);background:var(--cream-2);}
  .field input:focus,.field select:focus,.field textarea:focus{outline:2px solid var(--green-bright);outline-offset:1px;}
  .reserve-form .btn-fill{width:100%;justify-content:center;margin-top:20px;padding:14px;}
  .confirm-msg{display:none;margin-top:12px;font-size:12.5px;color:var(--green);font-weight:600;}

  /* ===== PQRS ===== */
  .pqrs{background:var(--cream-2);color:var(--ink);}
  .pqrs-grid{display:grid;grid-template-columns:1.05fr .95fr;gap:70px;align-items:start;}
  .pqrs .tag{color:var(--amber-deep);}
  .pqrs h2{font-size:40px;font-weight:500;margin-top:16px;line-height:1.16;letter-spacing:-.5px;color:var(--ink);}
  .pqrs h2 b{font-weight:800;}
  .pqrs p.lead{margin-top:18px;color:var(--ink-soft);font-size:15px;line-height:1.75;max-width:440px;}
  .pqrs-types{display:flex;gap:10px;flex-wrap:wrap;margin-top:28px;}
  .pqrs-type{display:flex;align-items:center;gap:9px;padding:10px 18px 10px 14px;border-radius:30px;background:var(--white);border:1px solid var(--line);font-size:13px;font-weight:700;color:var(--ink-soft);transition:all .22s;}
  .pqrs-type .dot{width:9px;height:9px;border-radius:50%;flex-shrink:0;}
  .pqrs-type.active{background:var(--ink);color:var(--white);border-color:var(--ink);}

  .pqrs-quick{margin-top:28px;background:var(--white);border-radius:22px;padding:26px 28px 28px;box-shadow:0 30px 60px -32px rgba(20,43,34,0.28);}
  .pqrs-quick h4{font-size:12px;letter-spacing:.5px;color:var(--ink-soft);font-weight:700;margin-bottom:14px;}
  .pqrs-quick textarea{width:100%;border:1px solid var(--line);border-radius:12px;padding:12px 14px;font-family:inherit;font-size:13.5px;color:var(--ink);background:var(--cream-2);resize:vertical;min-height:80px;}
  .pqrs-quick .btn-fill{width:100%;justify-content:center;margin-top:16px;padding:13px;}

  .pqrs-ticket-wrap{position:sticky;top:100px;}
  .pqrs-ticket{position:relative;background:var(--bg-deep);color:var(--cream);border-radius:6px;padding:28px 28px 32px;box-shadow:0 36px 60px -22px rgba(6,36,28,0.5);}
  .pqrs-ticket::before,.pqrs-ticket::after{content:'';position:absolute;left:0;right:0;height:16px;background:radial-gradient(circle,var(--cream-2) 8px,transparent 8.5px);background-size:26px 16px;background-repeat:repeat-x;}
  .pqrs-ticket::before{top:-8px;} .pqrs-ticket::after{bottom:-8px;}
  .pqrs-ticket-head{display:flex;justify-content:space-between;align-items:baseline;border-bottom:1px dashed var(--line-dark);padding-bottom:13px;margin-bottom:20px;}
  .pqrs-ticket-head span:first-child{font-family:'Plus Jakarta Sans',sans-serif;font-weight:800;font-size:12.5px;letter-spacing:1.5px;color:var(--green-bright);}
  .pqrs-ticket-head span:last-child{font-size:11px;color:var(--muted);}
  .pqrs-qr{position:relative;width:fit-content;margin:0 auto;padding:16px;background:var(--white);border-radius:16px;}
  .pqrs-qr img{width:200px;height:200px;display:block;border-radius:4px;}
  .pqrs-qr-pulse{position:absolute;inset:-2px;border-radius:16px;border:2px solid var(--green-bright);animation:pqrsPulse 2.6s ease-out infinite;pointer-events:none;}
  @keyframes pqrsPulse{0%{opacity:.9;transform:scale(1);}80%{opacity:0;transform:scale(1.06);}100%{opacity:0;}}
  .pqrs-ticket-note{margin-top:18px;text-align:center;font-size:12px;color:var(--muted);line-height:1.6;max-width:250px;margin-left:auto;margin-right:auto;}
  .pqrs-copy-btn{margin:16px auto 0;display:flex;align-items:center;justify-content:center;gap:8px;width:100%;padding:11px;border-radius:30px;background:rgba(255,255,255,0.07);border:1px solid var(--line-dark);color:var(--cream);font-size:12px;font-weight:700;transition:all .22s;}
  .pqrs-copy-btn svg{width:14px;height:14px;stroke:currentColor;fill:none;stroke-width:2;}
  .pqrs-copy-btn:hover,.pqrs-copy-btn.copied{background:var(--green-bright);border-color:var(--green-bright);color:var(--bg-deep);}
  .pqrs-tip{margin-top:18px;display:flex;align-items:center;gap:12px;background:var(--white);border-radius:16px;padding:14px 16px;box-shadow:0 24px 50px -28px rgba(20,43,34,0.3);}
  .pqrs-tip .ico{width:36px;height:36px;border-radius:50%;background:var(--amber);display:flex;align-items:center;justify-content:center;flex-shrink:0;}
  .pqrs-tip .ico svg{width:17px;height:17px;stroke:var(--ink);fill:none;stroke-width:2;}
  .pqrs-tip b{display:block;font-size:13px;font-weight:800;color:var(--ink);}
  .pqrs-tip span{font-size:11px;color:var(--ink-soft);}

  /* ===== TIPS ===== */
  .tips{background:var(--bg-deep);overflow:hidden;}
  .tips-grid{display:grid;grid-template-columns:.95fr 1.05fr;gap:70px;align-items:center;}
  .tips .tag{color:var(--green-bright);}
  .tips h2{font-size:40px;font-weight:500;margin-top:16px;line-height:1.16;letter-spacing:-.5px;color:var(--white);}
  .tips h2 b{font-weight:800;color:var(--amber);}
  .tips p.lead{margin-top:18px;color:var(--muted);font-size:15px;line-height:1.75;max-width:420px;}
  .tips-points{display:flex;flex-direction:column;gap:14px;margin-top:30px;}
  .tips-point{display:flex;align-items:center;gap:13px;}
  .tips-point .ico{width:36px;height:36px;border-radius:50%;background:rgba(255,255,255,0.06);border:1px solid var(--line-dark);display:flex;align-items:center;justify-content:center;flex-shrink:0;}
  .tips-point .ico svg{width:16px;height:16px;stroke:var(--green-bright);fill:none;stroke-width:2.2;}
  .tips-point b{display:block;font-size:13.5px;font-weight:700;color:var(--white);}
  .tips-point span{font-size:12px;color:var(--muted);}

  .tips-card{position:relative;background:var(--bg-deep-2);border:1px solid var(--line-dark);border-radius:28px;padding:30px 30px 32px;box-shadow:0 40px 80px -30px rgba(0,0,0,.5);}
  .tips-badge-row{display:flex;justify-content:space-between;align-items:center;margin-bottom:22px;}
  .tips-badge{display:inline-flex;align-items:center;gap:8px;background:linear-gradient(180deg,var(--green-bright),var(--green));color:var(--white);font-family:'Plus Jakarta Sans',sans-serif;font-weight:800;font-size:11px;letter-spacing:1px;text-transform:uppercase;padding:7px 13px;border-radius:30px;}
  .tips-badge svg{width:12px;height:12px;}
  .tips-badge-row .who{font-size:11px;color:var(--muted);font-weight:600;}
  .tips-team{margin-bottom:24px;}
  .tips-team h4{font-size:11.5px;font-weight:700;color:var(--muted);letter-spacing:.5px;text-transform:uppercase;margin-bottom:12px;}
  .tips-team h4 span{font-weight:500;text-transform:none;letter-spacing:0;opacity:.65;}
  .tips-team-row{display:flex;gap:12px;overflow-x:auto;padding:2px 2px 6px;}
  .tips-team-row::-webkit-scrollbar{height:4px;}
  .tips-team-row::-webkit-scrollbar-thumb{background:var(--line-dark);border-radius:6px;}
  .tips-emp{flex:0 0 auto;width:76px;display:flex;flex-direction:column;align-items:center;gap:6px;text-align:center;cursor:pointer;}
  .tips-emp .avatar{width:58px;height:58px;border-radius:50%;overflow:hidden;position:relative;border:2.5px solid transparent;transition:all .22s;background:rgba(255,255,255,.05);display:flex;align-items:center;justify-content:center;}
  .tips-emp .avatar img{width:100%;height:100%;object-fit:cover;}
  .tips-emp .avatar svg{width:22px;height:22px;stroke:var(--muted);fill:none;stroke-width:1.8;}
  .tips-emp.active .avatar{border-color:var(--amber);box-shadow:0 0 0 4px rgba(227,162,59,.16);}
  .tips-emp.active .avatar::after{content:'✓';position:absolute;bottom:-2px;right:-2px;width:18px;height:18px;background:var(--amber);color:var(--bg-deep);border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:10px;font-weight:800;border:2px solid var(--bg-deep-2);}
  .tips-emp b{font-size:10.5px;font-weight:700;color:var(--cream);line-height:1.25;}
  .tips-emp .role{font-size:9.5px;color:var(--muted);}

  .tips-mode{display:inline-flex;background:rgba(255,255,255,.05);border:1px solid var(--line-dark);border-radius:30px;padding:4px;margin-bottom:16px;}
  .tips-mode button{padding:8px 15px;border-radius:24px;font-size:12px;font-weight:700;color:var(--muted);transition:all .22s;}
  .tips-mode button.active{background:var(--green-bright);color:var(--bg-deep);}
  .tips-chips{display:flex;gap:8px;flex-wrap:wrap;}
  .tips-chip{padding:10px 14px;border-radius:12px;background:rgba(255,255,255,.05);border:1px solid var(--line-dark);color:var(--cream);font-size:13px;font-weight:700;font-family:'Plus Jakarta Sans',sans-serif;transition:all .2s;}
  .tips-chip:hover{border-color:var(--green-bright);}
  .tips-chip.active{background:var(--green-bright);color:var(--bg-deep);border-color:var(--green-bright);}
  .tips-custom{margin-top:12px;display:flex;align-items:center;gap:9px;}
  .tips-custom span{font-family:'Plus Jakarta Sans',sans-serif;font-weight:800;font-size:17px;color:var(--muted);}
  .tips-custom input[type="number"]{flex:1;background:rgba(255,255,255,.05);border:1px solid var(--line-dark);border-radius:12px;padding:12px 13px;font-family:'Plus Jakarta Sans',sans-serif;font-weight:800;font-size:17px;color:var(--cream);}
  .tips-custom input:focus{outline:2px solid var(--green-bright);outline-offset:1px;}
  .tips-slider{margin-top:16px;}
  .tips-slider input[type="range"]{-webkit-appearance:none;appearance:none;width:100%;height:5px;border-radius:6px;background:linear-gradient(90deg,var(--green-bright) var(--fill,30%),rgba(255,255,255,.12) var(--fill,30%));outline:none;}
  .tips-slider input[type="range"]::-webkit-slider-thumb{-webkit-appearance:none;width:20px;height:20px;border-radius:50%;background:var(--amber);border:3px solid var(--bg-deep-2);box-shadow:0 0 0 2px var(--amber);cursor:pointer;}
  .tips-main{display:grid;grid-template-columns:1fr auto;gap:24px;align-items:center;}
  .tips-message{margin-top:18px;font-size:13px;color:var(--cream);min-height:18px;font-weight:500;}
  .tips-message b{color:var(--amber);}
  .tips-jar-col{display:flex;flex-direction:column;align-items:center;gap:12px;}
  .jar-glass{position:relative;width:100px;height:136px;border:3px solid rgba(255,255,255,.18);border-top:none;border-radius:0 0 24px 24px;background:rgba(255,255,255,.03);overflow:hidden;}
  .jar-handle{position:absolute;top:-2px;left:50%;transform:translateX(-50%);width:60px;height:13px;border:3px solid rgba(255,255,255,.18);border-bottom:none;border-radius:13px 13px 0 0;}
  .jar-fill{position:absolute;left:0;right:0;bottom:0;height:30%;background:linear-gradient(180deg,var(--green-bright),var(--green) 80%);transition:height .5s cubic-bezier(.2,.8,.2,1);}
  .jar-fill::before{content:'';position:absolute;top:-5px;left:0;right:0;height:10px;background:repeating-linear-gradient(90deg,var(--green-bright) 0 9px,var(--green) 9px 18px);opacity:.7;}
  .jar-amount{font-family:'Plus Jakarta Sans',sans-serif;font-weight:800;font-size:15px;color:var(--white);}
  .jar-amount span{display:block;font-size:10px;font-weight:700;color:var(--muted);letter-spacing:1px;text-transform:uppercase;margin-top:2px;}
  .coin{position:absolute;font-size:14px;left:50%;bottom:30%;transform:translate(-50%,0);opacity:0;pointer-events:none;}
  .coin.drop{animation:coinDrop .9s ease-in forwards;}
  @keyframes coinDrop{0%{opacity:1;transform:translate(-50%,-80px) rotate(0deg);}85%{opacity:1;}100%{opacity:0;transform:translate(-50%,0) rotate(180deg);}}
  .tips-send-row{display:flex;align-items:center;gap:14px;margin-top:22px;}
  .tips-send-row .btn-fill{flex:1;justify-content:center;}
  .tips-confirm{display:none;margin-top:14px;font-size:12.5px;color:var(--green-bright);font-weight:700;}

  /* ===== FOOTER ===== */
  footer{background:#041a14;color:var(--cream);padding:80px 0 28px;}
  .foot-grid{display:grid;grid-template-columns:1.4fr 1fr 1fr 1.2fr;gap:44px;}
  .foot-logo{display:flex;align-items:center;gap:10px;font-weight:800;font-size:18px;font-family:'Plus Jakarta Sans',sans-serif;}
  footer p.foot-desc{margin-top:14px;color:var(--muted);font-size:13px;line-height:1.7;max-width:250px;}
  footer h4{font-size:12px;letter-spacing:1px;text-transform:uppercase;color:var(--green-bright);font-weight:700;margin-bottom:16px;}
  footer ul{list-style:none;display:flex;flex-direction:column;gap:10px;}
  footer ul a,footer ul span{font-size:13px;color:var(--muted);}
  footer ul a:hover{color:var(--cream);}
  .foot-social{display:flex;gap:10px;margin-top:18px;}
  .foot-social a{width:34px;height:34px;border-radius:50%;border:1px solid var(--line-dark);display:flex;align-items:center;justify-content:center;transition:background .2s,border-color .2s;}
  .foot-social a:hover{background:var(--green-bright);border-color:var(--green-bright);}
  .foot-social svg{width:14px;height:14px;stroke:currentColor;fill:none;stroke-width:1.8;}
  .foot-bottom{margin-top:56px;padding-top:22px;border-top:1px solid var(--line-dark);display:flex;justify-content:space-between;font-size:12px;color:var(--muted);flex-wrap:wrap;gap:8px;}

  /* ===== MOBILE MENU OVERLAY ===== */
  .mobile-nav{display:none;position:fixed;inset:0;z-index:800;background:var(--bg-deep);flex-direction:column;align-items:center;justify-content:center;gap:34px;}
  .mobile-nav.open{display:flex;}
  .mobile-nav a{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:24px;color:var(--white);opacity:.9;}
  .mobile-nav-close{position:absolute;top:24px;right:24px;width:44px;height:44px;display:flex;align-items:center;justify-content:center;border-radius:50%;border:1px solid var(--line-dark);color:var(--cream);}
  .mobile-nav-close svg{width:20px;height:20px;}

  /* ===== RESPONSIVE ===== */
  @media(max-width:1180px){
    .wrap{padding:0 28px;}
    .headline{font-size:48px;}
    .hero-grid{grid-template-columns:1fr;}
    .hero-visual{height:560px;margin-top:40px;}
    .panel{position:relative;right:0;width:100%;height:560px;border-radius:36px;}
    .slider-stage{width:100%;height:540px;}
    .slide img{height:380px;}
    .panel-label span{font-size:36px;}
    .strip{justify-content:center;}
    .about-grid{grid-template-columns:1fr;gap:50px;}
    .buffet-grid{grid-template-columns:1fr;gap:50px;}
    .clock-wrap{margin:0 auto;}
    .menu-grid{grid-template-columns:repeat(2,1fr);}
    .review-row{grid-template-columns:1fr 1fr;}
    .reserve-grid{grid-template-columns:1fr;}
    .gallery-grid{grid-template-columns:repeat(3,1fr);}
    .foot-grid{grid-template-columns:1fr 1fr;gap:34px;}
    .pqrs-grid{grid-template-columns:1fr;gap:50px;}
    .pqrs-ticket-wrap{position:static;max-width:380px;}
    .tips-grid{grid-template-columns:1fr;gap:50px;}
    .tips-main{grid-template-columns:1fr;}
    .tips-jar-col{flex-direction:row;justify-content:center;}
    .stats-grid{grid-template-columns:repeat(2,1fr);}
  }
  @media(max-width:640px){
    .nav-links{display:none;}
    .nav-mobile-btn{display:flex;}
    .headline{font-size:34px;}
    .hero{min-height:auto;padding-bottom:60px;}
    .strip-item{width:78px;height:94px;}
    .section-pad{padding:80px 0;}
    .about h2,.menu h2,.reserve h2,.tips h2{font-size:28px;}
    .buffet h2,.pqrs h2{font-size:26px;}
    .about-photo img{height:320px;}
    .buffet-card{padding:22px 20px;}
    .buffet-list{grid-template-columns:1fr;}
    .buffet-price{text-align:left;}
    .clock-photo{height:300px;}
    .clock-chip{left:0;}
    .clock-chip.top{right:0;}
    .menu-grid{grid-template-columns:1fr;}
    .review-row{grid-template-columns:1fr;}
    .gallery-grid{grid-template-columns:repeat(2,1fr);grid-auto-rows:110px;}
    .g1{grid-column:span 2;grid-row:span 1;}
    .field-row{grid-template-columns:1fr;}
    .foot-grid{grid-template-columns:1fr;}
    .reserve-form{padding:24px;}
    .pqrs-qr img{width:170px;height:170px;}
    .pqrs-ticket-wrap{max-width:100%;}
    .tips-card{padding:22px 20px;}
    .tips-chips{gap:7px;}
    .tips-chip{padding:9px 12px;font-size:12px;}
    .stat-num{font-size:30px;}
  }
  @media(prefers-reduced-motion:reduce){*{animation-duration:.001ms!important;transition-duration:.001ms!important;}}

  a:focus-visible,button:focus-visible{outline:2px solid var(--green-bright);outline-offset:3px;}
</style>
</head>
<body>
  <!-- ===== BOTÓN FLOTANTE VOLVER ARRIBA ===== -->
<style>
  #backToTop {
    position: fixed;
    bottom: 32px;
    right: 32px;
    z-index: 999;
    width: 52px;
    height: 52px;
    border-radius: 50%;
    background: linear-gradient(180deg, var(--green-bright), var(--green));
    border: none;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    visibility: hidden;
    transform: translateY(20px) scale(0.8);
    transition:
      opacity 0.4s cubic-bezier(0.34, 1.56, 0.64, 1),
      transform 0.4s cubic-bezier(0.34, 1.56, 0.64, 1),
      visibility 0.4s,
      box-shadow 0.2s;
    box-shadow: 0 8px 24px rgba(12, 107, 65, 0.4);
  }
  #backToTop.visible {
    opacity: 1;
    visibility: visible;
    transform: translateY(0) scale(1);
  }
  #backToTop:hover {
    transform: translateY(-4px) scale(1.08);
    box-shadow: 0 16px 36px rgba(12, 107, 65, 0.55);
  }
  #backToTop:active { transform: scale(0.93); }
  #backToTop:hover svg { transform: translateY(-2px); }
  #backToTop svg { pointer-events: none; transition: transform 0.2s; }
  #bttTooltip {
    position: fixed;
    bottom: 94px;
    right: 32px;
    z-index: 999;
    background: var(--ink);
    color: var(--white);
    font-size: 11px;
    font-weight: 700;
    padding: 6px 10px;
    border-radius: 8px;
    white-space: nowrap;
    pointer-events: none;
    opacity: 0;
    transform: translateY(4px);
    transition: opacity 0.2s, transform 0.2s;
  }
  #bttTooltip::after {
    content: '';
    position: absolute;
    bottom: -5px;
    right: 18px;
    border-left: 5px solid transparent;
    border-right: 5px solid transparent;
    border-top: 5px solid var(--ink);
  }
  #backToTop:hover + #bttTooltip { opacity: 1; transform: translateY(0); }
  @media (max-width: 640px) {
    #backToTop { bottom: 20px; right: 20px; width: 46px; height: 46px; }
    #bttTooltip { display: none; }
  }
</style>

<button id="backToTop" aria-label="Volver al inicio de la página">
  <svg width="22" height="22" viewBox="0 0 24 24" fill="none"
       stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
    <path d="M12 19V5M5 12l7-7 7 7"/>
  </svg>
</button>
<div id="bttTooltip" aria-hidden="true">Volver al inicio</div>

<script>
  (function() {
    const btn = document.getElementById('backToTop');
    const SHOW_AT = 300;
    let ticking = false;
    function updateBtn() {
      window.scrollY > SHOW_AT
        ? btn.classList.add('visible')
        : btn.classList.remove('visible');
      ticking = false;
    }
    window.addEventListener('scroll', () => {
      if (!ticking) { requestAnimationFrame(updateBtn); ticking = true; }
    }, { passive: true });
    btn.addEventListener('click', () => window.scrollTo({ top: 0, behavior: 'smooth' }));
  })();
</script>
<!-- ===== MOBILE NAV ===== -->
<nav class="mobile-nav" id="mobileNav" aria-label="Menú móvil">
  <button class="mobile-nav-close" id="mobileNavClose" aria-label="Cerrar menú">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 6l12 12M6 18L18 6"/></svg>
  </button>
  <a href="#inicio" onclick="closeMobileNav()">Inicio</a>
  <a href="#reserve" onclick="closeMobileNav()">Reservas</a>
  <a href="#buffet" onclick="closeMobileNav()">Bufet</a>
  <a href="#about" onclick="closeMobileNav()">Casa Fría</a>
  <a href="#menu" onclick="closeMobileNav()">Menú</a>
  <a href="#pqrs" onclick="closeMobileNav()">PQRS</a>
  <a href="#propinas" onclick="closeMobileNav()">Propinas</a>
</nav>

<!-- ===== HEADER ===== -->
<header id="siteHeader">
  <div class="wrap">
    <nav>
      <a href="#inicio" class="logo"><span class="logo-mark">PM</span>Pimienta Express</a>
      <ul class="nav-links">
        <li><a href="#reserve">Reservas</a></li>
        <li><a href="#buffet">Bufet</a></li>
        <li><a href="#about">Casa Fría</a></li>
        <li><a href="#menu">Menú</a></li>
        <li><a href="#pqrs">PQRS</a></li>
        <li><a href="#propinas">Propinas</a></li>
      </ul>
      <a href="#reserve" class="nav-cta" style="display:none;" id="navCtaDesktop">Reservar mesa</a>
      <button class="nav-mobile-btn" id="mobileMenuBtn" aria-label="Abrir menú">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18M3 12h18M3 18h18"/></svg>
      </button>
    </nav>
  </div>
</header>

<!-- ===== HERO ===== -->
<section class="hero" id="inicio">
  <div class="blob blob1"></div>
  <div class="blob blob2"></div>
  <div class="wrap">
    <div class="hero-grid">
      <div class="hero-copy">
        <div class="eyebrow">Pimienta Express es...</div>
        <h1 class="headline">Puro <b>Amor</b><br>En la hora del <b>Almuerzo</b></h1>
        <p class="sub">Granos seleccionados, recetas perfeccionadas y el ritual de cada día. Bowls frescos servidos en menos de 8 minutos, en el corazón de Medellín.</p>
        <div class="cta-row">
          <a href="#reserve" class="btn btn-fill">Reservar mesa</a>
          <a href="#menu" class="btn btn-outline">Ver el Menú</a>
        </div>
        <div class="strip" id="thumbStrip"></div>
      </div>
      <div class="hero-visual">
        <div class="panel"><div class="panel-label" id="panelLabel"></div></div>
        <img class="beans" src="https://static.vecteezy.com/system/resources/thumbnails/069/844/430/small/fresh-garden-vegetables-and-spice-arrangement-on-black-transparent-background-free-png.png" alt="">
        <div class="slider-stage" id="sliderStage"></div>
        <div class="caption"><div class="name" id="captionName">Bowl Especiales</div></div>
        <button class="like-btn" id="likeBtn" aria-label="Me gusta">
          <svg viewBox="0 0 24 24"><path d="M12 21s-7.5-4.8-10-9.6C.3 7.6 2.3 4 6 4c2.1 0 3.6 1.2 6 4 2.4-2.8 3.9-4 6-4 3.7 0 5.7 3.6 4 7.4C19.5 16.2 12 21 12 21z"/></svg>
        </button>
        <div class="slide-dots" id="sliderDots"></div>
        <div class="slider-controls">
          <div class="like-count">
            <svg viewBox="0 0 24 24"><path d="M7 11v9H4a1 1 0 0 1-1-1v-7a1 1 0 0 1 1-1h3zm0 0 4.6-8.2a1.5 1.5 0 0 1 2.6.1c.3.6.4 1.3.2 2L13 9h5.3A2.7 2.7 0 0 1 21 12.5l-1.6 6A2.7 2.7 0 0 1 16.8 20H10a3 3 0 0 1-3-3"/></svg>
            <span id="likeCount">135</span>
          </div>
          <div class="arrow-group">
            <button class="arrow-btn prev" id="prevBtn" aria-label="Anterior"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"><path d="M14 6l-6 6 6 6"/></svg></button>
            <button class="arrow-btn next" id="nextBtn" aria-label="Siguiente"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"><path d="M10 6l6 6-6 6"/></svg></button>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ===== MARQUEE ===== -->
<div class="marquee" aria-hidden="true">
  <div class="marquee-track" id="marqueeTrack"></div>
</div>

<!-- ===== STATS ===== -->
<section class="stats-bar">
  <div class="wrap">
    <div class="stats-grid">
      <div><div class="stat-num" data-target="340">0</div><div class="stat-label">Bowls servidos hoy</div></div>
      <div><div class="stat-num" data-target="92">0</div><div class="stat-label">% ingredientes locales</div></div>
      <div><div class="stat-num" data-target="8">0</div><div class="stat-label">Minutos de espera máximo</div></div>
      <div><div class="stat-num" data-target="35">0</div><div class="stat-label">Años en Medellín</div></div>
    </div>
  </div>
</section>

<!-- ===== RESERVE ===== -->
<section class="reserve section-pad" id="reserve">
  <div class="blob blob2" style="opacity:.18;"></div>
  <div class="wrap reserve-grid">
    <div>
      <span class="tag">Reserva tu mesa</span>
      <h2>Te guardamos un puesto <b>en la barra.</b></h2>
      <p class="lead">Sin filas. Sin esperas. Llega, siéntate y disfruta. Tu bowl te espera caliente.</p>
      <div class="reserve-info">
        <div><b>Envigado</b>Cra 70 # 44-12</div>
        <div><b>Ciudad del Río</b>Cl 9 # 37-22</div>
        <div><b>Horario</b>Lun – Sáb, 7am – 9pm</div>
      </div>
    </div>
    <form class="reserve-form" id="reserveForm">
      <h3>Reservar mesa</h3>
      <div class="field-row">
        <div class="field"><label for="rname">Nombre</label><input id="rname" type="text" placeholder="Tu nombre" required></div>
        <div class="field"><label for="rphone">Teléfono</label><input id="rphone" type="tel" placeholder="300 000 0000" required></div>
      </div>
      <div class="field-row">
        <div class="field"><label for="rdate">Fecha</label><input id="rdate" type="date" required></div>
        <div class="field"><label for="rpeople">Personas</label>
          <select id="rpeople"><option>1 persona</option><option selected>2 personas</option><option>3 personas</option><option>4+ personas</option></select>
        </div>
      </div>
      <div class="field" style="margin-top:12px;"><label for="rsede">Sede</label>
        <select id="rsede"><option>Envigado</option><option>Ciudad del Río</option></select>
      </div>
      <button class="btn btn-fill" type="submit" style="width:100%;justify-content:center;margin-top:18px;padding:14px;">Confirmar reserva</button>
      <p class="confirm-msg" id="reserveConfirm">¡Listo! Te escribimos por WhatsApp para confirmar.</p>
    </form>
  </div>
</section>

<!-- ===== BUFFET ===== -->
<section class="buffet section-pad" id="buffet">
  <div class="wrap buffet-grid">
    <div class="clock-wrap">
      <div class="clock-photo">
        <img id="buffetPhoto" src="https://images.unsplash.com/photo-1533089860892-a7c6f0a88666?q=80&w=900&auto=format&fit=crop" alt="Mesa de bufet">
      </div>
      <div class="clock-chip top">
        <div class="ico"><svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/></svg></div>
        <div><b id="chipHours">11:30am – 3:00pm</b><span>Lunes – Sabado</span></div>
      </div>
      <div class="clock-chip">
        <div class="ico"><svg viewBox="0 0 24 24"><path d="M5 13l4 4L19 7"/></svg></div>
        <div><b>Tiempo ilimitado</b><span>en barra, sin afán</span></div>
      </div>
    </div>
    <div>
      <span class="tag">Más que bowls</span>
      <h2>Bufet de almuerzo<br><b>y desayunos completos.</b></h2>
      <p class="lead">Cada día servimos una barra caliente con opciones que rotan según el mercado, además de desayunos preparados al momento desde temprano.</p>
      <div class="toggle" id="buffetToggle">
        <button class="active" data-key="almuerzo">Almuerzo Bufet</button>
        <button data-key="desayuno">Desayunos</button>
      </div>
      <div class="buffet-card" id="buffetCard"></div>
    </div>
  </div>
</section>

<!-- ===== ABOUT ===== -->
<section class="about section-pad" id="about">
  <div class="wrap about-grid">
    <div>
      <span class="tag">Casa Fría · Desde 2019</span>
      <h2>Cocinamos rápido, <b>nunca apurados.</b></h2>
      <p class="lead">Pimienta Express nació en una esquina de Laureles con una idea simple: el almuerzo del mediodía merece el mismo cuidado que una cena especial. Cada bowl se arma al momento, con vegetales de mercados locales y salsas hechas en casa.</p>
      <div class="ticket">
        <div class="ticket-head"><span>PEDIDO #0427</span><span>HOY · 12:14 PM</span></div>
        <div class="ticket-row"><span>Tiempo de espera</span><b>8 min</b></div>
        <div class="ticket-row"><span>Ingredientes locales</span><b>92%</b></div>
        <div class="ticket-row"><span>Bowls servidos hoy</span><b>340+</b></div>
        <div class="ticket-total"><span>Satisfacción</span><span>4.9 / 5 ★</span></div>
      </div>
    </div>
    <div class="about-photo">
      <img src="https://images.unsplash.com/photo-1543353071-873f17a7a088?q=80&w=900&auto=format&fit=crop" alt="Cocina abierta Pimienta Express">
      <div class="about-badge"><b>35</b>años sirviendo Medellín</div>
    </div>
  </div>
</section>

<!-- ===== MENU ===== -->
<section class="menu section-pad" id="menu">
  <div class="wrap">
    <div class="menu-head">
      <span class="tag">La Carta</span>
      <h2>Hecho para hoy, <b>pensado para ti.</b></h2>
    </div>
    <!-- <div class="menu-tabs" id="menuTabs"></div>
    <div class="menu-grid" id="menuGrid"></div> -->
  </div>
</section>

<!-- ===== GALLERY ===== -->
<section class="gallery section-pad" id="gallery">
  <div class="wrap">
    <div class="gallery-head">
      <div>
        <span class="tag">En la cocina</span>
        <h2>Cada plato, <b>una pequeña ceremonia.</b></h2>
      </div>
      <p>Fotos de nuestra barra de armado, tomadas por el equipo durante el servicio del mediodía.</p>
    </div>
    <div class="gallery-grid" id="galleryGrid"></div>
  </div>
</section>

<!-- ===== REVIEWS ===== -->
<section class="reviews section-pad" id="reviews">
  <div class="wrap">
    <span class="tag">Lo que dicen</span>
    <h2>Vecinos, oficinas <b>y curiosos de paso.</b></h2>
    <div class="review-row" id="reviewRow"></div>
  </div>
</section>

<!-- ===== TIPS / PROPINERO ===== -->
<section class="tips section-pad" id="propinas">
  <div class="wrap tips-grid">
    <div>
      <span class="tag">Agradecimiento directo al equipo</span>
      <h2>Conoce al <b>Propinero Virtual.</b></h2>
      <p class="lead">Tú decides cuánto, nosotros nos encargamos del resto. Lo que quieras dar, llega completo a quienes te atendieron.</p>
      <div class="tips-points">
        <div class="tips-point">
          <div class="ico"><svg viewBox="0 0 24 24"><path d="M5 13l4 4L19 7"/></svg></div>
          <div><b>100% para el equipo</b><span>Sin comisiones ni intermediarios</span></div>
        </div>
        <div class="tips-point">
          <div class="ico"><svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/></svg></div>
          <div><b>Listo en segundos</b><span>Desde tu celular, sin apps ni filas</span></div>
        </div>
        <div class="tips-point">
          <div class="ico"><svg viewBox="0 0 24 24"><path d="M3 7l9-4 9 4-9 4-9-4zm0 5l9 4 9-4M3 17l9 4 9-4"/></svg></div>
          <div><b>El monto lo eliges tú</b><span>Fijo, deslizante o por porcentaje</span></div>
        </div>
      </div>
    </div>
    <div class="tips-card">
      <div class="tips-badge-row">
        <span class="tips-badge"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="8"/><path d="M12 7v10M9 9.5a3 3 0 0 1 6 0c0 2-3 2-3 4.5"/></svg>Propinero Virtual</span>
        <span class="who">Pimienta Express · Laureles</span>
      </div>
      <div class="tips-team">
        <h4>¿Quién te atendió? <span>(opcional)</span></h4>
        <div class="tips-team-row" id="tipsTeamRow"></div>
      </div>
      <div class="tips-mode" id="tipsMode">
        <button class="active" data-mode="fijo">Monto fijo</button>
        <button data-mode="porcentaje">% de la cuenta</button>
      </div>
      <div class="tips-main">
        <div>
          <div id="tipsFixedPanel">
            <div class="tips-chips" id="tipsChips"></div>
            <div class="tips-custom">
              <span>$</span>
              <input type="number" id="tipsCustomInput" placeholder="Otro monto" min="0" step="500">
            </div>
            <div class="tips-slider">
              <input type="range" id="tipsSlider" min="0" max="50000" step="500" value="10000">
            </div>
          </div>
          <div id="tipsPercentPanel" style="display:none;">
            <div class="field">
              <label style="font-size:12px;color:var(--muted);font-weight:600;" for="tipsBill">Total de tu cuenta</label>
              <input type="number" id="tipsBill" placeholder="$ 0" min="0" step="1000" style="margin-top:6px;background:rgba(255,255,255,.05);border:1px solid var(--line-dark);border-radius:12px;padding:11px 13px;font-family:inherit;font-size:13.5px;color:var(--cream);width:100%;">
            </div>
            <div class="tips-chips" style="margin-top:12px;" id="tipsPercentChips"></div>
          </div>
          <p class="tips-message" id="tipsMsg"></p>
        </div>
        <div class="tips-jar-col">
          <div class="jar-glass">
            <div class="jar-handle"></div>
            <div class="jar-fill" id="jarFill"></div>
          </div>
          <div class="jar-amount" id="jarAmount">$10.000<span>propina</span></div>
        </div>
      </div>
      <div class="tips-send-row">
        <button class="btn btn-fill" id="tipsSend">Dar propina ahora</button>
      </div>
      <p class="tips-confirm" id="tipsConfirm"></p>
    </div>
  </div>
</section>

<!-- ===== PQRS ===== -->
<section class="pqrs section-pad" id="pqrs">
  <div class="wrap pqrs-grid">
    <div>
      <span class="tag">Buzón PQRS</span>
      <h2>Tu opinión <b>también nos sazona.</b></h2>
      <p class="lead">Petición, queja, reclamo o sugerencia — escanea el código desde tu mesa y llega directo a la cocina, o escríbenos aquí mismo.</p>
      <div class="pqrs-types" id="pqrsTypes"></div>
      <div class="pqrs-quick">
        <h4>O CUÉNTANOS DIRECTO</h4>
        <form id="pqrsForm">
          <div class="field">
            <label for="pqMsg">Tu mensaje</label>
            <textarea id="pqMsg" placeholder="Cuéntanos qué pasó o qué se te ocurre..." required></textarea>
          </div>
          <div class="field-row">
            <div class="field"><label for="pqName">Nombre (opcional)</label><input id="pqName" type="text" placeholder="Tu nombre"></div>
            <div class="field"><label for="pqSede">Mesa / Sede</label><input id="pqSede" type="text" placeholder="Ej. Envigado, mesa 4"></div>
          </div>
          <button class="btn btn-fill" type="submit" style="width:100%;justify-content:center;margin-top:14px;padding:13px;">Enviar al instante</button>
          <p class="confirm-msg" id="pqrsConfirm">¡Recibido! Gracias por ayudarnos a mejorar.</p>
        </form>
      </div>
    </div>
    <div class="pqrs-ticket-wrap">
      <div class="pqrs-ticket">
        <div class="pqrs-ticket-head"><span>ESCANEA AQUÍ</span><span id="pqrsCode">PQRS · MEDELLÍN</span></div>
        <div class="pqrs-qr">
          <img id="pqrsQR" src="" alt="Código QR PQRS Pimienta Express">
          <div class="pqrs-qr-pulse" aria-hidden="true"></div>
        </div>
        <p class="pqrs-ticket-note">Apunta tu cámara y listo: te lleva directo al formulario PQRS de tu sede.</p>
        <button class="pqrs-copy-btn" id="pqrsCopyBtn" type="button">
          <svg viewBox="0 0 24 24"><rect x="9" y="9" width="11" height="11" rx="2"/><path d="M5 15V5a2 2 0 0 1 2-2h10"/></svg>
          <span id="pqrsCopyLabel">Copiar enlace</span>
        </button>
      </div>
      <div class="pqrs-tip">
        <div class="ico"><svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/></svg></div>
        <div><b>Respuesta en 24h</b><span>Te contactamos por WhatsApp o correo</span></div>
      </div>
    </div>
  </div>
</section>

<!-- ===== FOOTER ===== -->
<footer>
  <div class="wrap">
    <div class="foot-grid">
      <div>
        <div class="foot-logo"><span class="logo-mark">PM</span>Pimienta Express</div>
        <p class="foot-desc">Bowls frescos, café de especialidad y el ritual del almuerzo, hecho como debe ser. Todos los días en Medellín.</p>
        <div class="foot-social">
          <a href="#" aria-label="Instagram"><svg viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.2" cy="6.8" r="1" fill="currentColor"/></svg></a>
          <a href="#" aria-label="WhatsApp"><svg viewBox="0 0 24 24"><path d="M21 11.5a8.5 8.5 0 0 1-12.4 7.6L3 20l1-5.4A8.5 8.5 0 1 1 21 11.5z"/></svg></a>
          <a href="#" aria-label="Facebook"><svg viewBox="0 0 24 24"><path d="M15 7h2V4h-2a4 4 0 0 0-4 4v2H9v3h2v7h3v-7h2.2l.8-3H14V8a1 1 0 0 1 1-1z"/></svg></a>
          <a href="#" aria-label="TikTok"><svg viewBox="0 0 24 24"><path d="M9 12a4 4 0 1 0 4 4V4a5 5 0 0 0 5 5"/></svg></a>
        </div>
      </div>
      <div>
        <h4>Explorar</h4>
        <ul>
          <li><a href="#about">Casa Fría</a></li>
          <li><a href="#menu">Menú</a></li>
          <li><a href="#gallery">Galería</a></li>
          <li><a href="#reserve">Reservas</a></li>
          <li><a href="#pqrs">PQRS</a></li>
          <li><a href="#propinas">Propinas</a></li>
        </ul>
      </div>
      <div>
        <h4>Sedes</h4>
        <ul>
          <li><span>Envigado — Cra 70 # 44-12</span></li>
          <li><span>Ciudad del Río — Cl 9 # 37-22</span></li>
          <li><span>Lun – Sáb · 7am – 9pm</span></li>
          <li><span>Dom · 10am – 4pm</span></li>
        </ul>
      </div>
      <div>
        <h4>Newsletter</h4>
        <ul><li><span>Recibe el menú de la semana y promos de mediodía.</span></li></ul>
        <div class="field" style="margin-top:10px;gap:8px;">
          <input type="email" placeholder="tu@correo.com" style="border:1px solid var(--line-dark);border-radius:10px;padding:11px 13px;font-size:13px;background:rgba(255,255,255,.05);color:var(--cream);width:100%;">
          <button class="btn btn-fill btn-sm" style="margin-top:8px;width:100%;justify-content:center;">Suscribirme</button>
        </div>
      </div>
    </div>
    <div class="foot-bottom">
      <span>© 2026 Pimienta Express. Todos los derechos reservados.</span>
      <span>Hecho con cariño en Medellín, Colombia 🇨🇴</span>
    </div>
  </div>
</footer>

<script>


/* ===== NAV SCROLL ===== */
const siteHeader = document.getElementById('siteHeader');
const navCtaDesktop = document.getElementById('navCtaDesktop');
window.addEventListener('scroll',()=>{
  if(window.scrollY>60){
    siteHeader.classList.add('scrolled');
    navCtaDesktop.style.display='inline-flex';
  } else {
    siteHeader.classList.remove('scrolled');
    navCtaDesktop.style.display='none';
  }
});

/* ===== MOBILE MENU ===== */
document.getElementById('mobileMenuBtn').addEventListener('click',()=>{
  document.getElementById('mobileNav').classList.add('open');
  document.body.style.overflow='hidden';
});
document.getElementById('mobileNavClose').addEventListener('click', closeMobileNav);
function closeMobileNav(){
  document.getElementById('mobileNav').classList.remove('open');
  document.body.style.overflow='';
}

/* ===== DATA ===== */
const products=[
  {name:"Bowl Especiales",label:"BOWL ESPECIALES",img:"https://png.pngtree.com/png-vector/20240730/ourmid/pngtree-grilled-chicken-breast-fillet-and-fresh-vegetable-salad-healthy-lunch-menu-png-image_13304742.png"},
  {name:"Especial con Pollo",label:"CON POLLO",img:"https://png.pngtree.com/png-vector/20250416/ourmid/pngtree-healthy-food-plate-with-fruits-and-vegetables-png-image_16010934.png"},
  {name:"Mejor Ensalada",label:"ENSALADA",img:"https://png.pngtree.com/png-vector/20250512/ourmid/pngtree-fresh-salad-with-flying-vegetables-and-herbs-in-a-black-bowl-png-image_16192457.png"},
  {name:"Menú del Día",label:"MENÚ DEL DÍA",img:"https://lanashealthy.com/wp-content/uploads/2025/10/Mediterranean-Power-Bowl_def.png"},
  {name:"Arroz de la Casa",label:"ARROZ DE CASA",img:"https://static.vecteezy.com/system/resources/thumbnails/070/913/434/small/delicious-and-appetising-vegetable-rice-bowl-a-wholesome-and-vibrant-meal-perfect-for-a-light-lunch-or-dinner-free-png.png"}
];

const menuItems=[
  {cat:"Bowls",name:"Bowl Pimienta Verde",price:"$32.000",desc:"Quinoa, pollo a la plancha, aguacate y vinagreta de cilantro.",spice:"Suave",img:"https://images.unsplash.com/photo-1512621776951-a57141f2eefd?q=80&w=600&auto=format&fit=crop"},
  {cat:"Bowls",name:"Bowl Tropical",price:"$29.000",desc:"Arroz jazmín, mango, camarones salteados y salsa de coco.",spice:"Media",img:"https://images.unsplash.com/photo-1546069901-ba9599a7e63c?q=80&w=600&auto=format&fit=crop"},
  {cat:"Bowls",name:"Bowl Andino",price:"$27.000",desc:"Frijol cargamanto, maíz tierno, chicharrón y suero costeño.",spice:"Picante",img:"https://images.unsplash.com/photo-1543339308-43e59d6b73a6?q=80&w=600&auto=format&fit=crop"},
  {cat:"Plato Fuerte",name:"Pollo a la Pimienta",price:"$38.000",desc:"Pechuga marinada 24h, puré de papa criolla y vegetales asados.",spice:"Media",img:"https://images.unsplash.com/photo-1532550907401-a500c9a57435?q=80&w=600&auto=format&fit=crop"},
  {cat:"Plato Fuerte",name:"Salmón Express",price:"$45.000",desc:"Salmón a la plancha, arroz de coco y ensalada de pepino.",spice:"Suave",img:"https://images.unsplash.com/photo-1467003909585-2f8a72700288?q=80&w=600&auto=format&fit=crop"},
  {cat:"Plato Fuerte",name:"Lomo en Salsa Criolla",price:"$36.000",desc:"Lomo de res, salsa criolla casera y patacones.",spice:"Picante",img:"https://images.unsplash.com/photo-1432139509613-5c4255815697?q=80&w=600&auto=format&fit=crop"},
  {cat:"Bebidas",name:"Limonada de Hierbabuena",price:"$9.000",desc:"Limón recién exprimido, hierbabuena y un toque de panela.",spice:"—",img:"https://images.unsplash.com/photo-1556679343-c7306c1976bc?q=80&w=600&auto=format&fit=crop"},
  {cat:"Bebidas",name:"Café de Casa Fría",price:"$7.500",desc:"Café de origen Huila, tueste medio, método filtrado.",spice:"—",img:"https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?q=80&w=600&auto=format&fit=crop"},
  {cat:"Bebidas",name:"Jugo Verde Express",price:"$10.000",desc:"Espinaca, piña, jengibre y manzana verde.",spice:"—",img:"https://images.unsplash.com/photo-1622597467836-f3285f2131b8?q=80&w=600&auto=format&fit=crop"},
  {cat:"Postres",name:"Tres Leches de la Casa",price:"$12.000",desc:"Receta de la abuela, con un toque de canela.",spice:"—",img:"https://images.unsplash.com/photo-1551024506-0bccd828d307?q=80&w=600&auto=format&fit=crop"},
  {cat:"Postres",name:"Brownie Pimienta Negra",price:"$11.000",desc:"Chocolate 70%, nuez y una pizca de pimienta negra molida.",spice:"Suave",img:"https://images.unsplash.com/photo-1606313564200-e75d5e30476c?q=80&w=600&auto=format&fit=crop"},
  {cat:"Postres",name:"Mousse de Maracuyá",price:"$10.500",desc:"Maracuyá fresco, suave y ligeramente ácido.",spice:"—",img:"https://images.unsplash.com/photo-1488477181946-6428a0291777?q=80&w=600&auto=format&fit=crop"}
];

const gallery=[
  "https://images.unsplash.com/photo-1414235077428-338989a2e8c0?q=80&w=900&auto=format&fit=crop",
  "https://images.unsplash.com/photo-1424847651672-bf20a4b0982b?q=80&w=600&auto=format&fit=crop",
  "https://images.unsplash.com/photo-1504674900247-0877df9cc836?q=80&w=600&auto=format&fit=crop",
  "https://images.unsplash.com/photo-1567620905732-2d1ec7ab7445?q=80&w=600&auto=format&fit=crop",
  "https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?q=80&w=600&auto=format&fit=crop",
  "https://images.unsplash.com/photo-1466637574441-749b8f19452f?q=80&w=600&auto=format&fit=crop",
  "https://images.unsplash.com/photo-1490645935967-10de6ba17061?q=80&w=900&auto=format&fit=crop"
];

const reviews=[
  {name:"Camila R.",role:"Vecina de Laureles",text:"Voy casi todos los días al almuerzo. El bowl andino se volvió mi pausa favorita del mediodía.",img:"https://images.unsplash.com/photo-1494790108377-be9c29b29330?q=80&w=200&auto=format&fit=crop"},
  {name:"Andrés M.",role:"Equipo de trabajo cercano",text:"Pedimos para toda la oficina dos veces por semana. Siempre llega caliente y a tiempo.",img:"https://images.unsplash.com/photo-1500648767791-00dcc994a43e?q=80&w=200&auto=format&fit=crop"},
  {name:"Laura V.",role:"Visitante de paso",text:"Entré sin conocer el lugar y salí pidiendo la receta del aderezo de cilantro. Volveré seguro.",img:"https://images.unsplash.com/photo-1517841905240-472988babdf9?q=80&w=200&auto=format&fit=crop"}
];

/* ===== HERO SLIDER ===== */
const stage=document.getElementById('sliderStage');
const dotsWrap=document.getElementById('sliderDots');
const stripWrap=document.getElementById('thumbStrip');
const panelLabel=document.getElementById('panelLabel');
const captionName=document.getElementById('captionName');
const likeCountEl=document.getElementById('likeCount');
let current=0,likeBase=135,autoTimer=null;

function buildSlides(){
  products.forEach((p,i)=>{
    const slide=document.createElement('div');
    slide.className='slide'+(i===0?' active':'');
    const img=document.createElement('img');img.src=p.img;img.alt=p.name;img.loading='lazy';
    slide.appendChild(img);stage.appendChild(slide);

    const dot=document.createElement('button');
    dot.className=i===0?'active':'';dot.setAttribute('aria-label','Ver '+p.name);
    dot.addEventListener('click',()=>goTo(i));dotsWrap.appendChild(dot);

    const thumb=document.createElement('div');
    thumb.className='strip-item'+(i===0?' active':'');
    thumb.tabIndex=0;thumb.setAttribute('role','button');thumb.setAttribute('aria-label',p.name);
    const tImg=document.createElement('img');tImg.src=p.img;tImg.alt=p.name;tImg.loading='lazy';
    thumb.appendChild(tImg);
    thumb.addEventListener('click',()=>goTo(i));
    thumb.addEventListener('keydown',(e)=>{if(e.key==='Enter')goTo(i);});
    stripWrap.appendChild(thumb);

    const labelSpan=document.createElement('span');
    labelSpan.textContent=p.label;
    labelSpan.className=i===0?'':'ghost';
    panelLabel.appendChild(labelSpan);
  });
}

function goTo(i){
  if(i===current){restartAuto();return;}
  current=(i+products.length)%products.length;
  document.querySelectorAll('.slide').forEach((s,idx)=>s.classList.toggle('active',idx===current));
  document.querySelectorAll('.slide-dots button').forEach((d,idx)=>d.classList.toggle('active',idx===current));
  document.querySelectorAll('.strip-item').forEach((t,idx)=>t.classList.toggle('active',idx===current));
  document.querySelectorAll('.panel-label span').forEach((l,idx)=>l.classList.toggle('ghost',idx!==current));
  captionName.textContent=products[current].name;
  likeBase=110+Math.floor(Math.random()*60);
  likeCountEl.textContent=likeBase;
  restartAuto();
}
function next(){goTo(current+1);}
function prev(){goTo(current-1);}
function restartAuto(){clearInterval(autoTimer);autoTimer=setInterval(next,5000);}

document.getElementById('nextBtn').addEventListener('click',next);
document.getElementById('prevBtn').addEventListener('click',prev);
document.getElementById('likeBtn').addEventListener('click',()=>{likeBase+=1;likeCountEl.textContent=likeBase;});

buildSlides();restartAuto();

/* ===== MARQUEE ===== */
const words=["FRESCO","RÁPIDO","LOCAL","PICANTE A TU GUSTO","5 MIN DE ESPERA","HECHO HOY","SABOR CASERO","ALMUERZO PERFECTO","BOWLS PARA TODOS","RECETAS DE LA ABUELA"];
const track=document.getElementById('marqueeTrack');
for(let r=0;r<2;r++){words.forEach(w=>{const s=document.createElement('span');s.textContent=w;track.appendChild(s);});}

/* ===== STATS COUNTER ===== */
function animateCounter(el,target,suffix){
  let start=null;const dur=1800;
  function step(ts){
    if(!start)start=ts;
    const p=Math.min((ts-start)/dur,1);
    const val=Math.floor(p*target);
    el.textContent=val+(suffix||'');
    if(p<1)requestAnimationFrame(step);
    else el.textContent=target+(suffix||'');
  }
  requestAnimationFrame(step);
}
const statsObs=new IntersectionObserver((entries)=>{
  entries.forEach(e=>{
    if(e.isIntersecting){
      document.querySelectorAll('[data-target]').forEach(el=>{
        const t=parseInt(el.dataset.target);
        const suffix=el.parentElement.querySelector('.stat-label').textContent.includes('min')?'':
                     el.parentElement.querySelector('.stat-label').textContent.includes('%')?'%':
                     el.parentElement.querySelector('.stat-label').textContent.includes('Años')?'':'';
        animateCounter(el,t,suffix);
        el.removeAttribute('data-target');
      });
      statsObs.disconnect();
    }
  });
},{threshold:.4});
const statsSection=document.querySelector('.stats-bar');
if(statsSection)statsObs.observe(statsSection);

/* ===== BUFFET ===== */
const buffetData={
  almuerzo:{title:"Almuerzo Bufet del Día Desde",hours:"Lunes a sábado · 11:30am – 3:00pm",price:"$23.900",unit:"por persona, barra libre",photo:"https://images.unsplash.com/photo-1414235077428-338989a2e8c0?q=80&w=900&auto=format&fit=crop",chipHours:"11:30am – 3:00pm",items:["Sopa o crema del día","Proteína: pollo, carne o chicharrón","3 acompañantes a elegir","Variedad de ensaladas frescas","Arroz y patacón","Jugo natural del día","Postre de la casa","Café incluido"]},
  desayuno:{title:"Desayunos Gourmet Desde",hours:"Todos los días · 7:00am – 10:30am",price:"$9.800",unit:"por persona, servido en mesa",photo:"https://images.unsplash.com/photo-1533089860892-a7c6f0a88666?q=80&w=900&auto=format&fit=crop",chipHours:"7:00am – 11:00am",items:["Huevos al gusto","Arepa o calentado","Fruta picada del día","Chocolate, café o té","Jugo natural","Pan recién horneado","Queso campesino","Mermelada artesanal"]}
};
const buffetCard=document.getElementById('buffetCard');
const buffetPhoto=document.getElementById('buffetPhoto');
const chipHours=document.getElementById('chipHours');
const checkIcon='<svg viewBox="0 0 24 24"><path d="M5 13l4 4L19 7"/></svg>';

function renderBuffet(key){
  const d=buffetData[key];
  buffetCard.innerHTML=`
    <div class="buffet-card-head">
      <div><h3>${d.title}</h3><div class="hours">${d.hours}</div></div>
      <div class="buffet-price"><b>${d.price}</b><span>${d.unit}</span></div>
    </div>
    <ul class="buffet-list">${d.items.map(it=>`<li>${checkIcon}${it}</li>`).join('')}</ul>
    <button class="btn btn-fill btn-sm" style="margin-top:22px;">Conoce nuestros productos</button>`;
  buffetPhoto.src=d.photo;chipHours.textContent=d.chipHours;
}
document.querySelectorAll('#buffetToggle button').forEach(btn=>{
  btn.addEventListener('click',()=>{
    document.querySelectorAll('#buffetToggle button').forEach(b=>b.classList.remove('active'));
    btn.classList.add('active');renderBuffet(btn.dataset.key);
  });
});
renderBuffet('almuerzo');

/* ===== MENU ===== */
// const cats=["Todos","Bowls","Plato Fuerte","Bebidas","Postres"];
// const tabsWrap=document.getElementById('menuTabs');
// const grid=document.getElementById('menuGrid');

// function renderMenu(cat){
//   grid.innerHTML='';
//   const items=cat==="Todos"?menuItems:menuItems.filter(m=>m.cat===cat);
//   items.forEach(m=>{
//     const card=document.createElement('div');card.className='menu-card';
//     card.innerHTML=`
//       <div class="pic"><img src="${m.img}" alt="${m.name}" loading="lazy"></div>
//       ${m.spice!=="—"?`<span class="spice">${m.spice}</span>`:''}
//       <div class="body">
//         <div class="row"><h3>${m.name}</h3><span class="price">${m.price}</span></div>
//         <p>${m.desc}</p>
//         <button class="add-btn">Agregar al pedido +</button>
//       </div>`;
//     grid.appendChild(card);
//   });
// }
// cats.forEach((c,i)=>{
//   const btn=document.createElement('button');
//   btn.className='menu-tab'+(i===0?' active':'');btn.textContent=c;
//   btn.addEventListener('click',()=>{
//     document.querySelectorAll('.menu-tab').forEach(t=>t.classList.remove('active'));
//     btn.classList.add('active');renderMenu(c);
//   });
//   tabsWrap.appendChild(btn);
// });
// renderMenu("Todos");

/* ===== GALLERY ===== */
const galleryGrid=document.getElementById('galleryGrid');
const gClasses=['g1','g2','g3','g4','g5','g6','g7'];
gallery.forEach((src,i)=>{
  const a=document.createElement('a');a.href='#';a.className=gClasses[i]||'';
  a.addEventListener('click',e=>e.preventDefault());
  const img=document.createElement('img');img.src=src;img.alt='Pimienta Express';img.loading='lazy';
  a.appendChild(img);galleryGrid.appendChild(a);
});

/* ===== REVIEWS ===== */
const reviewRow=document.getElementById('reviewRow');
reviews.forEach(r=>{
  const card=document.createElement('div');card.className='review-card';
  card.innerHTML=`<div class="stars">★★★★★</div><p>"${r.text}"</p><div class="reviewer"><img src="${r.img}" alt="${r.name}"><div class="who"><b>${r.name}</b><span>${r.role}</span></div></div>`;
  reviewRow.appendChild(card);
});

/* ===== FORMS ===== */
document.getElementById('reserveForm').addEventListener('submit',e=>{
  e.preventDefault();
  const c=document.getElementById('reserveConfirm');
  c.style.display='block';
  setTimeout(()=>c.style.display='none',4000);
});
document.getElementById('pqrsForm').addEventListener('submit',e=>{
  e.preventDefault();
  const c=document.getElementById('pqrsConfirm');
  c.style.display='block';
  setTimeout(()=>c.style.display='none',4000);
});

/* ===== PQRS QR ===== */
const PQRS_URL="https://wa.me/573000000000?text=Hola%2C%20quiero%20radicar%20una%20PQRS%20en%20Pimienta%20Express";
const pqrsTypes=[
  {key:"peticion",label:"Petición",color:"var(--green-bright)"},
  {key:"queja",label:"Queja",color:"#c1483f"},
  {key:"reclamo",label:"Reclamo",color:"var(--amber-deep)"},
  {key:"sugerencia",label:"Sugerencia",color:"var(--amber)"}
];
const pqrsTypesWrap=document.getElementById('pqrsTypes');
const pqrsQR=document.getElementById('pqrsQR');
const pqrsCopyBtn=document.getElementById('pqrsCopyBtn');
const pqrsCopyLabel=document.getElementById('pqrsCopyLabel');
let pqrsActiveType=null;

function pqrsUrl(){return pqrsActiveType?`${PQRS_URL}&tipo=${pqrsActiveType}`:PQRS_URL;}
function pqrsRenderQR(){
  pqrsQR.src=`https://api.qrserver.com/v1/create-qr-code/?size=260x260&margin=8&color=06241C&bgcolor=FFFFFF&data=${encodeURIComponent(pqrsUrl())}`;
}
pqrsTypes.forEach(t=>{
  const pill=document.createElement('button');pill.type='button';pill.className='pqrs-type';pill.dataset.key=t.key;
  pill.innerHTML=`<span class="dot" style="background:${t.color}"></span>${t.label}`;
  pill.addEventListener('click',()=>{
    const isActive=pill.classList.contains('active');
    document.querySelectorAll('.pqrs-type').forEach(p=>p.classList.remove('active'));
    pqrsActiveType=isActive?null:t.key;
    if(!isActive)pill.classList.add('active');
    pqrsRenderQR();
  });
  pqrsTypesWrap.appendChild(pill);
});
pqrsRenderQR();
pqrsCopyBtn.addEventListener('click',async()=>{
  const url=pqrsUrl();
  try{await navigator.clipboard.writeText(url);}catch(e){const t=document.createElement('input');t.value=url;document.body.appendChild(t);t.select();document.execCommand('copy');document.body.removeChild(t);}
  pqrsCopyBtn.classList.add('copied');pqrsCopyLabel.textContent='¡Enlace copiado!';
  setTimeout(()=>{pqrsCopyBtn.classList.remove('copied');pqrsCopyLabel.textContent='Copiar enlace';},2000);
});

/* ===== TIPS ===== */
const tipsEmployees=[
  {id:"camila",name:"Camila",role:"Mesera",votes:18,photo:"https://images.unsplash.com/photo-1531123897727-8f129e1688ce?q=80&w=300&auto=format&fit=crop"},
  {id:"andres",name:"Andrés",role:"Barista",votes:14,photo:"https://images.unsplash.com/photo-1633332755192-727a05c4013d?q=80&w=300&auto=format&fit=crop"},
  {id:"mariana",name:"Mariana",role:"Chef",votes:21,photo:"https://images.unsplash.com/photo-1607990281513-2c110a25bd8c?q=80&w=300&auto=format&fit=crop"},
  {id:"julian",name:"Julián",role:"Mesero",votes:9,photo:"https://images.unsplash.com/photo-1500648767791-00dcc994a43e?q=80&w=300&auto=format&fit=crop"}
];
const tipsTeamRow=document.getElementById('tipsTeamRow');
let tipsSelectedEmployee='equipo';

function tipsRenderTeam(){
  tipsTeamRow.innerHTML='';
  const allCard=document.createElement('button');allCard.type='button';allCard.className='tips-emp active';allCard.dataset.id='equipo';
  allCard.innerHTML=`<div class="avatar"><svg viewBox="0 0 24 24"><circle cx="9" cy="8" r="3"/><circle cx="17" cy="9" r="2.4"/><path d="M3 20c0-3 2.7-5 6-5s6 2 6 5M14 15.2c2.6.3 4.5 2 4.5 4.3"/></svg></div><b>Todos</b><span class="role">Repartir</span>`;
  allCard.addEventListener('click',()=>tipsSelectEmployee('equipo'));tipsTeamRow.appendChild(allCard);
  tipsEmployees.forEach(emp=>{
    const card=document.createElement('button');card.type='button';card.className='tips-emp';card.dataset.id=emp.id;
    card.innerHTML=`<div class="avatar"><img src="${emp.photo}" alt="${emp.name}" loading="lazy"></div><b>${emp.name}</b><span class="role">${emp.role}</span>`;
    card.addEventListener('click',()=>tipsSelectEmployee(emp.id));tipsTeamRow.appendChild(card);
  });
}
function tipsSelectEmployee(id){
  tipsSelectedEmployee=id;
  document.querySelectorAll('.tips-emp').forEach(c=>c.classList.toggle('active',c.dataset.id===id));
}
tipsRenderTeam();

const fmtCOP=n=>'$'+Math.round(n).toLocaleString('es-CO');
const tipsFixedAmounts=[2000,5000,10000,20000];
const tipsPercentOptions=[10,15,20,25];
const TIPS_JAR_MAX=50000;
const tipsChipsWrap=document.getElementById('tipsChips');
const tipsPercentChipsWrap=document.getElementById('tipsPercentChips');
const tipsCustomInput=document.getElementById('tipsCustomInput');
const tipsSlider=document.getElementById('tipsSlider');
const tipsBillInput=document.getElementById('tipsBill');
const tipsMsg=document.getElementById('tipsMsg');
const jarFill=document.getElementById('jarFill');
const jarAmount=document.getElementById('jarAmount');
const tipsFixedPanel=document.getElementById('tipsFixedPanel');
const tipsPercentPanel=document.getElementById('tipsPercentPanel');
const tipsSend=document.getElementById('tipsSend');
const tipsConfirm=document.getElementById('tipsConfirm');
const jarGlass=document.querySelector('.jar-glass');
let tipsModeState='fijo',tipsAmount=10000,tipsPercent=15;

tipsFixedAmounts.forEach(amt=>{
  const chip=document.createElement('button');chip.type='button';chip.className='tips-chip';chip.textContent=fmtCOP(amt);chip.dataset.amt=amt;
  chip.addEventListener('click',()=>{tipsCustomInput.value='';setTipsAmount(amt,true);});
  tipsChipsWrap.appendChild(chip);
});
tipsPercentOptions.forEach(p=>{
  const chip=document.createElement('button');chip.type='button';chip.className='tips-chip';chip.textContent=p+'%';chip.dataset.p=p;
  chip.addEventListener('click',()=>{tipsPercent=p;document.querySelectorAll('#tipsPercentChips .tips-chip').forEach(c=>c.classList.toggle('active',Number(c.dataset.p)===p));recalcPercent();});
  tipsPercentChipsWrap.appendChild(chip);
});

function syncFixedChips(amt){document.querySelectorAll('#tipsChips .tips-chip').forEach(c=>c.classList.toggle('active',Number(c.dataset.amt)===amt));}
function tipsMsgFor(amt){if(amt<=0)return'Desliza o toca un monto para empezar.';if(amt<5000)return'Cada granito cuenta. ¡Gracias!';if(amt<15000)return'<b>Generoso/a.</b> El equipo lo va a sentir.';if(amt<30000)return'<b>Wow.</b> Eso alegra el turno completo.';return'<b>Leyenda total.</b> Te vamos a recordar. 💚';}

function spawnCoins(){
  const count=3+Math.floor(Math.random()*2);
  for(let i=0;i<count;i++){
    setTimeout(()=>{
      const coin=document.createElement('div');coin.className='coin drop';coin.textContent='🪙';
      coin.style.left=(40+Math.random()*20)+'%';
      jarGlass.appendChild(coin);setTimeout(()=>coin.remove(),950);
    },i*110);
  }
}
function setTipsAmount(amt,animate){
  tipsAmount=Math.max(0,amt);syncFixedChips(tipsAmount);
  tipsSlider.value=Math.min(tipsAmount,TIPS_JAR_MAX);renderJar(animate);
}
function recalcPercent(){const bill=Number(tipsBillInput.value)||0;tipsAmount=Math.round(bill*tipsPercent/100);renderJar(true);}
function renderJar(animate){
  const pct=Math.min(100,(tipsAmount/TIPS_JAR_MAX)*100);
  jarFill.style.height=pct+'%';jarAmount.innerHTML=fmtCOP(tipsAmount)+'<span>propina</span>';
  tipsMsg.innerHTML=tipsMsgFor(tipsAmount);if(animate&&tipsAmount>0)spawnCoins();
}
tipsCustomInput.addEventListener('input',()=>{document.querySelectorAll('#tipsChips .tips-chip').forEach(c=>c.classList.remove('active'));setTipsAmount(Number(tipsCustomInput.value)||0,false);});
tipsSlider.addEventListener('input',()=>{tipsCustomInput.value='';setTipsAmount(Number(tipsSlider.value),false);});
tipsSlider.addEventListener('change',()=>spawnCoins());
tipsBillInput.addEventListener('input',recalcPercent);
document.querySelectorAll('#tipsMode button').forEach(btn=>{
  btn.addEventListener('click',()=>{
    document.querySelectorAll('#tipsMode button').forEach(b=>b.classList.remove('active'));
    btn.classList.add('active');tipsModeState=btn.dataset.mode;
    if(tipsModeState==='fijo'){tipsFixedPanel.style.display='';tipsPercentPanel.style.display='none';setTipsAmount(tipsAmount,false);}
    else{tipsFixedPanel.style.display='none';tipsPercentPanel.style.display='';document.querySelectorAll('#tipsPercentChips .tips-chip')[1]?.classList.add('active');recalcPercent();}
  });
});
tipsSend.addEventListener('click',()=>{
  if(tipsAmount<=0){tipsMsg.innerHTML='Elige un monto antes de enviar tu propina 🙂';return;}
  spawnCoins();
  const empName=tipsSelectedEmployee!=='equipo'?tipsEmployees.find(e=>e.id===tipsSelectedEmployee)?.name:null;
  tipsConfirm.textContent=empName?`¡Gracias! Tu propina de ${fmtCOP(tipsAmount)} llegó directo a ${empName}. 💚`:`¡Gracias! Tu propina de ${fmtCOP(tipsAmount)} llegó directo al equipo. 💚`;
  tipsConfirm.style.display='block';
  setTimeout(()=>tipsConfirm.style.display='none',4000);
});
setTipsAmount(10000,false);

/* ===== SCROLL ANIMATIONS ===== */
const revealObs=new IntersectionObserver((entries)=>{
  entries.forEach(e=>{
    if(e.isIntersecting){e.target.style.opacity='1';e.target.style.transform='translateY(0)';}
  });
},{threshold:.12,rootMargin:'0px 0px -40px 0px'});

document.querySelectorAll('.about-grid > *, .buffet-grid > *, .review-card, .menu-card, .reserve-grid > *, .pqrs-grid > *, .tips-grid > *').forEach(el=>{
  el.style.opacity='0';el.style.transform='translateY(28px)';el.style.transition='opacity .65s ease, transform .65s ease';
  revealObs.observe(el);
});
</script>
</body>
</html>