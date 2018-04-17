<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'invoice';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'quotation_id',
        'invoice_no',
        'date',
        'your_references',
        'do_no',
        'validity',
        'remarks'
    ];

    /**
     * quotation relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function quotation()
    {
        return $this->belongsTo('App\Model\Quotation');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function items()
    {
        return $this->hasMany('App\Model\InvoiceItem');
    }

    /**
     * @param $invoiceNo
     * @return string
     */
    public function getInvoiceNoAttribute($invoiceNo)
    {
        return str_pad($invoiceNo, 4, '0', STR_PAD_LEFT);
    }
}
