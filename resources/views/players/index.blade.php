@extends('layouts.app')

@section('title', 'Lista de Jogadores')

@section('content')
    <a href="{{ route('players.create') }}">Criar novo player</a>

    <table>
        <thead>
            <tr>
                <th>Nome</th>
                <th>Classe</th>
                <th>Experiência</th>
                <th>Açõees</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($players as $player)
                <tr>
                    <td>{{ $player->name }}</td>
                    <td>{{ $player->class }}</td>
                    <td>{{ $player->xp }}</td>
                    <td> - </td>
                </tr>
            @empty
                <tr>
                    <td>Vazio</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $players->links() }}
@endsection