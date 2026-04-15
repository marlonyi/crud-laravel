<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class AlertMessage extends Component
{
    public function __construct(
        public string $type = 'success',
        public string $message = '',
        public bool $dismissible = true
    ) {}

    public function render(): View|Closure|string
    {
        return view('components.alert-message');
    }
}
