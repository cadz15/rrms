<div class="row">

        <div class="col-lg-5 col-md-12 mb-3">
            @if(!empty($error))
                <div class="alert alert-danger" id="checkout-error-cont" role="alert">
                    {{ $error }}
                </div>
            @endif

            @if($requestInvalid) 
                <div class="alert alert-danger" id="checkout-error-cont" role="alert">
                    The requested item(s) is/are being processed right now.
                    <ul>
                        @foreach ($invalidItems as $item)
                            <li>{{ $item['item_name'] }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="card">
                <h5 class="card-header border-bottom mb-2">Add  Item</h5>
                <div class="card-body">
                    <div class="form-group">
                        <label for="education">Education Level</label>
                        <select wire:model="education_id" name="education" id="education" class="form-select {{ $errors->has('education_id') ? 'is-invalid' : '' }}">
                            <option value="">--Select Education--</option>
                            @foreach ($majors as $major)
                                <option value="{{$major->id}}">{{ $major->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="item">Item</label>
                        <select wire:model="item_id" name="item" id="item" class="form-select  {{ $errors->has('item_id') ? 'is-invalid' : '' }}">
                            <option value="">--Select Item--</option>
                            @foreach ($requestableItems as $requestableItem)
                                <option value="{{$requestableItem->id}}">{{ $requestableItem->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="qty">Quantity</label>
                        <input wire:model="quantity" type="number" name="qty" id="qty"  class="form-control  {{ $errors->has('quantity') ? 'is-invalid' : '' }}" min="0" />
                    </div>

                    <button wire:click="addItem"  wire:loading.class="d-none" wire:target="addItem" class="btn btn-outline-primary float-start mt-2 col-12">Add</button>
                    <button wire:loading wire:target="addItem" class="btn btn-outline-primary float-start mt-2 col-12">Adding...</button>
                </div>
            </div>
        </div>

        <div class="col-lg-7 col-md-12">
            <div class="card">
                <h5 class="card-header">Item Summary</h5>
                <div class="card-body">
                    <table class="table" id="table-list">
                        <thead>
                            <tr>
                                <th></th>
                                <th style="max-width: 30px !important; width: 30px !important;"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($items as $index => $item)
                                <tr>
                                    <td>
                                        <div class="d-flex">
                                            <div>
                                                <h6 class="mb-0">{{$item['quantity']}} x {{$item['item_name']}}</h6>
                                                <span class="text-secondary" style="font-size: 0.8rem;">{{$item['degree_name']}}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td >
                                        <button wire:click="removeItem({{ $index }})" class="btn btn-outline-danger col-12">
                                            <i class='bx bx-trash'></i>
                                        </button>
                                    </td>
                                </tr>
                                
                            @empty
                                <tr>
                                    <td colspan="2" class="text-center">No items added</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="loading-livewire" wire:loading wire:target="createRequest,updateRequest,cancelRequest">
                        <div class="d-flex align-items-center justify-content-center h-100">
                            <i class='bx bx-loader'></i>
                        </div>
                    </div>
                </div>
                @if(!empty($items))
                    @if($mode == 'create')
                        <div class="card-footer">
                            <button wire:click="createRequest"  wire:loading.class="d-none" wire:target="createRequest" class="btn btn-primary float-start mt-2 col-12">Create Request</button>
                            <button wire:loading wire:target="createRequest" class="btn btn-primary float-start mt-2 col-12">Creating...</button>
                        </div>
                    @else
                        <div class="card-footer d-flex">
                            <button wire:click="updateRequest"  wire:loading.class="d-none" wire:target="updateRequest" class="btn btn-primary float-start mt-2 col-6">Update Request</button>
                            <button wire:loading wire:target="updateRequest" class="btn btn-primary float-start mt-2 col-6">Updating...</button>
                            <button wire:click="cancelRequest"  wire:loading.class="d-none" wire:target="cancelRequest" class="btn btn-outline-danger mt-2 col-6 ms-2"> Cancel Request</button>
                            <button wire:loading wire:target="cancelRequest" class="btn btn-outline-danger float-start mt-2 col-6 ms-2">Canceling...</button>
                        </div>
                    @endif
                @endif
            </div>
        </div>


        <script>
            window.addEventListener('declined', () => {
                window.location.reload();
            });
            window.addEventListener('updated', () => {
                window.location.reload();
            });
        </script>
    </div>