<?php 
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vendor extends Model {

    use SoftDeletes;

    protected $fillable = [
        'vendor_name',
        'phone_number',
        'company_name',
        'npwp',
        'bank_name',
        'account_bank',
        'account_bank_name',
        'created_at',
        'updated_at',
        'deleted_at',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $hidden = [ 

    ];

    protected $dates = ['deleted_at'];
}