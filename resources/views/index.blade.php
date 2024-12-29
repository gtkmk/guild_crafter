@extends('layouts.app')

@section('title', 'Guild Crafter')

@section('content')
    <div class="container mt-5">
        <h1 class="display-4">Guild Crafter</h1>
        <p class="lead">Sistema de Gerenciamento de Guildas</p>

        <div class="row mt-5">
            <div class="col-md-6">
                <a href="{{ route('players.index') }}" class="btn btn-primary btn-lg btn-block">Gerenciar Jogadores</a>
            </div>
            <div class="col-md-6">
            <a href="{{ route('rpg-sessions.index') }}" class="btn btn-success btn-lg btn-block">Gerenciar Sessões</a>
            </div>
        </div>

        <div class="mt-5"></div>

        <div class="card bg-secondary mb-5">
            <div class="card-body">
                <h2>Organizar Jogadores por Classe e XP</h2>
                <p>O sistema de gerenciamento de sessões de RPG permite organizar guildas balanceadas por classe e XP para jogadores.</p>
                <p>Os jogadores podem ser cadastrados com suas respectivas classes (Guerreiro, Mago, Arqueiro e Clérigo) e nível de XP.</p>
                <p>O sistema busca equilibrar o total de pontos de XP de cada grupo para garantir que uma guilda não tenha uma vantagem significativa em experiência sobre a outra.</p>
                <p>O algoritmo desenvolvido garante que cada guilda tenha a composição mínima de classes necessária entre as guildas. Isso garante que o enfrentamento seja mais justo, tornando a sessão de RPG mais produtiva.</p>
                <br>
                <h2>Desafios Enfrentados</h2>
                <p><strong>Relembrar sobre a Estrutura de um Projeto Laravel - </strong>A o iniciar o projeto, percebi que precisava relembrar sobre a estrutura de um projeto Laravel. Isso incluiu entender como funcionam os bons padrões para desenvolver os controllers, models, views e rotas, além de como utilizar os recursos do framework para criar uma aplicação robusta.</p>
                <p><strong>Algoritimo de Balanceamento - </strong>Outro desafio foi desenvolver um algoritmo de balanceamento que distribuísse os jogadores de forma justa e equilibrada entre as guildas. Para isso, utilizei o algoritmo Greedy, que se mostrou eficaz na distribuição, embora não garanta uma solução ótima. A possibilidade de o usuário escolher o número de jogadores por guilda adicionou uma complexidade extra, mas consegui adaptar o algoritmo para lidar com essa restrição, garantindo um balanceamento eficiente entre as guildas com base em XP e classe.</p>
                <p><strong>Tempo - </strong>O oponente principal ao meu ver. Os feriados e as festas de fim de ano garantiram que o prazo que já era apertado, ficasse ainda mais apertado. De qualquer forma, embora tenha muitos pontos de melhorias eu gostei do que entreguei com o tempo que tive.</p>
                <p>No geral, foi um desafio interessante. Deu para reaprender e aprender muitas coisas novas. Teve momentos em que eu realmente precisei cavar lá no fundo do cérebro, resgatando as aulas de algoritmo da faculdade, que se mostraram mais úteis do que eu imaginava. Obviamente, também tive que fazer algumas pesquisas, mas ter o conhecimento teórico já ajudou muito. </p>
                <p>De certo modo, foi divertido! Fazia tempo que não precisava ficar desenhando para entender algo, e confesso que encarei isso como um desafio pessoal.</p>
            </div>
        </div>
    </div>
@endsection