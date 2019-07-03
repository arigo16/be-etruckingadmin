<?php 
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Driver extends Model {

    use SoftDeletes;

    protected $fillable = [
        'vendor_id',
        'driver_name',
        'username',
        'password',
        'phone_number',
        'email',
        'ktp',
        'status',
        'address',
        'image_ktp',
        'image_skck',
        'image_sim',
        'image_front',
        'image_left',
        'image_right',
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

    public function vendor()
    {
        return $this->belongsTo('App\Vendor', 'vendor_id');
    }
}