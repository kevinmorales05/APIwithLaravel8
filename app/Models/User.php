<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];
    //creo los roles
    const ROLE_SUPERADMIN = 'ROLE_SUPERADMIN';
    const ROLE_ADMIN = 'ROLE_ADMIN';
    const ROLE_USER = 'ROLE_USER';
    //la jerarquia
   // private const ROLES_HIERARCHY = [
   //     self::ROLE_SUPERADMIN => [self::ROLE_ADMIN, self::ROLE_USER],
    //    self::ROLE_ADMIN => [self::ROLE_USER],
    //    self::ROLE_USER => []
   //    ];
     private const ROLES_HIERARCHY = [
        self::ROLE_SUPERADMIN => [self::ROLE_ADMIN],
        self::ROLE_ADMIN => [self::ROLE_USER],
        self::ROLE_USER => []
       ];
    
    protected $hidden = [
        'password',
        'remember_token',
    ];
    
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    public function getJWTCustomClaims()
    {
        return [];
    }
    //relacioens eloquent

    public function articles()
    {
        return $this->hasMany('App\Models\Article');
    }
    public function comments()
    {
        return $this->hasMany('App\Models\Comment');
    }
    public function categories()
    {
        return $this->belongsToMany('App\Models\Category')->as("subscriptions");
    }
    
    //funcion para consultar el rol de manera sencilla
   // public function isGranted($role)
  //  {
  //      return $role === $this->role || in_array($role,
   //     self::ROLES_HIERARCHY[$this->role]);
   // }

    //funcion para verificar jerarquia
   public function isGranted($role)
    {
     if ($role === $this->role) {
        return true;
    }
        return self::isRoleInHierarchy($role, self::ROLES_HIERARCHY[$this->role]);
    }
    //funcion para navegar por las jerarquias
    private static function isRoleInHierarchy($role, $role_hierarchy)
    {
        if (in_array($role, $role_hierarchy)) {
        return true;
        }
        foreach ($role_hierarchy as $role_included) {
        if(self::isRoleInHierarchy($role,self::ROLES_HIERARCHY[$role_included]))
        {
            return true;
        }
        }
            return false;
    }
    //para las relaciones polimorficas
    public function userable()
    {
        return $this->morphTo();
    }

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

}
