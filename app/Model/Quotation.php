<?php

namespace App\Model;

use App\Classes\QuotationClass;
use Illuminate\Database\Eloquent\Model;

class Quotation extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'quotations';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'client_id',
        'validity',
        'quotation_no',
        'quotation_date',
        'remarks'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function client()
    {
        return $this->belongsTo('App\Model\Client');
    }

    public function items()
    {
        return $this->hasMany('App\Model\QuotationItem');
    }

    /**
     * @param $quotationNo
     * @return static
     *
     * create a temp quotation number
     */
    public static function createTempQuotation($quotationNo)
    {
        $input = (new QuotationClass())->tempQuotationRequest($quotationNo);

        $quotation = Quotation::create($input);

        return $quotation;
    }

    public function getQuotationNoAttribute($quotationNo)
    {
        return str_pad($quotationNo, 4, '0', STR_PAD_LEFT);
    }
}
