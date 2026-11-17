<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('titulo') · Biblioteca</title>
    <style>
        :root { --fundo:#f4f1ea; --card:#fffdf8; --texto:#2b2620; --suave:#6f665b; --borda:#e3dccf;
                --marca:#7a2e1f; --marca-escura:#5c2116; --perigo:#b42318; --ok:#1d7a46; }
        * { box-sizing:border-box; }
        body { margin:0; font-family:system-ui, "Segoe UI", Roboto, Arial, sans-serif; background:var(--fundo); color:var(--texto); line-height:1.5; }
        a { color:var(--marca); }
        .topo { background:var(--marca); color:#fff; }
        .topo .wrap { display:flex; align-items:center; justify-content:space-between; gap:1rem; }
        .topo a { color:#fff; text-decoration:none; font-weight:700; font-size:1.15rem; letter-spacing:.02em; }
        .menu { display:flex; gap:.25rem; }
        .topo .menu a { font-size:.95rem; font-weight:600; padding:.4rem .75rem; border-radius:6px; }
        .topo .menu a[aria-current="page"], .topo .menu a:hover { background:rgba(255,255,255,.18); }
        .wrap { max-width:1100px; margin:0 auto; padding:1rem 1.25rem; }
        h1 { font-family:Georgia, "Times New Roman", serif; font-size:1.9rem; margin:.5rem 0 .25rem; }
        .sub { color:var(--suave); margin:0 0 1.25rem; }
        .card { background:var(--card); border:1px solid var(--borda); border-radius:12px; box-shadow:0 1px 2px rgba(0,0,0,.04); }
        .barra { display:flex; flex-wrap:wrap; gap:.75rem; align-items:end; justify-content:space-between; padding:1rem 1.25rem; border-bottom:1px solid var(--borda); }
        .barra form { display:flex; flex-wrap:wrap; gap:.6rem; align-items:end; }
        label { display:flex; flex-direction:column; gap:.25rem; font-size:.85rem; font-weight:600; color:var(--suave); }
        input, select { font:inherit; color:var(--texto); background:#fff; padding:.5rem .65rem; border:1px solid var(--borda); border-radius:8px; min-width:0; }
        input:focus, select:focus { border-color:var(--marca); }
        .botao { display:inline-flex; align-items:center; gap:.4rem; font:inherit; font-weight:600; padding:.55rem 1rem; border-radius:8px; border:1px solid transparent; cursor:pointer; text-decoration:none; }
        .botao.primario { background:var(--marca); color:#fff; }
        .botao.primario:hover { background:var(--marca-escura); }
        .botao.secundario { background:#fff; color:var(--texto); border-color:var(--borda); }
        .botao.perigo { background:transparent; color:var(--perigo); border-color:#f1c4bf; padding:.35rem .7rem; font-size:.875rem; }
        .botao.perigo:hover { background:#fdecea; }
        :focus-visible { outline:3px solid #e9a23b; outline-offset:2px; }
        .tabela { overflow-x:auto; }
        table { width:100%; border-collapse:collapse; }
        th, td { padding:.75rem 1rem; text-align:left; border-bottom:1px solid var(--borda); vertical-align:middle; }
        th { font-size:.8rem; text-transform:uppercase; letter-spacing:.05em; color:var(--suave); background:#faf6ee; }
        tbody tr:hover { background:#fbf7f0; }
        td.titulo { font-family:Georgia, "Times New Roman", serif; font-size:1.05rem; font-weight:700; }
        .num { text-align:right; font-variant-numeric:tabular-nums; }
        .selo { display:inline-block; padding:.15rem .6rem; border-radius:99px; background:#f1e7d8; color:var(--marca-escura); font-size:.8rem; font-weight:600; }
        .vazio { padding:2.5rem 1rem; text-align:center; color:var(--suave); }
        .alerta { padding:.75rem 1rem; border-radius:8px; margin-bottom:1rem; }
        .alerta.sucesso { background:#e3f4ea; color:var(--ok); border:1px solid #bfe3cd; }
        .alerta.erro { background:#fdecea; color:var(--perigo); border:1px solid #f1c4bf; }
        .alerta ul { margin:.25rem 0 0; padding-left:1.2rem; }
        .contagem { color:var(--suave); font-weight:600; align-self:center; }
        .rodape-tabela { padding:.75rem 1.25rem; color:var(--suave); font-size:.875rem; }
        .formulario { padding:1.25rem; display:grid; gap:1rem; grid-template-columns:repeat(2, minmax(0, 1fr)); }
        .formulario .inteiro { grid-column:1 / -1; }
        .formulario .acoes { grid-column:1 / -1; display:flex; gap:.6rem; justify-content:flex-end; }
        .campo-erro { border-color:var(--perigo); }
        .msg-erro { color:var(--perigo); font-weight:500; font-size:.8rem; }
        @media (max-width: 640px) {
            .formulario { grid-template-columns:1fr; }
            .esconde-celular { display:none; }
            th, td { padding:.6rem .6rem; }
            td.titulo { font-size:.95rem; }
            .barra, .barra form { align-items:stretch; }
            .barra > a.botao { justify-content:center; width:100%; }
            .topo .wrap { flex-wrap:wrap; }
        }
    </style>
</head>
<body>
<header class="topo">
    <div class="wrap">
        <a href="{{ route('livros.index') }}">📚 Biblioteca</a>
        <nav class="menu" aria-label="Principal">
            <a href="{{ route('livros.index') }}" @if(request()->routeIs('livros.*')) aria-current="page" @endif>Livros</a>
            <a href="{{ route('autores.index') }}" @if(request()->routeIs('autores.*')) aria-current="page" @endif>Autores</a>
            <a href="{{ route('categorias.index') }}" @if(request()->routeIs('categorias.*')) aria-current="page" @endif>Categorias</a>
        </nav>
    </div>
</header>
<main class="wrap">
    @if (session('sucesso'))
        <div class="alerta sucesso" role="status">{{ session('sucesso') }}</div>
    @endif

    @yield('conteudo')
</main>
</body>
</html>
