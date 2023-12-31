<?php

namespace App\Livewire;

use App\Enums\RequestStatusEnum;
use App\Models\Request;
use App\Models\RequestItem;
use App\Models\RequestStatusHistory;
use App\Services\PayMongoService;
use App\Services\SemaphoreService;
use App\Services\SmsNotificationService;
use Livewire\Component;

class RequestItems extends Component
{
    public $request;
    public $selectedItemId;
    public $items;
    public $total = 0;
    public $checkoutSessionError = false;
    
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
        $request = Request::where('id', $this->request->id)
        ->with('user')
        ->first();

        $checkoutSession = PayMongoService::checkout($request->user_id, $request->id);

        // check response
        if($checkoutSession['status'] == 200) {
            $this->checkoutSessionError = false;
            $request->update([
                'status' => RequestStatusEnum::PENDING_PAYMENT,
                'checkout_url' => $checkoutSession['data']['checkout_url'],
                'reference_number' => $checkoutSession['data']['reference_number'],
                'checkout_session_id' => $checkoutSession['data']['checkout_session_id'],
            ]);
            
            RequestStatusHistory::firstOrCreate([
                'request_id' => $this->request->id,
                'status' => RequestStatusEnum::PENDING_REVIEW
            ], [
                'request_id' => $this->request->id,
                'status' => RequestStatusEnum::PENDING_REVIEW,
                'date_completed' => now()->format('Y-m-d')
            ]);

            $to = '63' . substr($request->user->contact_number, 1);
            $from = 'RRMS';
            $message = "Greetings " . $request->user->last_name . ", your request has been approved. The total amount to pay is P". $checkoutSession['data']['total'] . '. You can pay it by visiting your RRMS account. Thank you!';

            SemaphoreService::send($to, $message);
            // (new SmsNotificationService())->send($to, $from, $message);

            $this->dispatch('approved');
        }else {
            $this->checkoutSessionError = true;
        }        
    }


    public function declineItems() 
    {
        $request = Request::where('id', $this->request->id)
        ->with('user')
        ->update([
            'status' => RequestStatusEnum::DECLINED
        ]);

        $to = '63' . substr($request->user->contact_number, 1);
        $message = "Greetings " . $request->user->last_name . ", your request has been disapproved. Please visit your RRMS account for more details.";

        SemaphoreService::send($to, $message);
        $this->dispatch('declined');
    }
}
