<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Guild extends Model
{
    protected $table = 'guilds';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['name', 'max_players'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->getKey()) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }

    public function players()
    {
        return $this->belongsToMany(Player::class, 'guild_player', 'guild_id', 'player_id');
    }
}
