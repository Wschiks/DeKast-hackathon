<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Toegangspoging extends Model
{
    use HasFactory;

    protected $table = 'toegangspogingen';

    protected $fillable = [
        'sporter_id',
        'tijdstip',
        'toegestaan',
        'foutmelding',
    ];

    protected $casts = [
        'tijdstip' => 'datetime',
        'toegestaan' => 'boolean',
    ];

    public function sporter(): BelongsTo
    {
        return $this->belongsTo(Sporter::class);
    }
}
