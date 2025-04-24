<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * User Model
 * @package    App\Models
 * @subpackage Models
 * @author     Abhishek Dixit<abhishekdixit342@gmail.com> 
 */

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable,SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'age',
        'points',
        'address',
    ];
    /**
     * filterable attributes
     */
    protected $filterable = [
        'name',
        'email',
        'age',
        'points',
        'address',
    ];
    /**
     *  scope for filtering
     * @param $query
     */
    public function scopeFilter($query)
    {
        foreach ($this->filterable as $attribute) {
            if (request()->has($attribute)) {
                $input = request()->get($attribute);
                if (is_array($input)) {
                    $query->whereIn($attribute, $input);
                } elseif (is_numeric($input)) {
                    $query->where($attribute, $input);
                } else {
                    $query->where($attribute, 'like', '%' . $input . '%');
                }
            }
        }
    }
    /**
     * winner relation
     */
    public function winner()
    {
        return $this->hasOne(Winner::class);
    }


}
