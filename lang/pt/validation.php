<?php

return [
    'messages' => [
        'required' => 'O campo :field é obrigatório.',
        'string' => 'O campo :field deve ser uma string.',
        'min' => 'O campo :field deve ter no mínimo :min caracteres.',
        'max' => 'O campo :field deve ter no máximo :max caracteres.',
        'integer' => 'O campo :field deve ser um número inteiro.',
        'in' => 'O campo :field deve ser uma das opções válidas.',
        'regex' => 'O campo :field contém caracteres inválidos.',
        'record_not_found' => 'Registro não encontrado.',
        'unique' => 'O :field já existe, por favor escolha outro nome.',
        'player_already_confirmed' => 'Este jogador já está confirmado para esta sessão.',
        'session_has_no_players' => 'Nenhum jogador está associado a esta sessão. É necessário ao menos um jogador confirmado.',
        'insufficient_players' => 'São necessários ao menos 1 jogador da classe :class para cada guilda.',
        'minimum_players_per_guild' => 'São necessários ao menos 3 jogadores para formar uma guilda.',
        'players_per_guild_exceeds_total' => 'O número de jogadores por guilda (:playersPerGuild) não pode ser maior que o total de jogadores disponíveis (:totalPlayers).',
        'player_not_found_in_session' => 'O jogador :player nao está associado a sessão.',
    ],
];
