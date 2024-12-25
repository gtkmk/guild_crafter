@extends('layouts.app')

@section('title', 'Criar Nova Sessão de RPG')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3">Criar Nova Sessão de RPG</h1>
        <a href="{{ route('rpg-sessions.index') }}" class="btn btn-secondary">Voltar para a lista</a>
    </div>

    <form action="{{ route('rpg-sessions.store') }}" method="POST">
        @csrf()

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="name" class="form-label">Nome da Sessão</label>
                <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}" required>
            </div>

            <div class="col-md-6">
                <label for="campaign_date" class="form-label">Data da Campanha</label>
                <input type="date" id="campaign_date" name="campaign_date" class="form-control" value="{{ old('campaign_date') }}" required>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Criar Sessão</button>
    </form>
@endsection
