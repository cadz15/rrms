<?php

namespace App\Livewire;

use App\Enums\RequestStatusEnum;
use App\Models\Request;
use App\Models\RequestItem;
use App\Models\RequestStatusHistory;
use Livewire\Component;

class RequestItems extends Component
{
    public $request;
    public $selectedItemId;
    public $items;
    public $total = 0;
    
    protected $rules = [];
    
    protected $listeners = ['itemDeleted' => 'updateTotal'];

    public function mount($request)
    {
        $this->request = $request->load('requestItems');
        $this->items = $request->requestItems->toArray();
    }

    public function render()
    {
        $this->updateTotal();
        return view('livewire.request-items');
    }

    public function calculateTotal()
    {
        return collect($this->items)->sum(function ($item) {
            return $item['quantity'] * $item['price'];
        });
    }

    public function confirmDelete($itemId)
    {
        $this->selectedItemId = $itemId;
        $this->dispatch('confirm-delete');
    }

    public function deleteItem()
    {
        if ($this->selectedItemId) {
            RequestItem::destroy($this->selectedItemId);
            $this->selectedItemId = null;
            $this->dispatch('itemDeleted');
        }
    }

    public function updateTotal()
    {
        $this->total = $this->calculateTotal();
    }

    public function updatedItems($value, $key)
    {
        $this->validateOnly("items.$key", ['items.'.$key => 'numeric|min:0']);
        $this->validateOnly("items.$key", ['items.'.$key => 'numeric|min:0']);
        
        $this->updateTotal();
    }

    public function approveItems()
    {
        $this->validate([
            'items.*.quantity' => ['required', 'numeric', 'min:0'],
            'items.*.price' => ['required', 'numeric', 'min:0'],
        ]);

        foreach($this->items as $item) {
            RequestItem::where('id', $item['id'])
            ->update([
                'price' => $item['price']
            ]);
        }

        Request::where('id', $this->request->id)
        ->update([
            'status' => RequestStatusEnum::PENDING_PAYMENT
        ]);
        
        RequestStatusHistory::firstOrCreate([
            'request_id' => $this->request->id,
            'status' => RequestStatusEnum::PENDING_REVIEW
        ], [
            'request_id' => $this->request->id,
            'status' => RequestStatusEnum::PENDING_REVIEW,
            'date_completed' => now()->format('Y-m-d')
        ]);
        $this->dispatch('approved');
    }


    public function declineItems() 
    {
        Request::where('id', $this->request->id)
        ->update([
            'status' => RequestStatusEnum::DECLINED
        ]);

        
        $this->dispatch('declined');
    }
}
