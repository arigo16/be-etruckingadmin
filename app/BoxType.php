<?php 
namespace App;

use Illuminate\Database\Eloquent\Model;

class BoxType extends Model {

    protected $fillable = [        
        'name'
    ];

    protected $hidden = [ 

    ];

    public function trucks()
    {
        return $this->hasMany('App\Truck');
    }
}