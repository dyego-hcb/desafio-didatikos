<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Marca extends Model
{
    use HasFactory;

    protected $table = 'marca';
    protected $primaryKey = 'codMarca';
    protected $fillable = ['nomeMarca', 'fabricante'];

    public function produtos()
    {
        return $this->hasMany(Produto::class, 'codMarca', 'marcaProduto');
    }
}
