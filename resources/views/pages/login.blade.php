@extends('layouts.public')

@section('page')
    <form method="post" enctype="multipart/form-data" action="/login" class="lg:w-1/3 flex flex-col gap-6 bg-white p-6 rounded">
        @csrf

        <div class="">
            <h1 class="text-3xl">Controle de Estoque</h1>
        </div>

        <div class="flex flex-col gap-1">
            <label for="email">E-mail</label>
            <input id="email" name="email" type="email" class="border rounded p-1 bg-gray-100">
        </div>

        <div class="flex flex-col gap-1">
            <label for="password">Senha</label>
            <input id="password" name="password" type="password" class="border rounded p-1 bg-gray-100">
        </div>

        <div>
            <button type="submit" class="border rounded bg-blue-800 hover:bg-blue-900 text-white text-lg px-6 py-1">Entrar</button>
        </div>
    </form>
@endsection
