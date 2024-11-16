<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Task extends Model
{
    use HasFactory;
    /*
    *
    *ステータス（状態）定義
    *アクセサの便利なところは、
    *実際のテーブルに入っているデータの中身に応じて
    *データを加工できることにある。
    *下記コードではstatusというプロパティをこのクラスで設定していないが、
    *attiributesが管理している。そしてDBの同名カラム名から値を参照できる。
    *   
    */


    public function folder(){
        return $this->belongTo(Folder::class);
    }


    const STATUS = [
        1 => [ 'label' => '未着手', 'class' => 'label-danger' ],
        2 => [ 'label' => '着手中', 'class' => 'label-info' ],
        3 => [ 'label' => '完了', 'class' => '' ],
    ];

    /*
    *
    *ステータス（状態）ラベルのアクセサメソッド
    *
    * @return string 
    *
    */
    public function getStatusLabelAttribute()
    {
        $status = $this->attributes['status'];

        if (!isset(self::STATUS[$status])) {
            return '';
        }

        return self::STATUS[$status]['label'];
    }

    public function getStatusClassAttribute()
    {
        $status = $this->attributes['status'];

        if (!isset(self::STATUS[$status])) {
            return '';
        }

        return self::STATUS[$status]['class'];
    }

    public function getFormattedDueDateAttribute()
    {
        return Carbon::createFromFormat('Y-m-d', $this->attributes['due_date'])
        ->format('Y/m/d');
    }



}
