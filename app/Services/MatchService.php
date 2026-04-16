<?php

namespace App\Services;

use App\Models\DiscoveryInteraction;
use App\Models\MatchResposta;
use App\Models\MatchScore;
use App\Models\MatchUser;
use App\Models\Pergunta;
use Illuminate\Support\Collection;

class MatchService
{
    /** Perguntas de “valores espirituais” para o filtro (≥1 resposta em comum). */
    public const VALUE_FILTER_QUESTION_ORDERS = [4, 5, 6];

    public const OBJECTIVE_QUESTION_ORDER = 20;

    /** Pesos relacionamento (soma = 1). */
    private const W_VALORES_ESPIRITUAIS = 0.25;

    private const W_OBJETIVOS_VIDA = 0.20;

    private const W_APEGO = 0.15;

    private const W_COMUNICACAO = 0.10;

    private const W_PERSONALIDADE = 0.10;

    private const W_ESTILO_VIDA = 0.08;

    private const W_LINGUAGEM_AMOR = 0.07;

    private const W_ESPACO = 0.05;

    /** Pesos amizade cristã (soma = 1) — segunda metade do score final. */
    private const W_AMIZ_INTERESSES = 0.20;

    private const W_AMIZ_FREQUENCIA = 0.20;

    private const W_AMIZ_ABERTURA = 0.15;

    private const W_AMIZ_VALORES = 0.15;

    private const W_AMIZ_PERSONALIDADE = 0.10;

    private const W_AMIZ_COMUNICACAO = 0.10;

    private const W_AMIZ_ESPIRITUALIDADE = 0.10;

    public function gerarPerfil(Collection $respostasPorOrdem): array
    {
        $g = fn (int $ordem) => strtoupper($respostasPorOrdem->get($ordem, ''));

        $extroversao = $this->mapearExtroversao($g(1), $g(2), $g(3));

        $valoresFiltro = array_values(array_filter([
            $g(4), $g(5), $g(6),
        ]));

        $valoresScore = array_values(array_filter([
            $g(4), $g(5), $g(6), $g(7),
        ]));

        return [
            'extroversao' => $extroversao,
            'valores_filtro' => $valoresFiltro,
            'valores_score' => $valoresScore,
            'objetivos' => $g(self::OBJECTIVE_QUESTION_ORDER),
            'objetivos_secundario' => $g(14),
            'comunicacao_conflito' => $g(11),
            'comunicacao_estilo' => $g(12),
            'frequencia_social' => $g(8),
            'linguagem_amor' => $g(13),
            'estilo_vida' => [$g(15), $g(16), $g(17)],
            'apego_raw' => $g(18),
            'apego_tipo' => $this->tipoApego($g(18)),
            'espaco' => $this->indiceAlternativa($g(19), 4),
            'amizade_investimento' => $g(10),
        ];
    }

    public function compatibilidadeValoresEspirituais(array $p1, array $p2): float
    {
        $set1 = $p1['valores_score'];
        $set2 = $p2['valores_score'];
        if ($set1 === [] || $set2 === []) {
            return 0.0;
        }
        $inter = count(array_intersect($set1, $set2));
        $maxPossivel = min(count(array_unique($set1)), count(array_unique($set2)), 4);

        return $maxPossivel > 0 ? ($inter / $maxPossivel) * 100 : 0.0;
    }

    public function compatibilidadeObjetivosVida(array $p1, array $p2): float
    {
        $o1 = $p1['objetivos'];
        $o2 = $p2['objetivos'];
        if ($o1 === '' || $o2 === '') {
            return 0.0;
        }
        $base = $o1 === $o2 ? 100.0 : $this->ordinalSimilarityPercent($o1, $o2, 4);

        $s = $this->ordinalSimilarityPercent($p1['objetivos_secundario'], $p2['objetivos_secundario'], 4);

        return round($base * 0.7 + $s * 0.3, 2);
    }

