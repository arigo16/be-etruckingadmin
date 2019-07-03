<?php 
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model {

    use SoftDeletes;

    protected $fillable = [
        'customer_name',
        'username',
        'password',
        'phone_number',
        'email',
        'ktp',
        'status',
        'address',
        'image_ktp',
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

    public function user_aliases()
    {
        return $this->hasMany('App\UsersAlias', 'customer_id');
    }
}