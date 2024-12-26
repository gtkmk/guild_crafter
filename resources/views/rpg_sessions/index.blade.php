@extends('layouts.app')

@section('title', 'Lista de Sessões de RPG')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3">Lista de Sessões de RPG</h1>
        <a href="{{ route('rpg-sessions.create') }}" class="btn btn-primary">Criar nova sessão</a>
        <!-- href="route('rpg-sessions.create')" -->
        <!-- href="route('rpg-sessions.edit', $rpgSession->id)" -->
        <!-- href="route('rpg-sessions.edit', $rpgSession->id) -->
    </div>

    <table class="table table-striped table-hover">
        <thead class="thead-dark">
            <tr>
                <th>Nome</th>
                <th>Data da Campanha</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($rpgSessions as $rpgSession)
                <tr>
                    <td>{{ $rpgSession->name }}</td>
                    <td>{{ $rpgSession->campaign_date }}</td>
                    <td>
                        <a href="{{ route('rpg-session-players.available_players', ['id' => $rpgSession->id]) }}" class="btn btn-primary btn-sm">Confirmar Jogadores</a>
                        <a href="{{ route('rpg-session-players.guilds', ['id' => $rpgSession->id]) }}" class="btn btn-primary btn-sm">Montar Guildas</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="text-center">Nenhuma sessão encontrada.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $rpgSessions->links() }}
@endsection
