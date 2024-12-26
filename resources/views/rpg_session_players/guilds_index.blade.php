@extends('layouts.app')

@section('title', 'Jogadores por Guilda')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3">Jogadores por Guilda</h1>
    </div>

    <!-- Tabela para jogadores sem guilda -->
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

    <!-- Tabelas das guildas lado a lado -->
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
