<?php

namespace App\Services;

use App\Models\Delegado;

class DelegadoService
{
    public function createDelegado(array $data)
    {
        Delegado::create($data);
    }

    public function updateDelegado(string $id, array $data)
    {
        if (is_string($data['cargo'])) {
            $data['cargo'] = null;
        }

        Delegado::find($id)->update($data);
    }

    public function deleteDelegado(string $id)
    {
        Delegado::find($id)->delete();
    }
}