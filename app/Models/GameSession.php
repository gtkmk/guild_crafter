<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class GameSession extends Model
{
    protected $table = 'game_sessions';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['date', 'status'];

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
        return $this->hasMany(Guild::class);
    }
}
