<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class Broker extends Authenticatable
{
    use HasFactory ,HasRoles,HasApiTokens;


     /** this method using by default if u want to edit
     * Find the user instance for the given username.
     *
     * @param  string  $username
     * @return \App\Models\User
     */
    // public function findForPassport($username) // username any value /mobile / email  if mobile or email us orWhere('mobile)
    // {
    //     return $this->where('username', $username)->first();
    // }
    // /**
    //  * Validate the password of the user for the Passport password grant.
    //  *
    //  * @param  string  $password
    //  * @return bool
    //  */
    // public function validateForPassportPasswordGrant($password)
    // {
    //     return Hash::check($password, $this->password);
    // }
}
