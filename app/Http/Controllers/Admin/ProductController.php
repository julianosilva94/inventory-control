<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index()
    {
        return view('pages.admin.products.list');
    }

    public function getAll()
    {
        return response()->json([
            'products' => Product::all()
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validate($request, [
            'sku' => 'required|unique:products',
            'name' => 'required|max:190',
            'description' => 'present',
            'quantity' => 'required|min:0',
        ]);

        $product = new Product($data);
        $product->save();

        return response()->json(null, 201);
    }

    public function update(Request $request, Product $product)
    {
        $data = $this->validate($request, [
            'name' => 'required|max:190',
            'description' => 'present',
        ]);

        $product->fill($data);
        $product->save();

        return response()->json();
    }
}
