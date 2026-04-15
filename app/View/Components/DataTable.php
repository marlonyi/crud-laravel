<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class DataTable extends Component
{
    public function __construct(
        public string $title = '',
        public string $createUrl = '',
        public string $createLabel = 'Nuevo',
        public bool $showSearch = true
    ) {}

    public function render(): View|Closure|string
    {
        return view('components.data-table');
    }
}
