@extends('layout')
@section('titulo', 'Novo autor')

@section('conteudo')
<h1>Novo autor</h1>
<p class="sub"><a href="{{ route('autores.index') }}">← Voltar para a lista</a></p>

@if ($errors->any())
    <div class="alerta erro" role="alert">Confira os campos abaixo.</div>
@endif

<section class="card">
    <form method="post" action="{{ route('autores.store') }}" class="formulario" novalidate>
        @csrf

        <label>Nome
            <input type="text" name="name" value="{{ old('name') }}" maxlength="255" required
                   class="@error('name') campo-erro @enderror">
            @error('name')<span class="msg-erro">{{ $message }}</span>@enderror
        </label>

        <label>País
            <input type="text" name="country" value="{{ old('country', 'Brasil') }}" maxlength="60" required
                   class="@error('country') campo-erro @enderror">
            @error('country')<span class="msg-erro">{{ $message }}</span>@enderror
        </label>

        <div class="acoes">
            <a href="{{ route('autores.index') }}" class="botao secundario">Cancelar</a>
            <button type="submit" class="botao primario">Salvar</button>
        </div>
    </form>
</section>
@endsection
