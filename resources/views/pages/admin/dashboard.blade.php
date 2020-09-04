@extends('layouts.admin')

@section('page')
    <div class="container">
        <stock-manager></stock-manager>
        @if (count($productsWithLowStock) > 0)
        <h2 class="my-6 text-2xl font-semibold text-red-700 dark:text-red-200">
            Produtos com estoque baixo
        </h2>
        <div class="w-full overflow-hidden rounded shadow-xs">
            <div class="w-full overflow-x-auto">
                <table class="w-full whitespace-no-wrap">
                    <thead>
                    <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                        <th class="px-4 py-3">Produto</th>
                        <th class="px-4 py-3">Quantidade</th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                    @foreach ($productsWithLowStock as $product)
                        <tr class="text-gray-700 dark:text-gray-400">
                            <td class="px-4 py-3">
                                <div class="flex items-center text-sm">
                                    <div>
                                        <p class="font-semibold">{{ $product->name }}</p>
                                        <p class="text-xs text-gray-600 dark:text-gray-400">
                                            SKU {{ $product->name }}
                                        </p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-sm text-red-700">
                                {{ $product->quantity }}
                            </td>
                        </tr>
                        @endforeach
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        @endif
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            Movimentações do dia
        </h2>
        <div class="w-full overflow-hidden rounded shadow-xs">
            <div class="w-full overflow-x-auto">
                <table class="w-full whitespace-no-wrap">
                    <thead>
                    <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                        <th class="px-2 py-3"></th>
                        <th class="px-4 py-3">Produto</th>
                        <th class="px-4 py-3">Quantidade</th>
                        <th class="px-4 py-3">Horário</th>
                        <th class="px-4 py-3">Via</th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                        @foreach ($movements as $movement)
                            <tr class="text-gray-700 dark:text-gray-400">
                                <td class="px-4 py-3 text-xs">
                                    @if ($movement->in)
                                        <span class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100">
                                          Entrada
                                        </span>
                                    @else
                                        <span class="px-2 py-1 font-semibold leading-tight text-red-700 bg-red-100 rounded-full dark:bg-red-700 dark:text-red-100">
                                          Baixa
                                        </span>
                                    @endif

                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center text-sm">
                                        <div>
                                            <p class="font-semibold">{{ $movement->product->name }}</p>
                                            <p class="text-xs text-gray-600 dark:text-gray-400">
                                                SKU {{ $movement->product->name }}
                                            </p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    {{ $movement->quantity }}
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    {{ $movement->created_at->format('H:m:s') }}
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    {{ $movement->system }}
                                </td>
                            </tr>
                        @endforeach
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
