<?php

namespace App\View\Components;

use App\Models\Service;
use Illuminate\View\Component;

class ServiceForm extends Component
{
    public $service;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(Service $service)
    {
        $this->service = $service;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.service-form');
    }
}