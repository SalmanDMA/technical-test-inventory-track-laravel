<?php

namespace App\View\Components\auth;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class prompt extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $action,
        public string $text,
        public string $textLink,
    ) {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.auth.prompt');
    }
}
