<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\StockMovement;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class StockMovementController extends Controller
{
    public function checkIn(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'products' => 'required|array',
            'products.*.sku' => 'required|string|distinct|exists:products,sku',
            'products.*.quantity' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => array_values($validator->errors()->toArray()),
            ], 400);
        }

        $skus = array_column($request->products, 'sku');
        /** @var Product[] $productsMap */
        $productsMap = Product::whereIn('sku', $skus)->get()->mapWithKeys(function ($item) {
            return [$item['sku'] => $item];
        });;

        try {
            DB::transaction(function() use ($request, $productsMap) {
                foreach ($request->products as $value) {
                    $product = $productsMap[$value['sku']];

                    $product->quantity += $value['quantity'];
                    $product->save();

                    $movement = new StockMovement($value);
                    $movement->system = 'admin';
                    $movement->in = true;
                    $movement->product()->associate($product);
                    $movement->save();
                }
            });
        } catch (\Throwable $exception) {
            return response()->json([
                'errors' => [$exception->getMessage()],
            ], 400);
        }

        $products = Product::whereIn('sku', $skus)->get();

        return response()->json([
            'products' => $products
        ]);
    }

    public function checkOut(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'products' => 'required|array',
            'products.*.sku' => 'required|string|distinct|exists:products,sku',
            'products.*.quantity' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => array_values($validator->errors()->toArray()),
            ], 400);
        }

        $skus = array_column($request->products, 'sku');
        /** @var Product[] $productsMap */
        $productsMap = Product::whereIn('sku', $skus)->get()->mapWithKeys(function ($item) {
            return [$item['sku'] => $item];
        });;

        try {
            DB::transaction(function() use ($request, $productsMap) {
                foreach ($request->products as $value) {
                    $product = $productsMap[$value['sku']];

                    if ($value['quantity'] > $product->quantity) {
                        throw new \Exception("quantity for SKU '{$product->sku}' need to be lesser or equals than product quantity in stock");
                    }

                    $product->quantity -= $value['quantity'];
                    $product->save();

                    $movement = new StockMovement($value);
                    $movement->system = 'admin';
                    $movement->in = false;
                    $movement->product()->associate($product);
                    $movement->save();
                }
            });
        } catch (\Throwable $exception) {
            return response()->json([
                'errors' => [$exception->getMessage()],
            ], 400);
        }

        $products = Product::whereIn('sku', $skus)->get();

        return response()->json([
            'products' => $products
        ]);
    }
}