    public function compatibilidadePersonalidade(array $p1, array $p2): float
    {
        $diff = abs($p1['extroversao'] - $p2['extroversao']);
        $base = match (true) {
            $diff < 0.5 => 100.0,
            $diff < 1.5 => 70.0,
            $diff < 2.5 => 45.0,
            default => 25.0,
        };
        $amiz = $this->ordinalSimilarityPercent($p1['amizade_investimento'], $p2['amizade_investimento'], 4);

        return round($base * 0.85 + $amiz * 0.15, 2);
    }

    public function compatibilidadeComunicacao(array $p1, array $p2): float
    {
        $parts = [
            $p1['comunicacao_conflito'] === $p2['comunicacao_conflito'] ? 100.0 : $this->ordinalSimilarityPercent($p1['comunicacao_conflito'], $p2['comunicacao_conflito'], 4),
            $p1['comunicacao_estilo'] === $p2['comunicacao_estilo'] ? 100.0 : $this->ordinalSimilarityPercent($p1['comunicacao_estilo'], $p2['comunicacao_estilo'], 4),
            $this->ordinalSimilarityPercent($p1['frequencia_social'], $p2['frequencia_social'], 4),
        ];

        return round(array_sum($parts) / count($parts), 2);
    }

    public function compatibilidadeLinguagemAmor(array $p1, array $p2): float
    {
        if ($p1['linguagem_amor'] === $p2['linguagem_amor'] && $p1['linguagem_amor'] !== '') {
            return 100.0;
        }

        return $this->ordinalSimilarityPercent($p1['linguagem_amor'], $p2['linguagem_amor'], 4);
    }

    public function compatibilidadeEstiloVida(array $p1, array $p2): float
    {
        $a1 = $p1['estilo_vida'];
        $a2 = $p2['estilo_vida'];
        $iguais = 0;
        for ($i = 0; $i < 3; $i++) {
            if (($a1[$i] ?? '') !== '' && ($a1[$i] ?? '') === ($a2[$i] ?? '')) {
                $iguais++;
            }
        }

        return ($iguais / 3) * 100;
    }

    public function compatibilidadeApego(array $p1, array $p2): float
    {
        $t1 = $p1['apego_tipo'];
        $t2 = $p2['apego_tipo'];

        if ($t1 === 'seguro' && $t2 === 'seguro') {
            return 100.0;
        }
        if (($t1 === 'ansioso' && $t2 === 'evitativo') || ($t1 === 'evitativo' && $t2 === 'ansioso')) {
            return 0.0;
        }

        return 55.0;
    }

    public function compatibilidadeEspaco(array $p1, array $p2): float
    {
        $d = abs($p1['espaco'] - $p2['espaco']);

        return max(0.0, 100.0 - ($d * 28.0));
    }

    public function scoreAmizadeCrista(array $p1, array $p2): float
    {
        $g1 = fn (int $o) => $p1['_g'][$o] ?? '';
        $g2 = fn (int $o) => $p2['_g'][$o] ?? '';

        $interesses = (
            $this->ordinalSimilarityPercent($g1(1), $g2(1), 4)
            + $this->ordinalSimilarityPercent($g1(16), $g2(16), 4)
        ) / 2;

        $freq = $this->ordinalSimilarityPercent($g1(8), $g2(8), 4);
        $abertura = $this->ordinalSimilarityPercent($g1(9), $g2(9), 4);

        $v1 = array_values(array_unique(array_filter([$g1(5), $g1(7)])));
        $v2 = array_values(array_unique(array_filter([$g2(5), $g2(7)])));
        $valoresAmiz = $this->intersecaoPercentual($v1, $v2);

        $pers = $this->compatibilidadePersonalidade($p1, $p2);
        $com = ($this->ordinalSimilarityPercent($g1(11), $g2(11), 4) + $this->ordinalSimilarityPercent($g1(12), $g2(12), 4)) / 2;

        $e1 = array_values(array_unique(array_filter([$g1(4), $g1(6)])));
        $e2 = array_values(array_unique(array_filter([$g2(4), $g2(6)])));
        $esp = $this->intersecaoPercentual($e1, $e2);

        return round(
            $interesses * self::W_AMIZ_INTERESSES
            + $freq * self::W_AMIZ_FREQUENCIA
            + $abertura * self::W_AMIZ_ABERTURA
            + $valoresAmiz * self::W_AMIZ_VALORES
            + $pers * self::W_AMIZ_PERSONALIDADE
            + $com * self::W_AMIZ_COMUNICACAO
            + $esp * self::W_AMIZ_ESPIRITUALIDADE,
            2
        );
    }

