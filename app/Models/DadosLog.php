<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class DadosLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'estado', 'acidente', 'logs_id'
    ];

    public function log() {
        return $this->belogsTo('App\Models\Log', 'logs_id');
    }
}
