@extends('layouts.app')

@section('title', 'Lista de Jogadores')

@section('content')
<h1>Criar novo jogador</h1>

@if ($errors->any())
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>        
        @endforeach
    </ul>

@endif

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
                <option value="guerreiro" {{ old('class') == 'guerreiro' ? 'selected' : '' }}>Guerreiro</option>
                <option value="mago" {{ old('class') == 'mago' ? 'selected' : '' }}>Mago</option>
                <option value="arqueiro" {{ old('class') == 'arqueiro' ? 'selected' : '' }}>Arqueiro</option>
                <option value="curandeiro" {{ old('class') == 'curandeiro' ? 'selected' : '' }}>Curandeiro</option>
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
