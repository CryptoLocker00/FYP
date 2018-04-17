<?php


namespace App\Classes;


use App\Model\Invoice;

class InvoiceClass
{

    /**
     * get the latest invoice number
     *
     * @return int|string
     */
    public function getLatestInvoiceNumber()
    {
        $invoiceNo = 1;
        $latestInvoice = Invoice::orderBy('invoice_no', 'DESC')->first();
        if ($latestInvoice) {
            $invoiceNo = $latestInvoice->invoice_no + 1;
        }

        $invoiceNo = str_pad($invoiceNo, 4, '0', STR_PAD_LEFT);

        return $invoiceNo;
    }
}