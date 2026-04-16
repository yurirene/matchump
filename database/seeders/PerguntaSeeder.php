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
                'texto' => 'Em um fim de semana ideal você prefere:',
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
                'texto' => 'Em um grupo você normalmente:',
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
                'texto' => 'O que você mais valoriza na fé?',
                'opcoes' => [
                    'A' => 'Relacionamento com Deus',
                    'B' => 'Comunhão com a igreja',
                    'C' => 'Conhecimento bíblico',
                    'D' => 'Serviço ao próximo',
                ],
            ],
            [
                'ordem' => 6,
                'texto' => 'Você gostaria que seu amigo(a) ou parceiro(a):',
                'opcoes' => [
                    'A' => 'Caminhasse espiritualmente junto comigo',
                    'B' => 'Me incentivasse na fé',
                    'C' => 'Respeitasse minha fé',
                    'D' => 'Ainda estou entendendo isso',
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
                'texto' => 'Com que frequência você gosta de falar com amigos?',
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
                    'C' => 'Demora um pouco',
                    'D' => 'Evito',
                ],
            ],
            [
                'ordem' => 10,
                'texto' => 'Em amizades você tende a:',
                'opcoes' => [
                    'A' => 'Investir bastante',
                    'B' => 'Equilibrar',
                    'C' => 'Ser independente',
                    'D' => 'Ter dificuldade',
                ],
            ],
            [
                'ordem' => 11,
                'texto' => 'Quando há conflito:',
                'opcoes' => [
                    'A' => 'Resolver na hora',
                    'B' => 'Conversar depois',
                    'C' => 'Evitar',
                    'D' => 'Ficar defensivo',
                ],
            ],
            [
                'ordem' => 12,
                'texto' => 'Você prefere pessoas que:',
                'opcoes' => [
                    'A' => 'Falam diretamente',
                    'B' => 'Falam com sensibilidade',
                    'C' => 'Demonstram com atitudes',
                    'D' => 'Depende',
                ],
            ],
            [
                'ordem' => 13,
                'texto' => 'O que é mais importante no relacionamento:',
                'opcoes' => [
                    'A' => 'Companheirismo',
                    'B' => 'Crescimento espiritual',
                    'C' => 'Estabilidade',
                    'D' => 'Conexão emocional',
                ],
            ],
            [
                'ordem' => 14,
                'texto' => 'Você pensa em relacionamento sério:',
                'opcoes' => [
                    'A' => 'Sim, em breve',
                    'B' => 'Sim, no tempo certo',
                    'C' => 'Talvez',
                    'D' => 'Não é prioridade',
                ],
            ],
            [
                'ordem' => 15,
                'texto' => 'Sua rotina ideal:',
                'opcoes' => [
                    'A' => 'Cheia',
                    'B' => 'Equilibrada',
                    'C' => 'Tranquila',
                    'D' => 'Variável',
                ],
            ],
            [
                'ordem' => 16,
                'texto' => 'Você gosta de atividades da igreja:',
                'opcoes' => [
                    'A' => 'Muito',
                    'B' => 'Com equilíbrio',
                    'C' => 'Ocasionalmente',
                    'D' => 'Pouco',
                ],
            ],
            [
                'ordem' => 17,
                'texto' => 'Sobre servir:',
                'opcoes' => [
                    'A' => 'Muito envolvido',
                    'B' => 'Às vezes',
                    'C' => 'Quero mais',
                    'D' => 'Não participo',
                ],
            ],
            [
                'ordem' => 18,
                'texto' => 'Em relacionamentos você:',
                'opcoes' => [
                    'A' => 'Se conecta fácil',
                    'B' => 'Equilibrado',
                    'C' => 'Receio',
                    'D' => 'Evita',
                ],
            ],
            [
                'ordem' => 19,
                'texto' => 'Espaço pessoal:',
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
