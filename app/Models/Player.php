<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Player extends Model
{
    use HasFactory; 

    protected $table = 'player';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'name',
        'class',
        'xp',
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

    public function rpgSessionPlayers()
    {
        return $this->hasMany(RpgSessionPlayer::class, 'player_id', 'id');
    }

    private static function getClassTranslation(string $class): string
    {
        $classMap = [
            'warrior' => 'Guerreiro',
            'mage' => 'Mago',
            'archer' => 'Arqueiro',
            'cleric' => 'Clérigo',
        ];

        return $classMap[$class] ?? $class;
    }

    public static function translatePlayerClasses($players): array
    {
        return $players->map(function ($player) {
            $player->class = self::getClassTranslation($player->class);
            return $player;
        })->toArray();
    }

    public static function translateClass(string $class): string
    {
        return self::getClassTranslation($class);
    }

    public static function getClasses()
    {
        return ['cleric', 'warrior', 'mage', 'archer'];
    }
}
