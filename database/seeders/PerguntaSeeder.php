<?php

namespace Database\Seeders;

use App\Models\Pergunta;
use Illuminate\Database\Seeder;

class PerguntaSeeder extends Seeder
{
    public function run(): void
    {
        $dados = [
            [
                'ordem' => 1,
                'texto' => 'Em um fim de semana ideal, você prefere:',
                'opcoes' => [
                    'A' => 'Estar com um grupo de amigos ou evento da igreja',
                    'B' => 'Um encontro com poucas pessoas próximas',
                    'C' => 'Um tempo mais reservado (descanso, leitura, devocional)',
                    'D' => 'Depende do momento',
                ],
            ],
            [
                'ordem' => 2,
                'texto' => 'Como você recarrega sua energia?',
                'opcoes' => [
                    'A' => 'Com pessoas',
                    'B' => 'Equilibrando pessoas e tempo sozinho',
                    'C' => 'Mais sozinho',
                    'D' => 'Isolado por longos períodos',
                ],
            ],
            [
                'ordem' => 3,
                'texto' => 'Em um grupo, você normalmente:',
                'opcoes' => [
                    'A' => 'Puxa conversas e integra as pessoas',
                    'B' => 'Participa ativamente',
                    'C' => 'Observa mais do que fala',
                    'D' => 'Prefere ficar quieto',
                ],
            ],
            [
                'ordem' => 4,
                'texto' => 'Sua vida espiritual hoje é:',
                'opcoes' => [
                    'A' => 'Muito ativa',
                    'B' => 'Constante',
                    'C' => 'Em crescimento',
                    'D' => 'Irregular',
                ],
            ],
            [
                'ordem' => 5,
                'texto' => 'Em qual dessas atividades você mais se envolve naturalmente na sua vida cristã?',
                'opcoes' => [
                    'A' => 'Momentos pessoais como oração, leitura bíblica e devocional',
                    'B' => 'Estar com pessoas da igreja (cultos, grupos, comunhão)',
                    'C' => 'Estudar e aprender mais sobre a Bíblia e a fé',
                    'D' => 'Ajudar e servir outras pessoas na prática',
                ],
            ],
            [
                'ordem' => 6,
                'texto' => 'Na prática, como você espera que a fé esteja presente na sua relação com um amigo(a) ou parceiro(a)?',
                'opcoes' => [
                    'A' => 'Vivendo juntos a fé (orações, conversas espirituais, crescimento em conjunto)',
                    'B' => 'Apoiando e incentivando um ao outro na caminhada',
                    'C' => 'Cada um com sua vivência, mas com respeito mútuo',
                    'D' => 'Ainda estou descobrindo como isso se encaixa',
                ],
            ],
            [
                'ordem' => 7,
                'texto' => 'Para você, uma boa amizade precisa ter:',
                'opcoes' => [
                    'A' => 'Conversas profundas',
                    'B' => 'Presença constante',
                    'C' => 'Momentos leves',
                    'D' => 'Apoio nos momentos difíceis',
                ],
            ],
            [
                'ordem' => 8,
                'texto' => 'Com que frequência você gosta de falar com seus amigos?',
                'opcoes' => [
                    'A' => 'Todos os dias',
                    'B' => 'Algumas vezes por semana',
                    'C' => 'Esporadicamente',
                    'D' => 'Só quando necessário',
                ],
            ],
            [
                'ordem' => 9,
                'texto' => 'Você costuma se abrir emocionalmente?',
                'opcoes' => [
                    'A' => 'Sim',
                    'B' => 'Com pessoas de confiança',
                    'C' => 'Demoro um pouco para me abrir',
                    'D' => 'Evito me abrir',
                ],
            ],
            [
                'ordem' => 10,
                'texto' => 'Em amizades, você tende a:',
                'opcoes' => [
                    'A' => 'Investir bastante',
                    'B' => 'Manter equilíbrio',
                    'C' => 'Ser independente',
                    'D' => 'Ter dificuldade para investir',
                ],
            ],
            [
                'ordem' => 11,
                'texto' => 'Quando há conflito, você tende a:',
                'opcoes' => [
                    'A' => 'Resolver na hora',
                    'B' => 'Conversar depois',
                    'C' => 'Evitar',
                    'D' => 'Ficar na defensiva',
                ],
            ],
            [
                'ordem' => 12,
                'texto' => 'Você prefere pessoas que:',
                'opcoes' => [
                    'A' => 'Falam diretamente',
                    'B' => 'Falam com sensibilidade',
                    'C' => 'Demonstram com atitudes',
                    'D' => 'Depende da situação',
                ],
            ],
            [
                'ordem' => 13,
                'texto' => 'O que é mais importante em um relacionamento?',
                'opcoes' => [
                    'A' => 'Companheirismo',
                    'B' => 'Crescimento espiritual',
                    'C' => 'Estabilidade',
                    'D' => 'Conexão emocional',
                ],
            ],
            [
                'ordem' => 14,
                'texto' => 'Você pensa em um relacionamento sério?',
                'opcoes' => [
                    'A' => 'Sim, em breve',
                    'B' => 'Sim, no tempo certo',
                    'C' => 'Talvez',
                    'D' => 'Não é prioridade',
                ],
            ],
            [
                'ordem' => 15,
                'texto' => 'Sua rotina ideal é:',
                'opcoes' => [
                    'A' => 'Cheia',
                    'B' => 'Equilibrada',
                    'C' => 'Tranquila',
                    'D' => 'Variável',
                ],
            ],
            [
                'ordem' => 16,
                'texto' => 'Você gosta de participar das atividades da igreja?',
                'opcoes' => [
                    'A' => 'Gosto muito',
                    'B' => 'Gosto, com equilíbrio',
                    'C' => 'Ocasionalmente',
                    'D' => 'Gosto pouco',
                ],
            ],
            [
                'ordem' => 17,
                'texto' => 'Sobre servir na igreja, você:',
                'opcoes' => [
                    'A' => 'Sou muito envolvido',
                    'B' => 'Participo às vezes',
                    'C' => 'Quero me envolver mais',
                    'D' => 'Não participo',
                ],
            ],
            [
                'ordem' => 18,
                'texto' => 'Em relacionamentos, você se conecta:',
                'opcoes' => [
                    'A' => 'Com facilidade',
                    'B' => 'Com equilíbrio',
                    'C' => 'Com dificuldade',
                    'D' => 'Evito me conectar',
                ],
            ],
            [
                'ordem' => 19,
                'texto' => 'De quanto espaço pessoal você precisa?',
                'opcoes' => [
                    'A' => 'Pouco',
                    'B' => 'Moderado',
                    'C' => 'Bastante',
                    'D' => 'Muito',
                ],
            ],
            [
                'ordem' => 20,
                'texto' => 'O que você busca hoje:',
                'opcoes' => [
                    'A' => 'Família',
                    'B' => 'Crescimento espiritual',
                    'C' => 'Carreira',
                    'D' => 'Propósito',
                ],
            ],
        ];

        foreach ($dados as $row) {
            Pergunta::query()->updateOrCreate(
                ['ordem' => $row['ordem']],
                [
                    'texto' => $row['texto'],
                    'opcoes' => $row['opcoes'],
                ]
            );
        }

        Pergunta::query()->where('ordem', '>', 20)->delete();
    }
}
