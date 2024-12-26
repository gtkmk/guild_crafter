<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;

class RpgSessionPlayer extends Model
{
    protected $table = 'rpg_session_player';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'assigned_guild',
        'rpg_session_id ',
        'player_id',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->getKey()) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }

    public function rpgSession(): HasOne
    {
        return $this->hasOne(RpgSession::class, 'id', 'rpg_session_id');
    }

    public function player()
    {
        return $this->belongsTo(Player::class, 'player_id', 'id');
    }

    public static function getRequiredClasses()
    {
        return ['warrior', 'mage', 'archer', 'cleric'];
    }
}
