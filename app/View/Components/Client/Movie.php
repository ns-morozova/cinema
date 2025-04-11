<?php

namespace App\View\Components\Client;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Movie extends Component
{
    public $title;
    public $poster;
    public $description;
    public $duration;
    public $country;
    public $seances;

    public function __construct($title, $poster, $description, $duration, $country, $seances)
    {
        $this->title = $title;
        $this->poster = $poster;
        $this->description = $description;
        $this->duration = $duration;
        $this->country = $country;
        $this->seances = $seances;
    }

    public function render()
    {
        return view('components.client.movie');
    }
}