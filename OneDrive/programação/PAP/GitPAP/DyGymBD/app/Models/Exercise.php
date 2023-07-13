<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;  
use Laravel\Lumen\Auth\Authorizable;  
use Illuminate\Database\Eloquent\Model; 
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract; 
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract; 
use Illuminate\Database\Eloquent\Factories\HasFactory;



use Tymon\JWTAuth\Contracts\JWTSubject;

class Exercise extends Model implements AuthenticatableContract, AuthorizableContract, JWTSubject
{
    use Authenticatable, Authorizable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'Name','Sets','Reps','Ficheiro','Section'
    ];

    public function plans()
    {
        return $this->belongsToMany(Plan::class, 'plan_exercise', 'id_exer', 'id_plans');
    }
    public function planExercises()
    {
        return $this->hasMany(PlanExercise::class, 'id_exer');
    }

    /*
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
