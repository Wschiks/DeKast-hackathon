<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Sporter extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'naam',
        'email',
        'barcode',
        'abonnement_id',
        'geannuleerd',
        'annuleringsdatum',
        'einddatum_toegang',
    ];

    protected $casts = [
        'geannuleerd' => 'boolean',
        'annuleringsdatum' => 'datetime',
        'einddatum_toegang' => 'datetime',
    ];

    // No password column, so nothing to check on this front — login is by barcode only.
    public function getAuthPassword()
    {
        return null;
    }

    public function abonnement(): BelongsTo
    {
        return $this->belongsTo(Abonnement::class);
    }

    public function toegangspogingen(): HasMany
    {
        return $this->hasMany(Toegangspoging::class);
    }
}
