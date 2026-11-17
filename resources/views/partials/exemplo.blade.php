{{--
    Um card de exemplo. Recebe $e (array montado por App\Support\ExemploConsulta::rodar).
    {{ }} escapa o HTML (seguro). {!! !!} NÃO escapa: só usamos no texto de explicação,
    que é escrito por nós no controller, nunca vindo do usuário.
--}}
<article class="card" id="ex-{{ $n }}">
    @if($e['tag'])<span class="tag">{{ $e['tag'] }}</span>@endif
    <h2>{{ $n }}. {{ $e['titulo'] }}</h2>
    <p>{!! $e['explicacao'] !!}</p>

    <div class="rotulo">Consulta (controller)</div>
    <pre><code>{{ $e['codigo'] }}</code></pre>

    <details>
        <summary>Como cada linha é usada (o "foreach" da tela)</summary>
        <pre><code>{{ $e['laco'] }}</code></pre>
    </details>

    @php $qtd = count($e['sqls']); @endphp
    <div class="rotulo sql">
        SQL executado no banco:
        <span class="contador {{ $qtd > 3 ? 'alerta' : 'ok' }}">{{ $qtd }} {{ $qtd === 1 ? 'consulta' : 'consultas' }}</span>
    </div>
    <div class="sql">
        @if($qtd > 3)
            <details>
                <summary>Ver as {{ $qtd }} consultas (repare na repetição)</summary>
                <pre><code>@foreach($e['sqls'] as $sql){{ $sql }}
@endforeach</code></pre>
            </details>
        @else
            <pre><code>@foreach($e['sqls'] as $sql){{ $sql }}
@endforeach</code></pre>
        @endif
    </div>

    <div class="rotulo">Resultado ({{ count($e['linhas']) }} {{ count($e['linhas']) === 1 ? 'linha' : 'linhas' }})</div>
    <div class="tabela">
        <table>
            <thead><tr>@foreach($e['colunas'] as $c)<th scope="col">{{ $c }}</th>@endforeach</tr></thead>
            <tbody>
            @forelse($e['linhas'] as $linha)
                <tr>@foreach($linha as $valor)<td>{{ $valor }}</td>@endforeach</tr>
            @empty
                <tr><td>Nenhum registro.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</article>
