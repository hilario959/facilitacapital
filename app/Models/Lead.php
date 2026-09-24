<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;

class Lead extends Model
{
    public const STATUS_NEW = 'nuevo';

    public const STATUS_CONTACTED = 'contactado';

    public const STATUS_REVIEW = 'evaluacion';

    public const STATUS_APPROVED = 'aprobado';

    public const STATUS_DISCARDED = 'descartado';

    /** @var array<string, string> */
    public const STATUSES = [
        self::STATUS_NEW => 'Nuevo',
        self::STATUS_CONTACTED => 'Contactado',
        self::STATUS_REVIEW => 'En evaluación',
        self::STATUS_APPROVED => 'Aprobado',
        self::STATUS_DISCARDED => 'Descartado',
    ];

    protected $fillable = [
        'email',
        'whatsapp',
        'nit',
        'invoice_amount',
        'term_days',
        'advance_amount',
        'cost_amount',
        'payout_amount',
        'status',
        'position',
        'notes',
        'email_sent_at',
        'email_error',
    ];

    protected function casts(): array
    {
        return [
            'invoice_amount' => 'integer',
            'term_days' => 'integer',
            'advance_amount' => 'integer',
            'cost_amount' => 'integer',
            'payout_amount' => 'integer',
            'position' => 'integer',
            'email_sent_at' => 'datetime',
        ];
    }

    public function moveTo(string $status): void
    {
        if (! array_key_exists($status, self::STATUSES)) {
            throw new InvalidArgumentException('Estado de lead desconocido.');
        }

        $position = (int) static::query()->where('status', $status)->max('position') + 1;

        $this->update([
            'status' => $status,
            'position' => $position,
        ]);
    }

    public function statusLabel(): string
    {
        return self::STATUSES[$this->status] ?? $this->status;
    }
}
