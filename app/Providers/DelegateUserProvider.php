<?php

namespace App\Providers;

use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Contracts\Auth\Authenticatable;
use App\Models\Delegado;
use App\Models\Reuniao;

class DelegateUserProvider implements UserProvider
{
    public function retrieveById($identifier)
    {
        return Delegado::find($identifier);
    }

    public function retrieveByToken($identifier, $token)
    {
        // Esta funcionalidade não será usada, mas precisa ser implementada.
        return null;
    }

    public function updateRememberToken(Authenticatable $user, $token)
    {
        // Esta funcionalidade não será usada, mas precisa ser implementada.
    }

    public function retrieveByCredentials(array $credentials)
    {
        // A lógica de busca do usuário (delegado) é feita aqui.
        if (empty($credentials['cpf']) || empty($credentials['codigo'])) {
            return null;
        }

        $reuniao = Reuniao::withoutGlobalScopes(['reuniao_ativa', 'tenant'])
            ->where('codigo', $credentials['codigo'])
            ->where('status', true)
            ->first();

        if (!$reuniao) {
            return null;
        }

        return Delegado::withoutGlobalScopes(['reuniao_ativa', 'tenant'])
            ->where('cpf', $credentials['cpf'])
            ->where('reuniao_id', $reuniao->id)
            ->where('tenant_id', $reuniao->tenant_id)
            ->first();
    }

    public function validateCredentials(Authenticatable $user, array $credentials)
    {
        // Como o login é apenas pelo CPF, não há senha para validar.
        // A validação já foi feita na busca por credenciais.
        return true;
    }
}