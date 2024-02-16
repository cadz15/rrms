<?php

namespace App\Livewire;

use App\Enums\RequestStatusEnum;
use App\Models\Major;
use App\Models\Request;
use App\Models\RequestableItem;
use App\Models\RequestItem;
use Livewire\Component;

class CreateRequest extends Component
{
    public $userId;
    public $majors;
    public $requestableItems;
    public $items = [];
    public $education_id;
    public $item_id;
    public $quantity = 0;
    public $error;
    public $requestInvalid = false;
    public $invalidItems = [];
    public $mode;
    public $requestId;

    public function mount($majors, $requestableItems, $userId, $mode = 'create', $items = [], $requestId = 0) {
        $this->majors = $majors;
        $this->requestableItems = $requestableItems;
        $this->userId = $userId;
        $this->mode = $mode;  
        $this->items = $items;
        $this->requestId = $requestId;
    }

    public function render()
    {
        return view('livewire.create-request');
    }


    public function addItem() 
    {
        $this->validate([
            'education_id' => ['required'],
            'item_id' => ['required'],
            'quantity' => ['required', 'numeric','min:1']
        ]);
     
        
        $addedItem = collect($this->items)->where('degree_id', $this->education_id)->where('item_id', $this->item_id)->first();
        $selectedItem = RequestableItem::where('id', $this->item_id)->first();
        $selectedEducation = Major::where('id', $this->education_id)->first();

        if(!empty($addedItem)) {
            $this->error = 'Item is already in the list';
        }else {

            array_push($this->items, [
                'item_id' => $this->item_id,
                'item_name' => $selectedItem->name,
                'degree_id' => $this->education_id,
                'degree_name' => $selectedEducation->name,
                'quantity' => $this->quantity,
            ]);

            $this->item_id = '';
            $this->education_id = '';
            $this->quantity = 0;
            $this->error = '';
        }
    }


    public function removeItem($itemIndex) {
        unset($this->items[$itemIndex]);
    }


    public function createRequest() {
        

        $this->requestInvalid = false;
        $this->invalidItems = [];

        $requestIds = auth()->user()->requests()->whereNotIn('status', [RequestStatusEnum::COMPLETED, RequestStatusEnum::DECLINED])->pluck('id')->toArray();

        $requestedItems = RequestItem::whereIn('request_id', $requestIds)->get();

        foreach($this->items as $item) {
            $foundItem = $requestedItems->where('item_id', $item['item_id'])->where('degree_name', $item['degree_name'])->first();

            if(!empty($foundItem)) {
                $this->requestInvalid = true;

                array_push($this->invalidItems, [
                    'item_name' => $item['item_name'],
                    'degree_name' => $item['degree_name'],
                ]);
                
            }
        }

        if(!$this->requestInvalid) {
            $request = Request::create([
                'user_id' => $this->userId,
                'status' => RequestStatusEnum::PENDING_REVIEW->value,            
            ]);

            foreach($this->items as $item) {
                $request->requestItems()->create([
                    'item_id' => $item['item_id'],
                    'item_name' => $item['item_name'],
                    'degree_id' => $item['degree_id'],
                    'degree_name' => $item['degree_name'],
                    'quantity' => $item['quantity'],
                ]);
            }
            return redirect()->route('student.dashboard');
        }

    }


    public function updateRequest() {

        $this->requestInvalid = false;
        $this->invalidItems = [];

        $requestIds = auth()->user()->requests()->whereNotIn('status', [RequestStatusEnum::COMPLETED, RequestStatusEnum::DECLINED])->pluck('id')->toArray();

        $requestedItems = RequestItem::whereIn('request_id', array_diff($requestIds, [$this->requestId]))->get();

        foreach($this->items as $item) {
            $foundItem = $requestedItems->where('item_id', $item['item_id'])->where('degree_name', $item['degree_name'])->first();
            
            if(!empty($foundItem) && $foundItem->request_id != $this->requestId) {
                $this->requestInvalid = true;
                
                array_push($this->invalidItems, [
                    'item_name' => $item['item_name'],
                    'degree_name' => $item['degree_name'],
                ]);
                
            }
        }        
        
        if(!$this->requestInvalid) {
            $request = Request::where('id', $this->requestId)->where('user_id', $this->userId)->first();
            $updatedOrCreatedItems = [];
    
            foreach($this->items as $item) {
                // create Or update
                $requestUpCreate = $request->requestItems()->updateOrCreate([
                    'request_id' => $request->id,
                    'item_id' => $item['item_id'],
                    'degree_name' => $item['degree_name']
                ], [
                    'request_id' => $request->id,
                    'item_id' => $item['item_id'],
                    'item_name' => $item['item_name'],
                    'degree_name' => $item['degree_name'],
                    'quantity' => $item['quantity']
                ]);
    
                array_push($updatedOrCreatedItems, $requestUpCreate->id);
            }
    
            if(!empty($updatedOrCreatedItems)) {
                // remove items that are no longer in the request
                $request->requestItems()->whereNotIn('id', $updatedOrCreatedItems)->delete();
            }
    
            $this->dispatch('updated');
        }
    }


    public function cancelRequest() {
        $request = Request::where('id', $this->requestId)->where('user_id', $this->userId)->with('user')->first();

        if(empty($request)) return abort(404);

        if($request->status == RequestStatusEnum::PENDING_REVIEW->value) {
            $request->update([
                'status' => RequestStatusEnum::DECLINED->value
            ]);
            
            $this->dispatch('declined');
        }else {
            $this->error = 'You cannot cancel this request. Request has already been approved.';
        }
    }
}
