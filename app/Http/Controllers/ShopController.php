<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Area;
use App\Models\Shop;

class ShopController extends Controller
{
    public function index(){
        //親から子を取得する
        $shops = Area::find(1)->shops;

        //子から親を取得する
        $area = Shop::find(1)->area;
        dd($area);
    }
}
