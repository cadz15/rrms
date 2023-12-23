<!-- resources/views/livewire/request-items.blade.php -->

<div>
    <div class="row gap-3 mt-1">
        @foreach ($request->requestItems as $key => $item)
            <div class="col-12 row">
                <div class="col-4 align-items-center d-flex">
                    <i wire:click="confirmDelete({{ $item->id }})" class='bx bx-trash me-1 text-danger cursor-pointer'></i>
                    <span>{{ $item->item_name }}</span>
                </div>
                <div class="col-4">
                    <div class="form-group">
                        <label for="item-{{ $key }}-qty">Copies / Qty</label>
                        <input wire:model.lazy="items.{{$key}}.quantity" readonly 
                        type="number" 
                        class='form-control {{ $errors->has("items.$key.quantity") ? "is-invalid" : "" }}' 
                        name="item-qty[{{ $key }}]" 
                        id="item-{{ $key }}-qty" 
                        wire:key="item-qty[{{ $key }}]"
                        
                        >
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-group">
                        <label for="item-{{ $key }}-price">Price</label>
                        <input wire:model.lazy="items.{{$key}}.price" 
                        type="number" 
                        class='form-control {{ $errors->has("items.$key.price") ? "is-invalid" : "" }}' 
                        name="item-price[{{ $key }}]" 
                        id="item-{{ $key }}-price" 
                        wire:key="item-price[{{ $key }}]"
                        >
                    </div>
                </div>
            </div>
            
        <div class="loading-livewire" wire:loading wire:target="confirmDelete({{ $item->id }})">
            <div class="d-flex align-items-center justify-content-center h-100">
                <i class='bx bx-loader'></i>
            </div>
        </div>
        @endforeach
    </div>

    <div class="card-footer border-top mt-3">
        <div class="float-end d-flex flex-column">
            <h6 class="m-0 text-center">Total</h6>
            <div class="text-end "><h5 class="text-primary">₱ {{ number_format($total) }}</h5></div>
        </div>
        
        <button wire:click="declineItems"  wire:loading.class="d-none" wire:target="declineItems" class="btn btn-danger float-start">Decline</button>
        <button wire:loading wire:target="declineItems" class="btn btn-danger float-start">Declining...</button>

        <button wire:click="approveItems"  wire:loading.class="d-none" wire:target="approveItems" class="btn btn-primary float-start ms-1">Approve</button>
        <button wire:loading wire:target="approveItems" class="btn btn-primary float-start ms-1">Approving...</button>
    </div>

    <!-- Confirmation Modal -->
    <div wire:ignore.self class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmDeleteModalLabel">Confirm Delete</h5>
                    <button type="button" class="close btn btn-close" data-dismiss="modal" aria-label="Close" onclick="closeModal()">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this item?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="closeModal()">Cancel</button>
                    <button wire:click="deleteItem" wire:loading.class="d-none" wire:target="deleteItem" type="button" class="btn btn-danger">
                        Delete
                    </button>
                    <button wire:loading wire:target="deleteItem" type="button" class="btn btn-danger">
                        Deleting...
                    </button>
                </div>
            </div>
        </div>
    </div>


    <!-- Script to show the confirmation modal -->
    <script>

        window.addEventListener('confirm-delete', () => {
            $('#confirmDeleteModal').modal('show');
        });

        window.addEventListener('itemDeleted', () => {
            $('#confirmDeleteModal').modal('hide');
        });

        window.addEventListener('approved', () => {
            window.location.reload();
        });

        window.addEventListener('declined', () => {
            window.location.reload();
        });
        
        const closeModal = () => {
            $('#confirmDeleteModal').modal('hide');
        }
    </script>
</div>
