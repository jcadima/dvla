<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Carbon\Carbon;


class UserAccount extends Component
{
    public $greeting;

    public function mount()
    {
        $this->greeting = $this->getGreeting();
    }

    public function getGreeting()
    {
        $hour = Carbon::now('America/New_York')->format('H');

        if ($hour < 12) {
            return 'Good morning';
        } elseif ($hour < 18) {
            return 'Good afternoon';
        } else {
            return 'Good evening';
        }
    }
    public function render()
    {
        return view('livewire.admin.user-account') ;
    }
}
