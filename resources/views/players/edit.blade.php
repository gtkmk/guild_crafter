@extends('layouts.app')

@section('title', 'Editar Jogador')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3">Editar Jogador</h1>
        <a href="{{ route('players.index') }}" class="btn btn-secondary">Voltar para a lista</a>
    </div>

    @if (session()->has('success'))
        <div id="success-alert" class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Sucesso!</strong> {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div id="error-alert" class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('players.update', $player->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row mb-3">
            <div class="col-md-4">
                <label for="name" class="form-label">Nome do Jogador</label>
                <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $player->name) }}" required>
            </div>

            <div class="col-md-4">
                <label for="class" class="form-label">Classe do Jogador</label>
                <select id="class" name="class" class="form-select" required>
                    <option value="" disabled>Selecione a Classe</option>
                    <option value="warrior" {{ old('class', $player->class) == 'warrior' ? 'selected' : '' }}>Guerreiro</option>
                    <option value="mage" {{ old('class', $player->class) == 'mage' ? 'selected' : '' }}>Mago</option>
                    <option value="archer" {{ old('class', $player->class) == 'archer' ? 'selected' : '' }}>Arqueiro</option>
                    <option value="cleric" {{ old('class', $player->class) == 'cleric' ? 'selected' : '' }}>Clérigo</option>
                </select>
            </div>

            <div class="col-md-4">
                <label for="xp" class="form-label">Nível do Jogador (0 a 100)</label>
                <input type="number" id="xp" name="xp" class="form-control" value="{{ old('xp', $player->xp) }}" min="0" max="100" required>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Editar</button>
    </form>
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
