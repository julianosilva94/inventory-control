@extends('layouts.main')

@section('container')
    <header class="bg-blue-900 text-white flex justify-center h-20">
        <div class="container flex">
            <div class="h-full flex items-center">
                <span class="text-lg font-bold">Controle de Estoque</span>
            </div>
            <div class="ml-12 h-full items-center flex gap-x-6">
                <a href="{{ route('dashboard.index') }}">Dashboard</a>
                <a href="/produtos">Produtos</a>
            </div>
            <div class="ml-auto h-full items-center flex">
                <a href="/sair">Sair</a>
            </div>
        </div>
    </header>

    <main class="my-6 flex justify-center">
        @yield('page')
    </main>
@endsection
