<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'img',
        'img_preview',
        'user_id'
    ];

    public function ownedBy(User $user){
        return $user->id === $this->user_id;
    }
}
