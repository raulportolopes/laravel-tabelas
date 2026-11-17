<?php

namespace App\Support;

use Closure;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use ReflectionFunction;
use ReflectionMethod;

/**
 * Ferramenta DIDÁTICA (não é algo que você precisa em prova).
 *
 * Ela executa uma consulta Eloquent e devolve, para a tela:
 *   - o CÓDIGO PHP que foi executado (lido do próprio arquivo-fonte, então o
 *     código mostrado é exatamente o que rodou);
 *   - o SQL que o Laravel gerou e quantas consultas foram feitas no banco;
 *   - o RESULTADO em forma de tabela.
 */
class ExemploConsulta
{
    /**
     * @param  string   $titulo      Título do card
     * @param  string   $explicacao  Texto em HTML simples explicando o exemplo
     * @param  Closure  $consulta    fn () => Model::...->get()   (a consulta em si)
     * @param  Closure  $linha       fn ($model) => [coluna => valor]  (o "foreach" da tela)
     * @param  string   $tag         Etiqueta curta (ex.: "N:1", "1:N", "ordenação")
     */
    public static function rodar(string $titulo, string $explicacao, Closure $consulta, Closure $linha, string $tag = ''): array
    {
        // Liga o "gravador" de consultas do Laravel e zera o que havia antes.
        DB::flushQueryLog();
        DB::enableQueryLog();

        $dados = $consulta();

        // first()/find() devolvem 1 model; get()/all() devolvem Collection.
        // Normalizamos para Collection para montar a tabela do mesmo jeito.
        $itens = $dados instanceof Collection ? $dados : collect($dados ? [$dados] : []);

        // ATENÇÃO: o $linha roda DENTRO do gravador. Se ele acessar uma relação
        // que não veio no with(), o Laravel faz uma consulta NOVA por item
        // (o famoso problema N+1) e isso aparece na contagem de SQL.
        $linhas = $itens->map(fn ($item) => $linha($item))->values()->all();

        $sqls = collect(DB::getQueryLog())
            ->map(fn ($q) => self::sqlComValores($q['query'], $q['bindings']))
            ->all();

        DB::disableQueryLog();

        return [
            'titulo'     => $titulo,
            'tag'        => $tag,
            'explicacao' => $explicacao,
            'codigo'     => self::fonte($consulta),
            'laco'       => self::fonte($linha),
            'sqls'       => $sqls,
            'colunas'    => array_keys($linhas[0] ?? []),
            'linhas'     => $linhas,
        ];
    }

    /** Lê do arquivo .php as linhas onde a closure foi escrita. */
    public static function fonte(Closure $funcao): string
    {
        $r = new ReflectionFunction($funcao);

        return self::trecho($r->getFileName(), $r->getStartLine(), $r->getEndLine(), true);
    }

    /** Lê do arquivo .php o código de um método (usado para mostrar os models). */
    public static function metodo(string $classe, string $metodo): string
    {
        $r = new ReflectionMethod($classe, $metodo);
        $inicio = $r->getStartLine();

        // Inclui o comentário /** ... */ que fica acima do método.
        if ($doc = $r->getDocComment()) {
            $inicio -= substr_count($doc, "\n") + 1;
        }

        return self::trecho($r->getFileName(), $inicio, $r->getEndLine(), false);
    }

    private static function trecho(string $arquivo, int $inicio, int $fim, bool $limparNomeDoArgumento): string
    {
        $linhas = array_slice(file($arquivo), $inicio - 1, $fim - $inicio + 1);

        // Remove a indentação comum para o código ficar alinhado à esquerda.
        $recuo = min(array_map(
            fn ($l) => strlen($l) - strlen(ltrim($l)),
            array_filter($linhas, fn ($l) => trim($l) !== '')
        ));
        $codigo = rtrim(implode('', array_map(fn ($l) => substr($l, $recuo), $linhas)));

        if ($limparNomeDoArgumento) {
            // "consulta: fn () => X," vira só "fn () => X"
            $codigo = preg_replace('/^(consulta|linha):\s*/', '', $codigo);
            $codigo = preg_replace('/,\s*$/', '', $codigo);
        }

        return $codigo;
    }

    /** Troca os "?" do SQL pelos valores, só para exibir (nunca execute isso!). */
    private static function sqlComValores(string $sql, array $valores): string
    {
        foreach ($valores as $v) {
            $v = is_numeric($v) ? $v : "'".addslashes((string) $v)."'";
            $sql = preg_replace('/\?/', (string) $v, $sql, 1);
        }

        return $sql;
    }
}
