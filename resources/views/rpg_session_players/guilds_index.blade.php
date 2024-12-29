@extends('layouts.app')

@section('title', 'Jogadores por Guilda')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3">Montagem de Guildas</h1>
        <a href="{{ route('rpg-sessions.index') }}" class="btn btn-primary">Voltar para a lista</a>
    </div>

    <form method="POST" action="{{ route('rpg-session-players.assign_guilds', $rpgSessionId) }}" class="mb-5">
        @csrf
        <div class="text-center">
            <p>
                Dependendo do número de jogadores por guilda, se não for possível criar duas guildas com um número igual de jogadores, apenas uma será formada. Caso o número de jogadores por guilda seja suficiente, serão criadas duas guildas, e cada uma deverá conter um guerreiro, um clérigo, e um mago ou arqueiro (dano a distância).
            </p>
            <div class="form-group">
                <label for="playersPerGuild">Número de jogadores por guilda:</label>
                <input 
                    type="number" 
                    id="playersPerGuild"
                    name="playersPerGuild" 
                    class="form-control w-50 mx-auto" 
                    min="3" 
                    required 
                    placeholder="Digite o número de jogadores por guilda">
            </div>
            <button type="submit" class="btn btn-success mt-3">Balancear Guildas</button>
        </div>
    </form>

    @if ($guildPlayerGroups->has('no_guild'))
        <div class="mb-5 text-center">
            <h2 class="text-danger">Sem Guilda</h2>
            <table class="table table-striped table-hover mx-auto" style="max-width: 600px;">
                <thead class="thead-dark">
                    <tr>
                        <th>Nome</th>
                        <th>Classe</th>
                        <th>XP</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($guildPlayerGroups['no_guild'] as $sessionPlayer)
                        @php
                            $player = $sessionPlayer->player;
                        @endphp
                        <tr>
                            <td>{{ $player->name }}</td>
                            <td>{{ $player->class }}</td>
                            <td>{{ $player->xp }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">Nenhum jogador encontrado.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    @endif

    <div class="row">
        @foreach ($guildPlayerGroups as $guild => $players)
            @if ($guild !== 'no_guild')
                <div class="col-md-6 mb-4">
                    <h2>Guilda {{ $guild }}</h2>
                    <table class="table table-striped table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th>Nome</th>
                                <th>Classe</th>
                                <th>XP</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($players as $sessionPlayer)
                                @php
                                    $player = $sessionPlayer->player;
                                @endphp
                                <tr>
                                    <td>{{ $player->name }}</td>
                                    <td>{{ $player->class }}</td>
                                    <td>{{ $player->xp }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">Nenhum jogador encontrado.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            @endif
        @endforeach
    </div>
@endsection
