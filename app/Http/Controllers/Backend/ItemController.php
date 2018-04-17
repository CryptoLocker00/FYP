<?php


namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\ItemTemplateRequest;
use App\Model\ItemTemplate;
use Illuminate\Support\Facades\DB;

class ItemController extends Controller
{
    public function view()
    {
        $items = ItemTemplate::all();

        return view('item.view', compact('items'));
    }

    public function getCreate()
    {
        return view('item.create');
    }

    public function postCreate(ItemTemplateRequest $request)
    {
        DB::beginTransaction();
        try {
            ItemTemplate::create($request->all());
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            flash()->error(trans('crud.other', ['name' => 'Item Template']));

            return redirect()->back()->withInput();
        }

        flash()->success(trans('crud.create_success', ['name' => 'Item Template']));

        return redirect('/backend/item');
    }

    public function getEdit($id)
    {
        try {
            $item = ItemTemplate::findOrFail($id);
        } catch (\Exception $e) {
            flash()->error(trans('crud.other', ['name' => 'Item Template']));

            return redirect()->back();
        }

        return view('item.edit', compact('item'));
    }

    public function postEdit(ItemTemplateRequest $request)
    {
        DB::beginTransaction();
        try {
            $item = ItemTemplate::findOrFail($request->id);
            $item->update($request->all());

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            flash()->error(trans('crud.other', ['name' => 'Item Template']));

            return redirect()->back()->withInput();
        }

        flash()->success(trans('crud.update_success', ['name' => 'Item Template']));

        return redirect('/backend/item');
    }

    public function postDelete(ItemTemplateRequest $request)
    {
        DB::beginTransaction();
        try {
            $item = ItemTemplate::findOrFail($request->id);
            $item->delete();
        } catch (\Exception $e) {
            DB::rollback();
            flash()->error(trans('crud.other', ['name' => 'Item Template']));

            return redirect()->back()->withInput();
        }
        DB::commit();
        flash()->success(trans('crud.delete_success', ['name' => 'Item Template']));

        return redirect('/backend/item');
    }
}