    /**
     * @return array{passes: bool, reasons: array<int, string>}
     */
    public function passaFiltroInteligente(array $p1, array $p2): array
    {
        $reasons = [];

        if ($p1['objetivos'] === '' || $p2['objetivos'] === '' || $p1['objetivos'] !== $p2['objetivos']) {
            return ['passes' => false, 'reasons' => []];
        }
        $reasons[] = 'Mesmo foco em “O que você busca hoje” (pergunta 20).';

        $comum = array_intersect($p1['valores_filtro'], $p2['valores_filtro']);
        if (count($comum) < 1) {
            return ['passes' => false, 'reasons' => []];
        }
        $reasons[] = 'Pelo menos um alinhamento em comum na vida espiritual e na fé (perguntas 4, 5 e 6).';

        return ['passes' => true, 'reasons' => $reasons];
    }

    /**
     * @return array{
     *   percent: float,
     *   badge: string,
     *   breakdown: array<string, float>,
     *   reasons: array<int, string>
     * }
     */
    public function calcularMatch(MatchUser $user1, MatchUser $user2): array
    {
        $r1 = $this->respostasPorOrdem($user1);
        $r2 = $this->respostasPorOrdem($user2);
        $p1 = $this->gerarPerfil($r1);
        $p2 = $this->gerarPerfil($r2);
        $p1['_g'] = $r1->mapWithKeys(fn ($a, $k) => [(int) $k => strtoupper((string) $a)])->all();
        $p2['_g'] = $r2->mapWithKeys(fn ($a, $k) => [(int) $k => strtoupper((string) $a)])->all();

        $filtro = $this->passaFiltroInteligente($p1, $p2);
        if (! $filtro['passes']) {
            return [
                'percent' => 0.0,
                'badge' => 'Baixa',
                'breakdown' => [],
                'reasons' => [],
            ];
        }

        $v = $this->compatibilidadeValoresEspirituais($p1, $p2);
        $obj = $this->compatibilidadeObjetivosVida($p1, $p2);
        $ap = $this->compatibilidadeApego($p1, $p2);
        $com = $this->compatibilidadeComunicacao($p1, $p2);
        $pers = $this->compatibilidadePersonalidade($p1, $p2);
        $ev = $this->compatibilidadeEstiloVida($p1, $p2);
        $amor = $this->compatibilidadeLinguagemAmor($p1, $p2);
        $esp = $this->compatibilidadeEspaco($p1, $p2);

        $scoreRelacionamento = round(
            $v * self::W_VALORES_ESPIRITUAIS
            + $obj * self::W_OBJETIVOS_VIDA
            + $ap * self::W_APEGO
            + $com * self::W_COMUNICACAO
            + $pers * self::W_PERSONALIDADE
            + $ev * self::W_ESTILO_VIDA
            + $amor * self::W_LINGUAGEM_AMOR
            + $esp * self::W_ESPACO,
            2
        );

        $scoreAmizade = $this->scoreAmizadeCrista($p1, $p2);

        $percent = round(($scoreRelacionamento + $scoreAmizade) / 2, 2);

        $reasons = $filtro['reasons'];
        $reasons = array_merge(
            $reasons,
            $this->montarReasonsExtras($p1, $p2, array_intersect($p1['valores_filtro'], $p2['valores_filtro']))
        );

        return [
            'percent' => min(100.0, max(0.0, $percent)),
            'badge' => $this->badgeFromPercent($percent),
            'breakdown' => [
                'valores_espirituais' => round($v, 2),
                'objetivos_vida' => round($obj, 2),
                'apego_emocional' => round($ap, 2),
                'comunicacao' => round($com, 2),
                'personalidade' => round($pers, 2),
                'estilo_vida' => round($ev, 2),
                'relacionamento_prioridades' => round($amor, 2),
                'espaco_pessoal' => round($esp, 2),
                'amizade_crista' => round($scoreAmizade, 2),
            ],
            'reasons' => array_values(array_unique($reasons)),
        ];
    }

