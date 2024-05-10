<?php

namespace App\View\Components\dashboard;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class asideItem extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $title,
        public string $url,
        public string $icon,
        public bool $activeUrl
    ) {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.dashboard.aside-item');
    }
}
