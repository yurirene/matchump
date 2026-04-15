<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AprovacaoAta extends Model
{
    use HasFactory;
    protected $guarded = ['id', 'created_at', 'updated_at'];
    protected $table = 'aprovacao_atas';

    public function ata()
    {
        return $this->belongsTo(Ata::class);
    }
    
}
