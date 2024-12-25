@extends('layouts.app')

@section('title', 'Criar Novo Jogador')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3">Criar Jogador</h1>
        <a href="{{ route('players.index') }}" class="btn btn-secondary">Voltar para a lista</a>
    </div>

    <form action="{{ route('players.store') }}" method="POST">
        @csrf()

        <div class="row mb-3">
            <div class="col-md-4">
                <label for="name" class="form-label">Nome do Jogador</label>
                <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}">
            </div>

            <div class="col-md-4">
                <label for="class" class="form-label">Classe do Jogador</label>
                <select id="class" name="class" class="form-select">
                    <option value="" disabled selected>Selecione a Classe</option>
                    <option value="warrior" {{ old('class') == 'warrior' ? 'selected' : '' }}>Guerreiro</option>
                    <option value="mage" {{ old('class') == 'mage' ? 'selected' : '' }}>Mago</option>
                    <option value="archer" {{ old('class') == 'archer' ? 'selected' : '' }}>Arqueiro</option>
                    <option value="cleric" {{ old('class') == 'cleric' ? 'selected' : '' }}>Clérigo</option>
                </select>
            </div>

            <div class="col-md-4">
                <label for="xp" class="form-label">Nível do Jogador (0 a 100)</label>
                <input type="number" id="xp" name="xp" class="form-control" value="{{ old('xp') }}" min="0" max="100">
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Criar</button>
    </form>
@endsection
