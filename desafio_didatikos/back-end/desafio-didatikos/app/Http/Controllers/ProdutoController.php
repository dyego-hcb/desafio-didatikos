<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// IMPORT MODELS
use App\Models\Produto;

class ProdutoController extends Controller
{
    /**
     * Return all products
     */
    public function getAllProdutos()
    {
        try {
            $produtos = Produto::all();
            return response()->json($produtos, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao listar os produtos'], 500);
        }
    }

    /**
     * Return someone product by id
     */
    public function getProdutoById($id)
    {
        try {
            $produto = Produto::findOrFail($id);
            return response()->json($produto, 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'Produto não encontrado'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao buscar o produto'], 500);
        }
    }

    /**
     * Register a new product
     */
    public function registerProduto(Request $request)
    {
        try {
            $validated = $request->validate([
                'nomeProduto' => 'required|unique:produto',
                'valorProduto' => 'required|numeric',
                'marcaProduto' => 'required|exists:marca,codMarca',
                'estoque' => 'required|numeric',
                'cidade' => 'required|exists:cidade,codCidade',
            ]);

            $produto = Produto::create($validated);
            return response()->json($produto, 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 400);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao cadastrar o produto'], 500);
        }
    }

    /**
     * Update someone product by id
     */
    public function updateProdutoById(Request $request, $id)
    {
        try {
            $produto = Produto::findOrFail($id);

            $validated = $request->validate([
                'nomeProduto' => 'required|unique:produto,nomeProduto,' . $id . ',codProduto',
                'valorProduto' => 'required|numeric',
                'marcaProduto' => 'required|exists:marca,codMarca',
                'estoque' => 'required|numeric',
                'cidade' => 'required|exists:cidade,codCidade',
            ]);

            $produto->update($validated);
            return response()->json($produto, 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['error' => $e->errors()], 400);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'Produto não encontrado'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao atualizar o produto'], 500);
        }
    }

    /**
     * Delete someone product by id
     */
    public function deleteProdutoById($id)
    {
        try {
            $produto = Produto::findOrFail($id);
            $produto->delete();
            return response()->noContent();
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'Produto não encontrado'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao deletar o produto'], 500);
        }
    }
}
