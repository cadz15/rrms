@extends('layout.contentLayoutMaster')

@section('title', 'Item List')

@section('content')


    <h5 class="py-3">
        <span class="text-muted fw-light">Items /</span> List
    </h5>

    <div class="row">

        <div class="col-md-6 col-sm-12">
            
            @if(session()->has('success-delete'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session()->get('success-delete') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session()->has('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session()->get('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Item List</h5>
                </div>

                <form action="{{ route('item.setup.index') }}" method="get">
                    <div class="px-3 pb-3 float-end d-flex align-items-center gap-3">
                        
                        <div class="input-group input-group-merge">
                            <input type="search" class="form-control" name="search" id="search" placeholder="Search" value="{{ $search }}">
                            <span class="input-group-text cursor-pointer" id="search-icon">
                                <i class='bx bx-search-alt'></i>
                            </span>
                        </div>
                    </div>
                </form>

                
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead class="border-top">
                            <tr>
                                <th>Item Name</th>
                                <th width='20%'>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse ($items as $item)
                            <tr>
                                <td>{{ $item->name }}</td>
                                <td>
                                    <a href="{{ route('item.setup.view.delete', $item->id) }}" class="text-primary fs-5">
                                        <i class='bx bx-trash text-danger'></i>
                                    </a>
                                    <a href="{{ route('item.setup.view.update', $item->id) }}" class="text-primary fs-5">
                                        <i class='bx bx-edit-alt text-warning'></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">No Data</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>

                    <div class="px-3 pt-3 float-end">
                    {{ $items->links() }}
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-sm-12">
            @if(!empty($updateItem))
                <a href="{{ route('item.setup.index') }}" class="btn btn-outline-primary mb-2"><i class='bx bx-plus'></i> Add Item</a>
            @endif
            <div class="card">
                <div class="card-body">

                    @if(empty($updateItem))
                    
                    <div class="col-12">
                        
                        <h5 class="card-title">Add Item</h5>
                    </div>

                    <form action="{{ route('item.setup.create') }}" method="post">
                        @csrf

                        <div class="col-12">
                            <div class="form-group">
                                <label for="item-name">Name <span class="text-danger">*</span></label>
                                <input type="text" name="item-name" 
                                class="form-control {{ $errors->has('item-name')? 'is-invalid' : '' }}" 
                                placeholder="Item name"
                                value="{{ old('item-name') }}">
                                <div class="invalid-feedback">
                                    {{ $errors->first('item-name') }}
                                </div>
                            </div>
                        </div>


                        <div class="col-12 mt-2">
                            <button class="btn btn-primary"><i class='bx bx-save' ></i> Add</button>
                        </div>
                    </form>

                    @else
                    
                    
                    <div class="col-12">
                        
                        <h5 class="card-title">Update Item</h5>
                    </div>

                    <form action="{{ route('item.setup.update') }}" method="post">
                        @csrf
                        <input type="hidden" name="update-id" value="{{ $updateItem->id }}">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="item-name">Name <span class="text-danger">*</span></label>
                                <input type="text" name="item-name" 
                                class="form-control {{ $errors->has('item-name')? 'is-invalid' : '' }}" 
                                placeholder="Item name"
                                value="{{ $updateItem->name }}"
                                >
                                <div class="invalid-feedback">
                                    {{ $errors->first('item-name') }}
                                </div>
                            </div>
                        </div>


                        <div class="col-12 mt-2">
                            <button class="btn btn-success"><i class='bx bx-save' ></i> Update</button>
                        </div>
                    </form>

                    @endif

                </div>
            </div>
        </div>
    </div>

@endsection
