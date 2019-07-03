<?php 
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Truck extends Model {

    use SoftDeletes;

    protected $fillable = [        
        'vendor_id',
        'truck_type_id',
        'box_type_id',
        'plat_number',
        'merk',
        'model',
        'status',
        'image_stnk',
        'image_interior',
        'image_front',
        'image_back',
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

    public function truck_type()
    {
        return $this->belongsTo('App\TruckType', 'truck_type_id');
    }

    public function box_type()
    {
        return $this->belongsTo('App\BoxType', 'box_type_id');
    }
}