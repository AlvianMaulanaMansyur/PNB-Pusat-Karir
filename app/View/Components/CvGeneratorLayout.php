<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CvGeneratorLayout extends Component
{
    public const ALLOWED_STEPS = [
        'informasi-pribadi',
        'profesional',
        'pendidikan',
        'organisasi',
        'lainnya',
        'review'
    ];

    public string $activeStep;

    public function __construct(string $activeStep = 'informasi-pribadi')
    {
        $this->activeStep = in_array($activeStep, self::ALLOWED_STEPS)
            ? $activeStep
            : 'informasi-pribadi';
    }

    public function render(): View|Closure|string
    {
        return view('components.cv-generator-layout');
    }
}
