<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Daftar extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function pasien(): BelongsTo
    {
        return $this->belongsTo(Pasien::class)->withDefault();
    }
    public function poli(): BelongsTo
    {
        return $this->belongsTo(Poli::class)->withDefault();
    }
}