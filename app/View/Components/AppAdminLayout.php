<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class AppAdminLayout extends Component
{
    public function render(): View
    {
        return view('layouts.app-admin');
    }
}