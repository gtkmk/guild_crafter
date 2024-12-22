<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class GuildPlayer extends Model
{
    protected $table = 'guild_player';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['guild_id', 'player_id'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->getKey()) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }
}
