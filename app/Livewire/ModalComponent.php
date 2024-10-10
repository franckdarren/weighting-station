<?php

namespace App\Livewire;

use Livewire\Component;

class ModalComponent extends Component
{
    public $showModal = [
        'article20' => false,
        'article21' => false,
        'article22' => false,
        'article71' => false,
        'article73' => false,
        'article24' => false,
        'article25' => false,
        'article26' => false,
        'article27' => false,
    ];

    public function openModal($modalName)
    {
        $this->showModal[$modalName] = true;
    }

    public function closeModal($modalName)
    {
        $this->showModal[$modalName] = false;
    }

    public function render()
    {
        return view('livewire.modal-component');
    }
}
