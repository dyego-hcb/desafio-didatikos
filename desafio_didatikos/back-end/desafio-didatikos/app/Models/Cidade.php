<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cidade extends Model
{
    use HasFactory;

    protected $table = 'cidade';
    protected $primaryKey = 'codCidade';
    protected $fillable = ['nomeCidade'];

    public function produtos()
    {
        return $this->hasMany(Produto::class, 'codCidade', 'cidade');
    }
}
