<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// IMPORT MODELS
use App\Models\Cidade;

class CidadeController extends Controller
{
    /**
     * Return all cities.
     */
    public function getAllCidades()
    {
        try {
            $cidades = Cidade::all();
            return response()->json($cidades, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao listar as cidades'], 500);
        }
    }

    /**
     * Return someone city by id.
     */
    public function getCidadeById($id)
    {
        try {
            $cidade = Cidade::findOrFail($id);
            return response()->json($cidade, 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'Cidade não encontrada'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao buscar a cidade'], 500);
        }
    }

    /**
     * Register a new city.
     */
    public function registerCidade(Request $request)
    {
        try {
            $validated = $request->validate([
                'nomeCidade' => 'required|string|unique:cidade',
            ]);

            $cidade = Cidade::create($validated);
            return response()->json($cidade, 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 400);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao cadastrar a cidade'], 500);
        }
    }

    /**
     * Update someone city by id.
     */
    public function updateCidadeById(Request $request, $id)
    {
        try {
            $cidade = Cidade::findOrFail($id);

            $validated = $request->validate([
                'nomeCidade' => 'required|string|unique:cidade',
            ]);

            $cidade->update($validated);
            return response()->json($cidade, 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['error' => $e->errors()], 400);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'Cidade não encontrada'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao atualizar a cidade'], 500);
        }
    }

    /**
     * Delete someone city by id.
     */
    public function deleteCidadeById($id)
    {
        try {
            $cidade = Cidade::findOrFail($id);
            $cidade->delete();
            return response()->noContent();
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'Cidade não encontrada'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao deletar a cidade'], 500);
        }
    }
}
