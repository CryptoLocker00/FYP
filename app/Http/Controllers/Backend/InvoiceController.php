<?php


namespace App\Http\Controllers\Backend;

use App\Classes\InvoiceClass;
use App\Http\Controllers\Controller;
use App\Http\Requests\InvoiceRequest;
use App\Model\Invoice;
use App\Model\InvoiceItem;
use App\Model\Quotation;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    /**
     * view all invoice
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function view()
    {
        $invoices = Invoice::with('quotation')->get();

        return view('invoice.view', compact('invoices'));
    }

    /**
     * create invoice only can create form quotation
     *
     * @param InvoiceRequest $request
     * @return $this|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function postCreate(InvoiceRequest $request)
    {
        DB::beginTransaction();
        try {
            $quotation = Quotation::findOrFail($request->id);

            $input['quotation_id'] = $quotation->id;
            $input['invoice_no'] = (new InvoiceClass())->getLatestInvoiceNumber();
            $input['date'] = new Carbon();

            $invoice = Invoice::create($input);

            $quotationItems = $quotation->items->toArray();
            $invoice->items()->createMany($quotationItems);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            flash()->error(trans('crud.other', ['name' => 'Invoice']));

            return redirect()->back()->withInput();
        }
        flash()->success(trans('crud.create_success', ['name' => 'Invoice']));

        return redirect()->route('invoice.show', ['id' => $invoice->id]);
    }

    /**
     * edit invoice
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function getEdit($id)
    {
        try {
            $invoice = Invoice::findOrFail($id);
            $quotation = Quotation::findOrFail($invoice->quotation_id);
            $invoiceItems = InvoiceItem::where('invoice_id', $invoice->id)->get();
        } catch (\Exception $e) {
            flash()->error(trans('crud.other', ['name' => 'Invoice']));

            return redirect()->back();
        }

        return view('invoice.edit', compact('invoice', 'quotation', 'invoiceItems'));
    }

    /**
     * Update invoice
     *
     * @param InvoiceRequest $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function postEdit(InvoiceRequest $request)
    {
        $input = $request->all();
        unset($input['item']);

        $items = $request->item;

        DB::beginTransaction();
        try {
            $invoice = Invoice::findOrFail($input['id']);
            $invoice->update($request->all());

            $invoiceItem = InvoiceItem::where('invoice_id', $input['id']);
            $invoiceItem->delete();

            foreach ($items as $item) {
                $item['invoice_id'] = $invoice->id;
                if (($item['unit_cost'] == "" && $item['description'] == "")) {
                    continue;
                }
                InvoiceItem::create($item);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            flash()->error(trans('crud.update_fail', ['name' => 'Invoice']));

            return redirect()->back()->withInput();
        }
        flash()->success(trans('crud.update_success', ['name' => 'Invoice']));

        return redirect()->back();
    }

    /**
     * delete Invoice
     *
     * @param InvoiceRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function postDelete(InvoiceRequest $request)
    {
        DB::beginTransaction();
        try {
            $invoice = Invoice::findOrFail($request->id);
            $invoice->items()->delete();
            $invoice->delete();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            flash()->error(trans('crud.delete_fail', ['name' => 'Invoice']));

            return redirect()->back();
        }
        flash()->success(trans('crud.delete_success', ['name' => 'Invoice']));

        return redirect('/backend/invoice');
    }

    /**
     * @param Invoice $invoice
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Throwable
     */
    public function viewPDF(Invoice $invoice)
    {
        try {
            $quotation = $invoice->quotation;
            $items = $invoice->items;
        } catch (\Exception $e) {
            flash()->error(trans('crud.other', ['name' => 'Quotation']));

            return redirect()->back();
        }

        $invoiceView = view('pdf.invoice', compact('invoice', 'items', 'quotation'))->render();

        return \PDF::loadHtml($invoiceView)->setOption('margin-bottom', '0mm')->setOption('margin-top', '0mm')->setOption('margin-right', '0mm')->setOption('margin-left', '0mm')->stream();
    }
}
