<?php

namespace App;

//use Spatie\Permission\Traits\HasPermissions;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['email','role_id','password_token', 'password',];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token','pivot','password_token'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

     /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier() {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims() {
        return [];
    }

    public function role()
    {
        return $this->belongsTo(Role::class,'role_id');
    }


    public function employer()
    {
        return $this->hasMany(Employer::class);
    }

    public function employee()
    {
        return $this->hasMany(Employee::class);
    }

    public function itf()
    {
        return $this->hasMany(ExternalSupervisor::class);
    }

    public function institution()
    {
        return $this->hasMany(Institution::class);
    }

    public function siwes_cordinator()
    {
        return $this->hasMany(SiwesCordinator::class);
    }

    public function siwes_supervisor()
    {
        return $this->hasMany(SiwesSupervisor::class);
    }

    public function student()
    {
        return $this->hasMany(Student::class);
    }

    public function user_permission()
    {
        return $this->belongsToMany(Permission::class);
    }
    public function training()
    {
        return $this->hasMany(Training::class);
    }
    public function section()
    {
        return $this->hasMany(Section::class);
    }
    public function module()
    {
        return $this->hasMany(Module::class);
    }

}
