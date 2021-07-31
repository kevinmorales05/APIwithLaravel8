<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class User extends JsonResource
{
    protected $token;
    //metodo 2 con constructor, es mas directo
    public function __construct($resource, $token = null)
    {
      parent:: __construct($resource);
      $this->token = $token;
    }

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
         //   'userable'=> $this->userable,
         // 'credential_number'=> $this->userable->credential_number,
         //manejo de condicionales
          //  'credential_number'=> $this->when(Auth::user()->userable_type == 'App\Models\Admin', $this->userable->credential_number),
            ///$this -> mergeWhen(Auth::user()->userable_type == 'App\Models\Admin', $this->userable),
            $this -> merge( $this->userable), //es mas simplificado
          'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'token' => $this->when($this->token, $this->token)

            ];
    }
    //este es el metodo 1

   // public function token($token){
     // $this->token = $token;
    //}
}
