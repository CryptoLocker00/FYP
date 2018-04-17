<?php

namespace App\Http\Controllers\Backend;

use App\Model\Client;
use App\Model\ClientContactPerson;

use App\Http\Controllers\Controller;
use App\Http\Requests\ClientRequest;
use Illuminate\Support\Facades\DB;

class ClientController extends Controller
{
    public function view()
    {
        $clients = Client::with('contactPerson')->get();

        return view('client.view', compact('clients'));
    }

    public function getCreate()
    {
        return view('client.create');
    }

    public function postCreate(ClientRequest $request)
    {
        $input = $request->all();
        DB::beginTransaction();
        try {
            $client = Client::create($input);
            $input['client_id'] = $client->id;

            ClientContactPerson::create($input);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            flash()->error(trans('crud.other', ['name' => 'Client']));

            return redirect()->back()->withInput();

        }

        flash()->success(trans('crud.create_success', ['name' => 'Client']));

        return redirect('/backend/client');
    }

    public function getEdit($id)
    {
        try {
            $client = Client::with('contactPerson')->findOrFail($id);
        } catch (\Exception $e) {
            flash()->error(trans('crud.not_found', ['name' => 'Client']));

            return redirect()->back();
        }

        return view('client.edit', compact('client'));
    }

    public function postEdit(ClientRequest $request)
    {
        $input = $request->all();
        DB::beginTransaction();
        try {
            $client = Client::findOrFail($input['id']);
            $client->update($input);

            $contactPerson = ClientContactPerson::whereClientId($client->id)->first();
            $contactPerson->update($input);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            flash()->error(trans('crud.other', ['name' => 'Client']));

            return redirect()->back()->withInput();
        }

        flash()->success(trans('crud.update_success', ['name' => 'Client']));

        return redirect('/backend/client');

    }

    public function postDelete(ClientRequest $request)
    {
        DB::beginTransaction();
        try {
            $client = Client::findOrFail($request->id);
            $client->delete();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            flash()->error(trans('crud.other', ['name' => 'Client']));

            return redirect()->back()->withInput();
        }

        flash()->success(trans('crud.delete_success', ['name' => 'Client']));

        return redirect('/backend/client');
    }
}