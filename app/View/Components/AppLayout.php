<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class AppLayout extends Component
{   
    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {   
        $sideMenuData = sideMenu();

        $cards = $sideMenuData['model_setCards'];
        $contacts = $sideMenuData['model_selectContactMessage'];

        
        return view('layouts.app', compact('cards', 'contacts'));
    }
}
