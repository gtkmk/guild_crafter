@extends('layouts.app')

@section('title', 'Lista de Sessões de RPG')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3">Lista de Sessões de RPG</h1>
        <a href="#" class="btn btn-primary">Criar nova sessão</a>
        <!-- href="route('rpg_sessions.create')" -->
        <!-- href="route('rpg_sessions.edit', $rpgSession->id)" -->
        <!-- href="route('rpg_sessions.edit', $rpgSession->id) -->
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
                    <td>{{ \Carbon\Carbon::parse($rpgSession->campaign_date)->format('d/m/Y') }}</td>
                    <td>
                        <a href="#" class="btn btn-primary btn-sm">Confirmar Jogadores</a>
                        <a href="#" class="btn btn-primary btn-sm">Montar Guildas</a>
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
