<?php

namespace App\Livewire;

use Livewire\Attributes\Computed;
use Livewire\Component;

class StartGame extends Component
{
    public $topic;

    public $numPreguntaActual = 1;
    public $totalPreguntasPorJuego;

    public $respuestaActual = '';

    public $correctas = 0;
    public $incorrectas = 0;

    public $question;

    public function mount($topic)
    {
        $this->topic = $topic;
        $this->totalPreguntasPorJuego = $topic->questions->count();

        $this->question = $this->topic->questions[$this->numPreguntaActual - 1];
    }

    public function verify()
    {

        $correct = $this->question->options->search(function ($option) {
            return $option['is_correct'];
        });

        if ($this->respuestaActual == $correct) {
            $this->correctas++;
        } else {
            $this->incorrectas++;
        }

        $this->numPreguntaActual = $this->numPreguntaActual + 1;
        $this->respuestaActual = '';


        if ($this->numPreguntaActual <= $this->totalPreguntasPorJuego) {
            $this->question = $this->topic->questions[$this->numPreguntaActual - 1];
        }else{
            $this->dispatch('resultado');
        }

    }

    public function render()
    {
        return view('livewire.start-game');
    }
}
