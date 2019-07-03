<?php 
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UsersAlias extends Model {

    use SoftDeletes;

    protected $fillable = [
        'fullname',
        'company_name',
        'bank_name',
        'images',
        'account_name',
        'account_number',
        'is_forwarder',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $hidden = [ 

    ];

    protected $dates = ['deleted_at'];
}