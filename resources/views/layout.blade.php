{{--
    Layout base. As outras views usam @extends('layout') e preenchem @section('conteudo').
    O CSS está inline de propósito: assim o projeto não depende de npm/Vite nem de
    arquivos em public/, o que facilita publicar numa subpasta.
--}}
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('titulo') · Laravel Tabelas</title>
    <style>
        :root { --fundo:#f5f6fa; --card:#fff; --texto:#1f2430; --suave:#5b6275; --borda:#dde1ea;
                --azul:#2453d6; --verde:#137a3b; --vermelho:#b42318; --codigo:#13161f; }
        * { box-sizing: border-box; }
        body { margin:0; font-family: system-ui, "Segoe UI", Roboto, Arial, sans-serif; background:var(--fundo); color:var(--texto); line-height:1.55; }
        header { background:#14213d; color:#fff; }
        header .wrap { display:flex; flex-wrap:wrap; gap:1rem; align-items:center; justify-content:space-between; }
        header a { color:#fff; text-decoration:none; }
        nav a { padding:.4rem .8rem; border-radius:6px; }
        nav a[aria-current="page"], nav a:hover, nav a:focus-visible { background:rgba(255,255,255,.18); }
        .wrap { max-width:1100px; margin:0 auto; padding:1rem; }
        h1 { font-size:1.7rem; margin:.5rem 0; } h2 { font-size:1.25rem; margin:0 0 .4rem; }
        .card { background:var(--card); border:1px solid var(--borda); border-radius:10px; padding:1.1rem 1.2rem; margin:1.2rem 0; }
        .tag { display:inline-block; font-size:.75rem; font-weight:700; padding:.15rem .55rem; border-radius:99px; background:#e6ecff; color:var(--azul); margin-bottom:.4rem; }
        code { background:#eef0f5; padding:.05rem .3rem; border-radius:4px; font-family: Consolas, "Courier New", monospace; font-size:.92em; }
        pre { background:var(--codigo); color:#e8eaf0; padding: .8rem 1rem; border-radius:8px; overflow-x:auto; font-size:.88rem; margin:.3rem 0 .8rem; }
        pre code { background:none; padding:0; color:inherit; }
        .rotulo { font-size:.8rem; font-weight:700; text-transform:uppercase; letter-spacing:.04em; color:var(--suave); margin-top:.8rem; }
        .sql pre { background:#0d2b1e; color:#b9f3cf; }
        .contador { font-weight:700; padding:.1rem .5rem; border-radius:6px; }
        .contador.ok { background:#dcf5e5; color:var(--verde); }
        .contador.alerta { background:#fde4e1; color:var(--vermelho); }
        .tabela { overflow-x:auto; }
        table { border-collapse:collapse; width:100%; font-size:.9rem; }
        th, td { border-bottom:1px solid var(--borda); padding:.4rem .55rem; text-align:left; vertical-align:top; }
        th { background:#f0f2f7; }
        details summary { cursor:pointer; color:var(--azul); font-weight:600; }
        .grade { display:grid; gap:1rem; grid-template-columns:repeat(auto-fit, minmax(230px, 1fr)); }
        .tabela-bd h3 { margin:0 0 .4rem; font-size:1rem; }
        .tabela-bd ul { list-style:none; padding:0; margin:0; font-family:Consolas, monospace; font-size:.85rem; }
        .pk { color:#a15c00; font-weight:700; } .fk { color:var(--azul); font-weight:700; }
        form.experimente { display:flex; flex-wrap:wrap; gap:.6rem; align-items:end; }
        label { display:flex; flex-direction:column; font-size:.85rem; font-weight:600; }
        select, button { font:inherit; padding:.4rem .6rem; border-radius:6px; border:1px solid var(--borda); }
        button { background:var(--azul); color:#fff; border:0; cursor:pointer; }
        :focus-visible { outline:3px solid #ffb703; outline-offset:2px; }
        footer { color:var(--suave); font-size:.85rem; text-align:center; padding:2rem 1rem; }
    </style>
</head>
<body>
<header>
    <div class="wrap">
        <a href="{{ route('home') }}"><strong>Laravel Tabelas</strong> · ordenação e relações</a>
        <nav aria-label="Principal">
            {{-- request()->routeIs() marca o link da página atual --}}
            <a href="{{ route('home') }}" @if(request()->routeIs('home')) aria-current="page" @endif>Início</a>
            <a href="{{ route('ordenacao') }}" @if(request()->routeIs('ordenacao')) aria-current="page" @endif>Ordenação</a>
            <a href="{{ route('relacoes') }}" @if(request()->routeIs('relacoes')) aria-current="page" @endif>Relações</a>
        </nav>
    </div>
</header>
<main class="wrap">
    @yield('conteudo')
</main>
<footer>Material de estudo · SP Skills 2026 · #17 Tecnologias Web · Raul Porto Lopes (Avaliador)</footer>
</body>
</html>
