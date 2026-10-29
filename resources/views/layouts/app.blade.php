<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>@yield('title', 'Pustaka Jurnal')</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;500;600&family=Newsreader:opsz,wght@6..72,500;6..72,600&display=swap" rel="stylesheet">
<style>
:root{--bg:#eef1ee;--card:#fbfcfa;--ink:#1c2826;--mute:#5d6b68;--line:#cfd7d3;--acc:#1f5c52;--warn:#9a6b00;--bad:#a23b2a;--ind:#3b4a9c;--r:6px}
*{box-sizing:border-box}
body{margin:0;background:var(--bg);color:var(--ink);font:16px/1.55 'Instrument Sans',system-ui,sans-serif}
h1,h2,.brand{font-family:Newsreader,Georgia,serif;font-weight:600;line-height:1.2;margin:0}
h1{font-size:1.9rem}
h2{font-size:1.15rem;margin-bottom:.25rem}
a{color:var(--acc)}
:focus-visible{outline:2px solid var(--acc);outline-offset:2px}
.bar{display:flex;flex-wrap:wrap;gap:.5rem 1.5rem;align-items:center;padding:.8rem 1.5rem;background:var(--card);border-bottom:1px solid var(--line)}
.bar nav{display:flex;gap:1rem;flex:1}
.brand{font-size:1.35rem;text-decoration:none;color:var(--ink)}
main{max-width:960px;margin:0 auto;padding:1.5rem}
.head{display:flex;justify-content:space-between;align-items:center;gap:1rem;flex-wrap:wrap;margin-bottom:1rem}
.btn{display:inline-block;background:var(--acc);color:#fff;border:1px solid var(--acc);border-radius:var(--r);padding:.5rem 1rem;font:inherit;cursor:pointer;text-decoration:none}
.btn.alt{background:transparent;color:var(--acc)}
.link{background:none;border:0;padding:0;font:inherit;color:var(--acc);text-decoration:underline;cursor:pointer}
.bad{color:var(--bad)}
.inline{display:inline;margin-left:.75rem}
.mute{color:var(--mute)}
.flash{background:#dcebe6;border:1px solid var(--acc);border-radius:var(--r);padding:.6rem .9rem}
.errs{background:#f6e1dc;border:1px solid var(--bad);border-radius:var(--r);padding:.6rem .9rem .6rem 2rem;margin:0 0 1rem}
.tabs{display:flex;flex-wrap:wrap;gap:.4rem;margin-bottom:.9rem}
.tabs a{padding:.25rem .7rem;border:1px solid var(--line);border-radius:99px;text-decoration:none;color:var(--ink);background:var(--card)}
.tabs a.on{background:var(--acc);border-color:var(--acc);color:#fff}
.find{display:flex;gap:.5rem;margin-bottom:1.2rem}
.item{background:var(--card);border:1px solid var(--line);border-left:5px solid var(--st,var(--mute));border-radius:var(--r);padding:.85rem 1rem;margin-bottom:.75rem}
.item p{margin:.25rem 0}
.s-sedang_dibaca{--st:var(--warn)}.s-selesai{--st:var(--acc)}.s-dipakai{--st:var(--ind)}
.chip{display:inline-block;font-size:.85rem;border:1px solid var(--line);border-radius:99px;padding:0 .6rem;margin:.15rem .3rem 0 0;text-decoration:none;color:var(--mute)}
.st{font-size:.9rem;font-weight:600;color:var(--st,var(--mute));margin-right:.6rem}
label{display:block;font-weight:500;margin:.9rem 0 .25rem}
input,select,textarea{width:100%;font:inherit;padding:.5rem .65rem;border:1px solid var(--line);border-radius:var(--r);background:#fff;color:var(--ink)}
input[type=checkbox]{width:auto;margin-right:.4rem}
textarea{min-height:5rem}
small{color:var(--mute)}
.grid{display:grid;grid-template-columns:1fr 1fr;gap:0 1rem}
.scroll{overflow-x:auto}
table{width:100%;border-collapse:collapse;background:var(--card)}
th,td{text-align:left;padding:.6rem .7rem;border-bottom:1px solid var(--line);vertical-align:top}
.empty{background:var(--card);border:1px dashed var(--line);border-radius:var(--r);padding:1.2rem}
.pager{display:flex;gap:1rem;margin-top:1rem}
.panel{background:var(--card);border:1px solid var(--line);border-radius:var(--r);padding:1rem;margin-bottom:1rem}
.panel p{margin:.4rem 0}
.panel ul{list-style:none;margin:.5rem 0 0;padding:0}
.panel li{padding:.45rem 0;border-top:1px solid var(--line)}
.cols{display:grid;grid-template-columns:1fr 1fr;gap:0 1rem}
.pies{display:grid;grid-template-columns:repeat(auto-fit,minmax(250px,1fr));gap:1rem;margin-bottom:1rem}
.pies .panel{margin:0}
.pie-wrap{display:flex;flex-direction:column;align-items:center;gap:.9rem;margin-top:.6rem}
.pie-chart{width:150px;height:150px;border-radius:50%;border:1px solid var(--line)}
.panel ul.legend{width:100%;margin:0}
.legend li{border:0;padding:.1rem 0}
.legend a{color:var(--ink)}
.legend i{display:inline-block;width:.7rem;height:.7rem;border-radius:2px;margin-right:.45rem}
.wide{grid-column:1/-1}
.auth{max-width:380px;margin:2rem auto}
@media(max-width:640px){.grid,.cols{grid-template-columns:1fr}main{padding:1rem}}
</style>
</head>
<body>
<header class="bar">
  <a class="brand" href="{{ url('/') }}">Pustaka Jurnal</a>
  @auth
  <nav>
    <a href="{{ route('dashboard') }}">Dashboard</a>
    <a href="{{ route('referensi.index') }}">Referensi</a>
    <a href="{{ route('jurnal.index') }}">Jurnal target</a>
  </nav>
  <form method="post" action="{{ route('logout') }}">@csrf<button class="link">Keluar</button></form>
  @endauth
</header>
<main>
  @if(session('ok'))<p class="flash">{{ session('ok') }}</p>@endif
  @if($errors->any())<ul class="errs">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>@endif
  @yield('content')
</main>
</body>
</html>
