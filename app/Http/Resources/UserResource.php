<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * UserRecource
 *
 * @package    App\Http\Resources
 * @subpackage Resources
 * @author     Abhishek Dixit<abhishekdixit342@gmail.com>
 */
class UserResource extends JsonResource
{
    /**
     * msg for resource
     */
    public $msg;
    /**
     * The resource constructor
     */
    public function __construct($resource,$msg=null)
    {
        parent::__construct($resource);
        $this->msg = $msg;
    }
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        if ($this->resource===null) {
            return [];
        }
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'age' => $this->age,
            'points' => $this->points,
            'address' => $this->address,
        ];
    }
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function with($request): array
    {
        return [
            'status' => true,
            'message' => $this->msg,
        ];
    }
}
