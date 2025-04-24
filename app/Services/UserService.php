<?php
namespace App\Services;
use App\Models\User;

/**
 * UserService
 * 
 * @package    App\Services
 * @subpackage Services
 * @author     Abhishek Dixit<abhishekdixit342@gmail.com>
 */ 
class UserService
{

    /**
     * Get all users.
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */

    public function getAllUsers($filter = true)
    {
        if ($filter) {
            return User::filter($filter)->orderBy('points', 'desc')->get();
        }
        return User::orderBy('points', 'desc')->get();
        
    }

    /**
     * Get a user by ID.
     *
     * @param int $id
     * @return \App\Models\User|null
     */

    public function getUserById($id)
    {
        return User::find($id);
    }
    /**
     * Create a new user.
     *
     * @param array $data
     * @return \App\Models\User
     */

    public function createUser($data)
    {
        return User::create($data);
    }
    /**
     * Update a user by ID.
     *
     * @param int $id
     * @param array $data
     * @return \App\Models\User|null
     */
    public function updateUser($id, $data)
    {
        $user = User::find($id);
        if ($user) {
            $user->update($data);
            return $user;
        }
        return null;
    }
    /**
     * Delete a user by ID.
     *
     * @param int $id
     * @return bool
     */
    public function deleteUser($id)
    {
        $user = User::find($id);
        if ($user) {
            $user->delete();
            return true;
        }
        return false;
    }

    /**
     * Get the points of user grouping them by points.
     *
     * @return \Illuminate\Http\Response
     */
    public function groupPoints()
    {
        $results = User::selectRaw('points, avg(age) as average_age, GROUP_CONCAT(name) as names')
            ->groupBy('points')
            ->orderBy('points', 'desc')
            ->get()->map(function ($item) {
                return [$item->points=>[
                   
                    'average_age' => round($item->average_age,2),
                    'names' => explode(',', $item->names),
                ]];
            });
    
        return $results;
    }
}
