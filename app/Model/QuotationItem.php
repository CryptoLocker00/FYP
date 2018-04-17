<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class QuotationItem extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'quotation_items';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'quotation_id',
        'item_code',
        'description',
        'unit_cost',
        'unit_type',
        'quantity'
    ];

}
