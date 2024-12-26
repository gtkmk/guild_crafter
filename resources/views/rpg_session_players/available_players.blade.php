@extends('layouts.app')

@section('title', 'Jogadores Disponíveis para a Sessão')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3">Jogadores ainda não confirmados para essa sessão</h1>
        <a href="{{ route('rpg-sessions.index') }}" class="btn btn-secondary">Voltar para a lista</a>
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
            @forelse ($notConfirmedPlayers as $player)
                <tr>
                    <td>{{ $player->name }}</td>
                    <td>{{ $player->class }}</td>
                    <td>{{ $player->xp }}</td>
                    <td>
                        <form action="{{ route('rpg-session-players.confirm', ['id' => $rpgSessionId, 'playerId' => $player->id]) }}" method="POST" style="display:inline-block;">
                            @csrf
                            <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('Tem certeza que deseja confirmar a presença deste jogador na sessão?')">Confirmar Presença</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">Nenhum jogador disponível para a sessão.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $notConfirmedPlayers->links() }}
@endsection
