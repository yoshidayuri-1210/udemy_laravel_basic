<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactForm extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'title',
        'email',
        'url',
        'gender',
        'age',
        'contact',
    ];

    public function scopeSearch($query, $search){
        if($search !== null){
            $search_split = mb_convert_kana($search, 's'); //全角を半角の空白に変換する
            $search_split2 = preg_split('/[\s]+/', $search_split); //半角空白で区切って配列に入れる

            foreach($search_split2 as $value) {
                $query->where('name', 'like', '%' . $value . '%');
            }
        }
        return $query;
    }
}
