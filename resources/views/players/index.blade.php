@extends('layouts.app')

@section('title', 'Lista de Jogadores')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3">Lista de Jogadores</h1>
        <a href="{{ route('players.create') }}" class="btn btn-primary">Criar novo jogador</a>
    </div>

    <table class="table table-striped table-hover">
        <thead class="thead-dark">
            <tr>
                <th>Nome</th>
                <th>Classe</th>
                <th>Experiência</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($players as $player)
                <tr>
                    <td>{{ $player->name }}</td>
                    <td>{{ $player->class }}</td>
                    <td>{{ $player->xp }}</td>
                    <td>
                        <a href="{{ route('players.edit', $player->id) }}" class="btn btn-primary btn-sm">Editar</a>
                        <form action="{{ route('players.destroy', $player->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja excluir este jogador?')">Deletar</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">Nenhum jogador encontrado.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $players->links() }}
@endsection
