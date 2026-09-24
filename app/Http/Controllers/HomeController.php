<?php

namespace App\Http\Controllers;

use App\Models\SiteSetting;
use App\Support\Finance;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __invoke(): View
    {
        return view('site.home', [
            'site' => SiteSetting::content(),
            'calc' => [
                'min' => Finance::MIN_AMOUNT,
                'max' => Finance::MAX_AMOUNT,
                'step' => Finance::STEP,
                'default' => Finance::DEFAULT_AMOUNT,
                'advanceRate' => Finance::ADVANCE_RATE,
                'monthlyRate' => Finance::MONTHLY_RATE,
                'terms' => Finance::TERMS,
                'initialDays' => 60,
            ],
        ]);
    }
}
