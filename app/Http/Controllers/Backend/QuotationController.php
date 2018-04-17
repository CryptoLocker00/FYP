<?php


namespace App\Http\Controllers\Backend;


use App\Classes\QuotationClass;
use App\Http\Controllers\Controller;
use App\Http\Requests\QuotationRequest;
use App\Model\Client;
use App\Model\ItemTemplate;
use App\Model\Quotation;
use App\Model\QuotationItem;
use Illuminate\Support\Facades\DB;
use PDF;

class QuotationController extends Controller
{

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function view()
    {
        //        $invoices = Invoice::select('quotation_id')->get();
        //        $usedQuotation = [];
        //        foreach ($invoices as $invoice) {
        //            $usedQuotation[] = $invoice->quotation_id;
        //        }

        $quotations = Quotation::all();

        //        $quotations = $quotations->except($usedQuotation);

        return view('quotation.view', compact('quotations'));
    }

    /**
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function postCreate()
    {
        $quotationNo = (new QuotationClass())->getLatestQuotationNumber();
        DB::beginTransaction();
        try {
            $quotation = Quotation::createTempQuotation($quotationNo);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            flash()->error(trans('crud.other', ['name' => 'Quotation']));

            return redirect()->back();
        }

        return redirect('/backend/quotation/' . $quotation->id . '/edit');

    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function getEdit($id)
    {
        try {
            $quotation = Quotation::findOrFail($id);
            $quotationItems = QuotationItem::whereQuotationId($quotation->id)->get();
            $nextKey = empty($quotationItems) ? 0 : count($quotationItems) + 1;
        } catch (\Exception $e) {
            flash()->error(trans('crud.other', ['name' => 'Quotation']));

            return redirect()->back();
        }

        $clients = Client::all();
        $itemTemplates = ItemTemplate::all();

        return view('quotation.edit', compact('clients', 'itemTemplates', 'quotation', 'quotationItems', 'nextKey'));
    }

    /**
     * @param QuotationRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postEdit(QuotationRequest $request)
    {
        // unset item for letting eloquent handle the save easier
        $input = $request->all();
        unset($input['item']);

        $items = $request->item;

        DB::beginTransaction();
        try {
            $quotation = Quotation::findOrfail($input['id']);
            $quotation->update($input);

            $quotationItem = QuotationItem::whereQuotationId($input['id']);
            $quotationItem->delete();

            foreach ($items as $item) {
                $item['quotation_id'] = $input['id'];
                $item['item_code'] = 'Null';
                if (($item['unit_cost'] == "" && $item['description'] == "")) {
                    continue;
                }
                QuotationItem::create($item);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            flash()->error(trans('crud.update_fail', ['name' => 'Quotation']));

            return redirect()->back()->withInput();
        }

        flash()->success(trans('crud.update_success', ['name' => 'Quotation']));

        return redirect()->back();
    }

    /**
     * @param QuotationRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function postDelete(QuotationRequest $request)
    {
        $id = $request->id;
        DB::beginTransaction();
        try {
            $quotation = Quotation::findOrfail($id);

            $quotationItem = QuotationItem::whereQuotationId($id);
            $quotationItem->delete();

            $quotation->delete();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            flash()->error(trans('crud.delete_fail', ['name' => 'Quotation']));

            return redirect()->back();
        }

        flash()->success(trans('crud.delete_success', ['name' => 'Quotation']));

        return redirect('/backend/quotation');
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Throwable
     */
    public function viewPDF($id)
    {
        try {
            $quotation = Quotation::with('client')->findOrFail($id);
            $items = QuotationItem::whereQuotationId($quotation->id)->get();
        } catch (\Exception $e) {
            flash()->error(trans('crud.other', ['name' => 'Quotation']));

            return redirect()->back();
        }

        $quotationView = view('pdf.quotation', compact('items', 'quotation'))->render();

        return PDF::loadHtml($quotationView)->stream();
    }
}
