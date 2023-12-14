<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\RequestItem;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RequestItemController extends Controller
{
    
    public function index(Request $request) {
        $search = $request->has('search')? $request->search : '';

        
        $items = Item::when(!empty($search), function($query) use($search){
            return $query->where('name', 'LIKE', "%$search%");
        })
        ->oldest('name')
        ->paginate(10);

        return view('requests.item.list', compact('items', 'search'));
    }


    public function create(Request $request) {
        $request->validate([
            'item-name' => ['required', 
            Rule::unique('items', 'name')->whereNull('deleted_at')]
        ]);

        Item::create([
            'name' => $request->get('item-name')
        ]);

        return redirect()->back()->with('success', 'Item successfully added!');
    }


    public function viewEdit($id) {
        $updateItem = Item::whereNull('deleted_at')
        ->where('id', $id)
        ->first();

        if(empty($updateItem)) return abort(404);
        $search = '';
        
        $items = Item::oldest('name')
        ->paginate(10);

        return view('requests.item.list', compact('items', 'search', 'updateItem'));
    }


    public function update(Request $request) {
        $request->validate([
            'item-name' => ['required', 
            Rule::unique('items', 'name')->whereNull('deleted_at')->ignore($request->get('update-id'))]
        ]);

        $updateItem = Item::whereNull('deleted_at')
        ->where('id', $request->get('update-id'))
        ->first();

        if(empty($updateItem)) return abort(404);

        // update name on request items
        RequestItem::where('item_id', $updateItem->id)
        ->update([
            'item_name' => $request->get('item-name')
        ]);

        $updateItem->update([
            'name' => $request->get('item-name')
        ]);


        return redirect(route('item.setup.index'))->with('success', 'Item successfully updated!');
    }


    public function viewDelete($id) {
        $item = Item::whereNull('deleted_at')
        ->where('id', $id)
        ->first();

        if(empty($item)) return abort(404);

        return view('requests.item.confirm-delte', compact('id'));
    }


    public function destroy($id) {
        $item = Item::whereNull('deleted_at')
        ->where('id', $id)
        ->first();

        if(empty($item)) return abort(404);

        $item->delete();

        return redirect(route('item.setup.index'))->with('success-delete', 'Item successfully deleted!');
    }
}