    public function respostasPorOrdem(MatchUser $user): Collection
    {
        return MatchResposta::query()
            ->where('match_user_id', $user->id)
            ->join('perguntas', 'perguntas.id', '=', 'match_respostas.pergunta_id')
            ->orderBy('perguntas.ordem')
            ->select('perguntas.ordem', 'match_respostas.alternativa')
            ->get()
            ->mapWithKeys(fn ($row) => [(int) $row->ordem => $row->alternativa]);
    }

    public function hashRespostas(MatchUser $user): string
    {
        $ordered = $this->respostasPorOrdem($user)->sortKeys();

        return hash('sha256', $ordered->map(fn ($a, $k) => $k.':'.$a)->implode('|'));
    }

    /**
     * @return array<int, array{user: MatchUser, percent: float, badge: string, breakdown: array, reasons: array, source_hash: string}>
     */
    public function candidatosPara(MatchUser $viewer): array
    {
        $expected = Pergunta::query()->count();
        if ($expected < 20) {
            return [];
        }

        $viewerCount = $viewer->respostas()->count();
        if ($viewerCount < $expected) {
            return [];
        }

        $hashViewer = $this->hashRespostas($viewer);

        $minBirth = now()->subYears(35)->startOfDay();
        $maxBirth = now()->subYears(21)->endOfDay();

        $candidates = MatchUser::query()
            ->where('id', '!=', $viewer->id)
            ->whereBetween('birth_date', [$minBirth, $maxBirth])
            ->withCount('respostas')
            ->get()
            ->where('respostas_count', '>=', $expected);

        $out = [];
        foreach ($candidates as $target) {
            $pairHash = hash('sha256', $hashViewer.'|'.$this->hashRespostas($target));

            $cached = MatchScore::query()
                ->where('viewer_id', $viewer->id)
                ->where('target_id', $target->id)
                ->where('source_hash', $pairHash)
                ->first();

            if ($cached) {
                $meta = $cached->meta ?? [];
                $out[] = [
                    'user' => $target,
                    'percent' => (float) $cached->score_percent,
                    'badge' => $meta['badge'] ?? $this->badgeFromPercent((float) $cached->score_percent),
                    'breakdown' => $meta['breakdown'] ?? [],
                    'reasons' => $meta['reasons'] ?? [],
                    'source_hash' => $pairHash,
                ];

                continue;
            }

            $result = $this->calcularMatch($viewer, $target);
            if ($result['percent'] <= 0 && empty($result['reasons'])) {
                continue;
            }

            MatchScore::query()->updateOrCreate(
                [
                    'viewer_id' => $viewer->id,
                    'target_id' => $target->id,
                ],
                [
                    'score_percent' => $result['percent'],
                    'source_hash' => $pairHash,
                    'meta' => [
                        'badge' => $result['badge'],
                        'breakdown' => $result['breakdown'],
                        'reasons' => $result['reasons'],
                    ],
                ]
            );

            $out[] = [
                'user' => $target,
                'percent' => $result['percent'],
                'badge' => $result['badge'],
                'breakdown' => $result['breakdown'],
                'reasons' => $result['reasons'],
                'source_hash' => $pairHash,
            ];
        }

        usort($out, fn ($a, $b) => $b['percent'] <=> $a['percent']);

        return $out;
    }

