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

    protected static function getClassTranslationMap(): array
    {
        return [
            'warrior' => 'Guerreiro',
            'mage' => 'Mago',
            'archer' => 'Arqueiro',
            'cleric' => 'Clérigo',
        ];
    }

    private function getTranslatedClass(): string
    {
        $classMap = self::getClassTranslationMap();
        return $classMap[$this->class] ?? $this->class;
    }

    public static function translatePlayerClasses($players): void
    {
        foreach ($players as $player) {
            $player->class = $player->getTranslatedClass();
        }
    }
}
