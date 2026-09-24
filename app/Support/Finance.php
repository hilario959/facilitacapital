<?php

namespace App\Support;

class Finance
{
    public const ADVANCE_RATE = 0.9;

    public const MONTHLY_RATE = 0.02;

    public const DEFAULT_AMOUNT = 50000;

    public const MIN_AMOUNT = 10000;

    public const MAX_AMOUNT = 2000000;

    public const STEP = 5000;

    /** @var list<int> */
    public const TERMS = [30, 60, 90, 120];

    /**
     * @return array{amount: int, days: int, advance: int, cost: int, today: int, holdback: int}
     */
    public static function simulate(int $amount, int $days): array
    {
        $amount = max(0, $amount);
        $advance = (int) round($amount * self::ADVANCE_RATE);
        $cost = (int) round($advance * self::MONTHLY_RATE * ($days / 30));
        $today = max($advance - $cost, 0);
        $holdback = max($amount - $advance, 0);

        return [
            'amount' => $amount,
            'days' => $days,
            'advance' => $advance,
            'cost' => $cost,
            'today' => $today,
            'holdback' => $holdback,
        ];
    }

    public static function clamp(float|int $value): int
    {
        if (! is_numeric($value)) {
            return self::DEFAULT_AMOUNT;
        }

        return (int) min(self::MAX_AMOUNT, max(self::MIN_AMOUNT, round((float) $value)));
    }

    public static function money(float|int $value): string
    {
        return 'Q'.number_format((float) $value, 2, '.', ',');
    }
}
