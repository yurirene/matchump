<?php

namespace App\Models;

use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class MatchUser extends Authenticatable
{
    use HasFactory, Notifiable, UuidTrait;

    protected $table = 'match_users';

    protected $fillable = [
        'name',
        'email',
        'password',
        'birth_date',
        'sexo',
        'avatar_path',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'birth_date' => 'date',
        'password' => 'hashed',
    ];

    public function respostas(): HasMany
    {
        return $this->hasMany(MatchResposta::class, 'match_user_id');
    }

    public function discoveryInteractions(): HasMany
    {
        return $this->hasMany(DiscoveryInteraction::class, 'viewer_id');
    }

    public function age(): int
    {
        return $this->birth_date->age;
    }

    public function sexoLabel(): string
    {
        return match ($this->sexo) {
            'feminino' => 'Feminino',
            'masculino' => 'Masculino',
            default => '—',
        };
    }
}
