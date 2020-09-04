<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\StockMovement;
use App\Services\StockMovementService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class StockMovementController extends Controller
{
    public function add(Request $request)
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

        $products = [];

        try {
            $checkIn = true;

            $service = new StockMovementService();
            $products = $service->processEntries($request->products, $checkIn);
        } catch (\Throwable $exception) {
            return response()->json([
                'errors' => [$exception->getMessage()],
            ], 400);
        }

        return response()->json(compact('products'));
    }

    public function remove(Request $request)
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

        $products = [];

        try {
            $checkIn = false;

            $service = new StockMovementService();
            $products = $service->processEntries($request->products, $checkIn);
        } catch (\Throwable $exception) {
            return response()->json([
                'errors' => [$exception->getMessage()],
            ], 400);
        }

        return response()->json(compact('products'));
    }
}