    public static function invalidateScoresForUser(string $matchUserId): void
    {
        MatchScore::query()
            ->where(function ($q) use ($matchUserId) {
                $q->where('viewer_id', $matchUserId)
                    ->orWhere('target_id', $matchUserId);
            })
            ->delete();
    }

    /**
     * @return array{user: MatchUser, percent: float, badge: string, breakdown: array, reasons: array}|null
     */
    public function proximoDiscovery(MatchUser $viewer): ?array
    {
        $lista = $this->candidatosPara($viewer);
        $vistos = DiscoveryInteraction::query()
            ->where('viewer_id', $viewer->id)
            ->pluck('target_id');

        foreach ($lista as $row) {
            if (! $vistos->contains($row['user']->id)) {
                return $row;
            }
        }

        return null;
    }

    private function mapearExtroversao(string $q1, string $q2, string $q3): float
    {
        $map1 = match ($q1) {
            'A' => 2.5,
            'B' => 1.8,
            'C' => 0.9,
            'D' => 1.3,
            default => 1.0,
        };
        $map2 = match ($q2) {
            'A' => 2.5,
            'B' => 1.8,
            'C' => 1.0,
            'D' => 0.5,
            default => 1.2,
        };
        $map3 = match ($q3) {
            'A' => 2.5,
            'B' => 1.7,
            'C' => 1.0,
            'D' => 0.5,
            default => 1.2,
        };

        return ($map1 + $map2 + $map3) / 3;
    }

    private function indiceAlternativa(string $letter, int $maxOpcoes): float
    {
        if ($letter === '') {
            return 0.0;
        }
        $idx = ord($letter) - ord('A');

        return max(0, min($maxOpcoes - 1, $idx));
    }

    private function ordinalSimilarityPercent(string $a, string $b, int $nOpcoes = 4): float
    {
        if ($a === '' || $b === '') {
            return 0.0;
        }
        $ia = ord($a) - ord('A');
        $ib = ord($b) - ord('A');
        if ($ia < 0 || $ia >= $nOpcoes || $ib < 0 || $ib >= $nOpcoes) {
            return 0.0;
        }
        $d = abs($ia - $ib);
        $maxD = max(1, $nOpcoes - 1);

        return max(0.0, 100.0 - ($d / $maxD) * 100.0);
    }

    private function tipoApego(string $q18): string
    {
        return match ($q18) {
            'B' => 'seguro',
            'A', 'C' => 'ansioso',
            'D' => 'evitativo',
            default => 'indefinido',
        };
    }

    private function badgeFromPercent(float $percent): string
    {
        if ($percent >= 75) {
            return 'Alta compatibilidade';
        }
        if ($percent >= 60) {
            return 'Boa compatibilidade';
        }
        if ($percent >= 40) {
            return 'Moderada';
        }

        return 'Baixa';
    }

    /**
     * @param  array<int, string>  $a
     * @param  array<int, string>  $b
     */
    private function intersecaoPercentual(array $a, array $b): float
    {
        if ($a === [] || $b === []) {
            return 0.0;
        }
        $u1 = array_values(array_unique($a));
        $u2 = array_values(array_unique($b));
        $inter = count(array_intersect($u1, $u2));
        $maxPossivel = max(1, min(count($u1), count($u2)));

        return ($inter / $maxPossivel) * 100;
    }

    /**
     * @param  array<int, string>  $comum
     * @return array<int, string>
     */
    private function montarReasonsExtras(array $p1, array $p2, array $comum): array
    {
        $out = [];
        if (count($comum) > 0) {
            $out[] = 'Convergência nas respostas de vida espiritual / fé (perguntas 4–6).';
        }
        if ($p1['linguagem_amor'] === $p2['linguagem_amor'] && $p1['linguagem_amor'] !== '') {
            $out[] = 'Mesma prioridade no relacionamento (pergunta 13).';
        }
        if ($p1['apego_tipo'] === 'seguro' && $p2['apego_tipo'] === 'seguro') {
            $out[] = 'Ambos com perfil de apego equilibrado na pergunta 18.';
        }

        return $out;
    }
}
