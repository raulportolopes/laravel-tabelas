@extends('layout')
@section('titulo', 'Novo livro')

@section('conteudo')
<h1>Novo livro</h1>
<p class="sub"><a href="{{ route('livros.index') }}">← Voltar para a lista</a></p>

@if ($errors->any())
    <div class="alerta erro" role="alert">
        Confira os campos abaixo.
    </div>
@endif

<section class="card">
    <form method="post" action="{{ route('livros.store') }}" class="formulario" novalidate>
        @csrf

        <label class="inteiro">Título
            <input type="text" name="title" value="{{ old('title') }}" maxlength="255" required
                   class="@error('title') campo-erro @enderror">
            @error('title')<span class="msg-erro">{{ $message }}</span>@enderror
        </label>

        <label>Autor
            <select name="author_id" required class="@error('author_id') campo-erro @enderror">
                <option value="">Selecione</option>
                @foreach ($authors as $author)
                    <option value="{{ $author->id }}" @selected(old('author_id') == $author->id)>{{ $author->name }}</option>
                @endforeach
            </select>
            @error('author_id')<span class="msg-erro">{{ $message }}</span>@enderror
        </label>

        <label>Categoria
            <select name="category_id" required class="@error('category_id') campo-erro @enderror">
                <option value="">Selecione</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>{{ $category->name }}</option>
                @endforeach
            </select>
            @error('category_id')<span class="msg-erro">{{ $message }}</span>@enderror
        </label>

        <label>Páginas
            <input type="number" name="pages" value="{{ old('pages') }}" min="1" max="65535" required
                   class="@error('pages') campo-erro @enderror">
            @error('pages')<span class="msg-erro">{{ $message }}</span>@enderror
        </label>

        <label>Data de publicação
            <input type="date" name="published_at" value="{{ old('published_at') }}" required
                   class="@error('published_at') campo-erro @enderror">
            @error('published_at')<span class="msg-erro">{{ $message }}</span>@enderror
        </label>

        <div class="acoes">
            <a href="{{ route('livros.index') }}" class="botao secundario">Cancelar</a>
            <button type="submit" class="botao primario">Salvar</button>
        </div>
    </form>
</section>
@endsection
