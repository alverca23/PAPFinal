<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Database\Factories\UserFactory;




use Tymon\JWTAuth\Contracts\JWTSubject;

class Plan_exercise extends Model implements AuthenticatableContract, AuthorizableContract, JWTSubject
{
    use Authenticatable, Authorizable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'Sets',
        'Reps'
    ];
    protected $table = 'plan_exercise';

    public function plan()
    {
        return $this->belongsTo(Plan::class, 'id_plans');
    }

    public function exercise()
    {
        return $this->belongsTo(Exercise::class, 'id_exer');
    }
    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */


    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}