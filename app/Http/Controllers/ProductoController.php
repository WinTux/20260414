<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use Illuminate\Support\Facades\Log;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Log::info('Listando los productos');
        return Producto::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
          'nombre' => 'required|string',
          'precio' => 'required|numeric' 
        ]);
        $producto = Producto::create($request->only('nombre','precio'));
        Log::info('Producto creado', $producto->toArray());
        return response()->json($producto, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        Log::info('Mostrando el producto $id');
        return Producto::findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $producto = Producto::findOrFail($id);
        $producto->update($request->all());
        Log::warning('Producto actualizado', $producto->toArray());
        return $producto;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Producto::destroy($id);
        Log::error("Producto eliminado: $id");
        return response()->json(['ok' => true]);
    }
}
