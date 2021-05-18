<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConsumptionMonth extends Model
{
    use HasFactory;

    protected $fillable = [
        'consumo', 'valor',
    ];

    public function month() {
    	return $this->belongsTo('App\Models\Month');
    }
}
