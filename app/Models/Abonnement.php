<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Abonnement extends Model
{
    use HasFactory;

    protected $table = 'abonnementen';

    protected $fillable = [
        'type_naam',
        'max_bezoeken_per_week',
    ];

    public function sporters(): HasMany
    {
        return $this->hasMany(Sporter::class);
    }
}
