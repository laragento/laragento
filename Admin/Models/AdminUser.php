<?php

namespace Laragento\Admin\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laragento\Admin\Notifications\ResetCustomerPassword;

/**
 * @property int user_id
 * @property string|null firstname
 * @property string|null lastname
 * @property string|null email
 * @property string username
 * @property string password
 * @property \Carbon\Carbon created
 * @property \Carbon\Carbon modified
 * @property \Carbon\Carbon|null logdate
 * @property int lognum
 * @property int reload_acl_flag
 * @property int is_active
 * @property string|null extra
 * @property string|null rp_token
 * @property \Carbon\Carbon|null rp_token_created_at
 * @property string interface_locale
 * @property int|null failures_num
 * @property \Carbon\Carbon|null first_failure
 * @property \Carbon\Carbon|null lock_expires
 * @property string|null refresh_token
 * **/
class AdminUser extends Authenticatable
{
    use Notifiable;

    protected $table = 'lg_admin_users';

    protected $guard = 'admins';

    protected $fillable = [
        'firstname',
        'lastname',
        'email',
        'username',
        'password',
        'created_at',
        'updated_at'
    ];
    protected $hidden =
        [
            'password',
            'remember_token'
        ];

    public function roles()
    {
        return $this->belongsToMany(AdminRole::class, 'lg_admin_user_admin_role', 'user_id', 'role_id');
    }

    public function hasRole($roleName)
    {
        return $this->roles()->where('name', $roleName)->count() > 0;
    }

    /**
     * Send the password reset notification.
     *
     * @param  string $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetCustomerPassword($token));
    }

}
