<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property User $user
 * @property Vehicle $vehicle
 * @property Zone $zone
 * @property Carbon $start_at
 * @property Carbon|null $stop_at
 * @property int|null $total_price
 */
class Parking extends Model
{
    use HasFactory;

    protected $fillable  = ['user_id', 'vehicle_id', 'zone_id', 'start_at', 'stop_at', 'total_price'];

    protected $casts = [
        'start_at' => 'datetime',
        'stop_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function zone(): BelongsTo
    {
        return $this->belongsTo(Zone::class);
    }

    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->whereNull('stop_at');
    }

    public function scopeStopped(Builder $query): Builder
    {
        return $query->whereNotNull('stop_at');
    }

    protected static function booted(): void
    {
        static::addGlobalScope('user', function (Builder $builder) {
            $builder->where('user_id', auth()->id());
        });
    }
}
