<?php

namespace App\Livewire;

use App\Models\Education;
use App\Models\RequestableItem;
use App\Models\RequestItem;
use Livewire\Component;

class AddItem extends Component
{
    public $request;
    public $educations;
    public $requestableItems;
    public $quantity = 0;
    public $education_id;
    public $item_id;
    public $error;

    public function mount($educations, $requestableItems, $request) {
        $this->educations = $educations;
        $this->requestableItems = $requestableItems;
        $this->request = $request->load('requestItems');
    }

    public function render()
    {
        return view('livewire.add-item');
    }

    public function addItem() 
    {
        $this->validate([
            'education_id' => ['required'],
            'item_id' => ['required'],
            'quantity' => ['required', 'numeric','min:1']
        ]);

        $selectedEducation = Education::where('id', $this->education_id)->with('major')->first();
        $selectedItem = RequestableItem::where('id', $this->item_id)->first();
        $requestedItem = RequestItem::where('request_id', $this->request->id)->where('degree_name', $selectedEducation->major->name)->where('item_id', $this->item_id)->first();

        if(!empty($requestedItem)) {
            $this->error = 'Item is already in the list';
        }else {

            $this->request->requestItems()->create([
                'item_id' => $this->item_id,
                'item_name' => $selectedItem->name,
                'degree_name' => $selectedEducation->major->name,
                'quantity' => $this->quantity,
            ]);
            
            $this->dispatch('added');
        }
    }
}
