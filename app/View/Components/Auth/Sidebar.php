<?php

namespace App\View\Components\Auth;

use App\Models\User;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Sidebar extends Component
{
    /**
     * @var User|null
     */
    public ?User $user;

    /**
     * Create a new component instance.
     */
    public function __construct(?User $user = null)
    {
        $this->user = $user;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.auth.sidebar');
    }
}
