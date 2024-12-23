<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Player extends Model
{
    use HasFactory; 

    protected $table = 'players';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['name', 'class', 'xp'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->getKey()) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }

    public function guilds()
    {
        return $this->belongsToMany(Guild::class, 'guild_player', 'player_id', 'guild_id');
    }
}
