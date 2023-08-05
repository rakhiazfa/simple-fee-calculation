<?php

namespace App\View\Components\Auth;

use App\Models\User;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Topbar extends Component
{
    /**
     * @var User|null
     */
    public ?User $user;

    /**
     * @var string
     */
    public string $title;

    /**
     * Create a new component instance.
     */
    public function __construct(?User $user = null, string $title = "")
    {
        $this->user = $user;
        $this->title = $title;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.auth.topbar');
    }
}
