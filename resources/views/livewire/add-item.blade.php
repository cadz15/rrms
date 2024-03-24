
    <div class="col-4">
        @if(!empty($error))
            <div class="alert alert-danger" id="checkout-error-cont" role="alert">
                {{ $error }}
            </div>
        @endif
        <div class="card">
            <h5 class="card-header border-bottom mb-2">Add  Item</h5>
            <div class="card-body">
                <div class="form-group">
                    <label for="education">Education Level</label>
                    <select wire:model="education_id" name="education" id="education" class="form-select {{ $errors->has('education_id') ? 'is-invalid' : '' }}">
                        <option value="">--Select Education--</option>
                        @foreach ($educations as $education)
                            <option value="{{$education['id']}}">{{ $education['degree'] }}</option>
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

                <button wire:click="addItem"  wire:loading.class="d-none" wire:target="addItem" class="btn btn-success float-start mt-2 col-12">Add</button>
                <button wire:loading wire:target="addItem" class="btn btn-primary float-start mt-2 col-12">Adding...</button>
            </div>
        </div>
    </div>


    <script>
        window.addEventListener('added', () => {
            window.location.reload();
        });
    </script>