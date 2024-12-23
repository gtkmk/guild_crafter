@extends('layouts.app')

@section('title', 'Lista de Jogadores')

@section('content')
<h1>Criar novo jogador</h1>

<form action="{{ route('players.store') }}" method="POST">
    <input type="hidden" name="_token" value=" {{ csrf_token() }}">

    <input type="text" name="name" placeholder="Nome do jogador">
    <input type="text" name="class" placeholder="Classe do jogador">
    <input type="int" name="xp" placeholder="Nível do jogador">
    <button type="submit">Criar</button>    
</form>
@endsection
