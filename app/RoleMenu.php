<?php 
namespace App;

use Illuminate\Database\Eloquent\Model;

class RoleMenu extends Model {
    protected $fillable = [
        'role_id',
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