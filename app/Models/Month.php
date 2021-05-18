<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Month extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome', 'consumption_months_id',
    ];

    public function consumption() {
    	return $this->hasOne('App\Models\ConsumptionMonth', 'id');
    }
}
