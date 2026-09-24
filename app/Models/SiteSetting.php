<?php

namespace App\Models;

use App\Support\SiteContent;
use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    protected $fillable = [
        'data',
    ];

    protected function casts(): array
    {
        return [
            'data' => 'array',
        ];
    }

    public static function current(): self
    {
        $setting = static::query()->first();

        if ($setting) {
            return $setting;
        }

        SiteContent::ensureImages();

        return static::query()->create([
            'data' => SiteContent::defaults(),
        ]);
    }

    /**
     * @return array<string, mixed>
     */
    public static function content(): array
    {
        SiteContent::ensureImages();

        return SiteContent::merge(SiteContent::defaults(), static::current()->data ?? []);
    }
}
