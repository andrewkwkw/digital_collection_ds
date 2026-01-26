<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\Archive;

class NavGuest extends Component
{
    public $types;

    public function __construct()
    {
        $this->types = Archive::query()
            ->whereNotNull('type')
            ->distinct()
            ->orderBy('type')
            ->pluck('type');
    }

    public function render()
    {
        return view('components.nav-guest');
    }
}
