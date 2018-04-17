<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ItemTemplate extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'items_template';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'item_code',
        'description',
        'unit_cost'
    ];
}