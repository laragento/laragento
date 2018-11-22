<?php

namespace Laragento\Admin\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class AdminRole
 * @package Laragento\Admin\Models
 *
 * @property int id
 * @property string name
 */
class AdminRole extends Model
{
    protected $table = 'lg_admin_roles';
    public $timestamps = false;
    protected $fillable = [
        'name'
    ];

    public function users()
    {
        return $this->belongsToMany(AdminUser::class, 'lg_admin_user_admin_role', 'role_id', 'user_id');
    }
}
