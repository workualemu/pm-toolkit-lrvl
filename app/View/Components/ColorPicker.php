<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ColorPicker extends Component
{
    public array $colors;
    public string $name;
    public string $selectedColor;
    public ?string $model;

    public function __construct($name = 'color', $selectedColor = 'blue', $model = null)
    {
        $this->name = $name;
        $this->selectedColor = $selectedColor;
        $this->model = $model;

        // Define the Tailwind-friendly colors
        $this->colors = [
            'slate', 'gray', 'zinc', 'neutral', 'stone',
            'red', 'orange', 'amber', 'yellow', 'lime',
            'green', 'emerald', 'teal', 'cyan', 'sky',
            'blue', 'indigo', 'violet', 'purple', 'fuchsia',
            'pink', 'rose'
        ];
    }

    public function render()
    {
        return view('components.color-picker');
    }
}
