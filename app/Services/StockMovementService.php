<?php


namespace App\Services;


use App\Models\Product;
use App\Models\StockMovement;
use Illuminate\Support\Facades\DB;

class StockMovementService
{
    public function processEntries(array $entries, bool $checkIn)
    {
        $skus = array_column($entries, 'sku');

        $products = Product::whereIn('sku', $skus)->get();
        /** @var Product[] $productsMap */
        $productsMap = $products->mapWithKeys(function ($item) {
            return [$item['sku'] => $item];
        });;

        if (!$checkIn) {
            foreach ($entries as $entry) {
                $product = $productsMap[$entry['sku']];

                if ($entry['quantity'] > $product->quantity) {
                    throw new \Exception("quantity for SKU '{$product->sku}' need to be lesser or equals than product quantity in stock");
                }
            }
        }

        DB::transaction(function() use ($entries, $productsMap, $checkIn) {
            foreach ($entries as $entry) {
                $product = $productsMap[$entry['sku']];

                if ($checkIn) {
                    $product->quantity += $entry['quantity'];
                } else {
                    $product->quantity -= $entry['quantity'];
                }

                $product->save();

                $movement = new StockMovement($entry);
                $movement->system = 'admin';
                $movement->in = $checkIn;
                $movement->product()->associate($product);
                $movement->save();
            }
        });

        return $products;
    }
}
