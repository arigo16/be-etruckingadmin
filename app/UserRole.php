<?php 
namespace App;

use Illuminate\Database\Eloquent\Model;

class UserRole extends Model {
    protected $fillable = [
        'role_name',
        'menu_id',
        'created_at',
        'updated_at',
        'deleted_at',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $hidden = [ 

    ];
}