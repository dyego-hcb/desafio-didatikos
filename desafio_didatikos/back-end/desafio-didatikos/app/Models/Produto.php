<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Produto extends Model
{
    use HasFactory;

    protected $table = 'produto';
    protected $primaryKey = 'codProduto';
    protected $fillable = ['nomeProduto', 'valorProduto', 'marcaProduto', 'estoque', 'cidade'];

    public function marca()
    {
        return $this->belongsTo(Marca::class, 'marcaProduto', 'codMarca');
    }

    public function cidade()
    {
        return $this->belongsTo(Cidade::class, 'cidade', 'codCidade');
    }
}
