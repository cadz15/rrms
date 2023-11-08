<?php

namespace App\View\Components\Form;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Information extends Component
{
    public $dataForm;
    public $formURL;
    public $formTitle;
    public $saveText;
    public $cancelURL;
    public $cancelText;
    public $cancelVisible;
    public $degrees;
    public $majors;

    /**
     * Create a new component instance.
     */
    public function __construct(
        $data = [],
        $formURL, 
        $formTitle, 
        $saveText = 'Save', 
        $cancelURL = '#', 
        $cancelText = 'Cancel', 
        $cancelVisible = false,
        $degrees = [
            [
                'id' => 1,
                'name' => 'Bachelor of Elementary Education'
            ],
            [
                'id' => 2,
                'name' => 'Bachelor of Industrial Technology'
            ],
        ],
        $majors = [
            [
                'id' => 1,
                'name' => 'Major 1'
            ],
            [
                'id' => 2,
                'name' => 'Major 2'
            ],
        ]
     )
    {
        $this->dataForm = $data;
        $this->formURL = $formURL;
        $this->formTitle = $formTitle;
        $this->saveText = $saveText;
        $this->cancelURL = $cancelURL;
        $this->cancelText = $cancelText;
        $this->cancelVisible = $cancelVisible ? '' : 'd-none';
        $this->degrees = $degrees;
        $this->majors = $majors;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.form.information');
    }
}
