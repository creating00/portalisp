<?php

namespace App\View\Components\Ui;

use Illuminate\View\Component;

class Money extends Component
{
    public float|int $amount;
    public string $status;

    public function __construct($amount, $status = '')
    {
        $this->amount = (float) $amount;
        $this->status = strtolower($status);
    }

    public function classes(): string
    {
        return match ($this->status) {
            'pendiente' => 'text-primary-violet',
            'pagada'    => 'text-green-400',
            default     => 'text-white',
        };
    }

    public function render()
    {
        return view('components.ui.money');
    }
}
