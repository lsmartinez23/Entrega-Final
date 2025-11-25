<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model {
    protected $table = "users";
    protected $fillable = ["name", "email", "password", "role"];

    public function token()
    {
        return $this->hasOne(AuthToken::class, "user_id");
    }
}
