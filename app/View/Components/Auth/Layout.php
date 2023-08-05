<?php

namespace App\View\Components\Auth;

use App\Models\User;
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
     * @var string
     */
    public string $originTitle;

    /**
     * @var User|null
     */
    public User|null $user = null;

    /**
     * Create a new component instance.
     */
    public function __construct(string $title = "")
    {
        $this->originTitle = $title;

        $this->title = $title . ' - ' . env('APP_NAME');

        $this->user = auth()->user() ?? null;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.auth.layout');
    }
}
