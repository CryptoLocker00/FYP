<?php

namespace App\Classes;


use App\Model\Client;
use App\Model\Quotation;
use Carbon\Carbon;

class QuotationClass
{

    /**
     * @return int|string
     * get latest quotation number
     */
    public function getLatestQuotationNumber()
    {
        $latestQuotation = Quotation::orderBy('quotation_no', 'DESC')->first();
        if ( !$latestQuotation) {
            $latestQuotationNo = 1;
        } else {
            $latestQuotationNo = $latestQuotation->quotation_no + 1;
        }
        $latestQuotationNo = str_pad($latestQuotationNo, 4, '0', STR_PAD_LEFT);

        return $latestQuotationNo;
    }

    /**
     * @param $quotationNo
     * @return mixed
     * todo change client id to null-able
     */
    public function tempQuotationRequest($quotationNo)
    {
        $client = Client::first();

        $input['client_id'] = $client ? $client->id : null;
        $input['validity'] = 0;
        $input['quotation_no'] = $quotationNo;
        $input['quotation_date'] = new Carbon();

        return $input;
    }
}
