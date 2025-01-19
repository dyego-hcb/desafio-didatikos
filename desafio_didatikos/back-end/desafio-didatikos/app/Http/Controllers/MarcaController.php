<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// IMPORT MODELS
use App\Models\Marca;

class MarcaController extends Controller
{
    /**
     * Return all branchs 
     */
    public function getAllMarcas()
    {
        try {
            $marcas = Marca::all();
            return response()->json($marcas, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao listar as marcas'], 500);
        }
    }

    /**
     * Return someone branch by id
     */
    public function getMarcaById($id)
    {
        try {
            $marca = Marca::findOrFail($id);
            return response()->json($marca, 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'Marca não encontrada'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao buscar a marca'], 500);
        }
    }

    /**
     * Register a new branch
     */
    public function registerMarca(Request $request)
    {
        try {
            $validated = $request->validate([
                'nomeMarca' => 'required|string|unique:marca',
                'fabricante' => 'required|string',
            ]);

            $marca = Marca::create($validated);
            return response()->json($marca, 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 400);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao cadastrar a marca'], 500);
        }
    }

    /**
     * Update someone branch by id
     */
    public function updateMarcaById(Request $request, $id)
    {
        try {
            $marca = Marca::findOrFail($id);

            $validated = $request->validate([
                'nomeMarca' => 'required|string|unique:marca',
                'fabricante' => 'required|string',
            ]);

            $marca->update($validated);
            return response()->json($marca, 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['error' => $e->errors()], 400);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'Marca não encontrada'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao atualizar a marca'], 500);
        }
    }

    /**
     * Delete someone branch by id
     */
    public function deleteMarcaById($id)
    {
        try {
            $marca = Marca::findOrFail($id);
            $marca->delete();
            return response()->noContent();
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'Marca não encontrada'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao deletar a marca'], 500);
        }
    }
}
