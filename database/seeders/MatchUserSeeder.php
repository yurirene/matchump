<?php

namespace Database\Seeders;

use App\Models\MatchResposta;
use App\Models\MatchUser;
use App\Models\Pergunta;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class MatchUserSeeder extends Seeder
{
    public function run(): void
    {
        $perguntas = Pergunta::query()->orderBy('ordem')->get();
        if ($perguntas->isEmpty()) {
            return;
        }

        foreach (range(1, 25) as $i) {
            $birth = fake()->dateTimeBetween('-35 years', '-21 years')->format('Y-m-d');

            $user = MatchUser::query()->create([
                'name' => fake()->name(),
                'email' => fake()->unique()->safeEmail(),
                'password' => 'password',
                'birth_date' => $birth,
                'sexo' => fake()->randomElement(['masculino', 'feminino']),
                'avatar_path' => null,
            ]);

            foreach ($perguntas as $p) {
                $keys = array_keys($p->opcoes);
                $letras = array_values(array_filter($keys, fn ($k) => is_string($k) && strlen($k) === 1));
                $alt = Arr::random($letras);

                MatchResposta::query()->create([
                    'match_user_id' => $user->id,
                    'pergunta_id' => $p->id,
                    'alternativa' => $alt,
                ]);
            }
        }
    }
}
