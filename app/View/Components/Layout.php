<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Layout extends Component
{
    /**
     * @var string
     */
    public string $title;

    /**
     * Create a new component instance.
     */
    public function __construct(string $title = "")
    {
        $this->title = $title . ' - ' . env('APP_NAME');
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.layout');
    }
}
