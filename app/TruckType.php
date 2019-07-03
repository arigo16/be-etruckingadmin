<?php 
namespace App;

use Illuminate\Database\Eloquent\Model;

class TruckType extends Model {

    protected $fillable = [        
        'config',
        'amount',
        'name',
        'jbi_1',
        'jbi_2',
        'tire'
    ];

    protected $hidden = [ 

    ];

    public function trucks()
    {
        return $this->hasMany('App\Truck');
    }
}