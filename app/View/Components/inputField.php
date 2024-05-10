<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class inputField extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $labelName,
        public string $name,
        public string $type,
        public string $placeholder,
        public string $value = '',
        public bool $requiredInput = false,
    ) {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.input-field');
    }
}
