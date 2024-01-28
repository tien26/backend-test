<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email', 'password', 'roles'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function scopeDetail($query, $filter)
    {
        return DB::table('users as a')
            ->join('user_details as b', 'b.user_id', '=', 'a.id')
            ->select(
                'a.id',
                'a.email',
                'a.roles',
                'b.name',
                'b.sim',
                'b.phone',
                'b.photo',
            )
            ->when($filter, function ($query, $user) {
                return $query->where('a.id', $user);
            })
            // ->when($filter['status'], function ($query, $status) {
            //     return $query->where('a.status', $status);
            // })
            ->orderBy('a.updated_at', 'desc');
    }
}
