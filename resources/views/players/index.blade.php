@extends('layouts.app')

@section('title', 'Lista de Jogadores')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3">Lista de Jogadores</h1>
        <a href="{{ route('players.create') }}" class="btn btn-primary">Criar novo jogador</a>
    </div>

    @if (session()->has('success'))
        <div id="success-alert" class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Sucesso!</strong> {{ session('success') }}
        </div>
    @endif

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

@section('scripts')
    <script>
        setTimeout(() => {
            const alert = document.getElementById('success-alert');
            if (alert) {
                alert.classList.remove('show');
                alert.classList.add('fade');
                setTimeout(() => alert.remove(), 150);
            }
        }, 3200);
    </script>
@endsection
