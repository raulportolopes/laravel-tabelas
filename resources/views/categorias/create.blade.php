@extends('layout')
@section('titulo', 'Nova categoria')

@section('conteudo')
<h1>Nova categoria</h1>
<p class="sub"><a href="{{ route('categorias.index') }}">← Voltar para a lista</a></p>

@if ($errors->any())
    <div class="alerta erro" role="alert">Confira os campos abaixo.</div>
@endif

<section class="card">
    <form method="post" action="{{ route('categorias.store') }}" class="formulario" novalidate>
        @csrf

        <label class="inteiro">Nome
            <input type="text" name="name" value="{{ old('name') }}" maxlength="255" required
                   class="@error('name') campo-erro @enderror">
            @error('name')<span class="msg-erro">{{ $message }}</span>@enderror
        </label>

        <div class="acoes">
            <a href="{{ route('categorias.index') }}" class="botao secundario">Cancelar</a>
            <button type="submit" class="botao primario">Salvar</button>
        </div>
    </form>
</section>
@endsection
