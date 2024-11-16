<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Folder extends Model
{
    use HasFactory;

    protected $table = 'folders';
    protected $fillable = ['title','user_id'];
    /*
    * フォルダクラスとタスククラスを関連付けするメソッド
    *
    * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */

    public function tasks()
    {
        // return $this->hasMany('App\Models\Task');
        return $this->hasMany(Task::class);  // モデルのパス直接指定してもいいけどこっちの方がたぶんいい
    }

}
