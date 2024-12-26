<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquente\Relations\BelongsTo;
class Character extends Model
{
    protected $fillable = [
        'name',
        'chronicle',
        'intelligence',
        'charisma',
        'wisdom',
        'strength',
        'dexterity',
        'constitution',
        'user_id'
    ];

    protected $casts = [
        'intelligence' => 'integer',
        'charisma'  => 'intenger',
        'wisdom'    => 'integer',
        'strength'  => 'integer',
        'dexterity' => 'integer',
        'constitution'  => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
