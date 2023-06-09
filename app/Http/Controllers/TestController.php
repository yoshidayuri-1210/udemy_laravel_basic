<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Test;

use Illuminate\Support\Facades\DB;


class TestController extends Controller
{
    //
    public function index()
    {
        dd('test');
        
        // Eloquent(エロクアント) モデルを利用してデータを取得　ORM
        $values = Test::all(); // Eloquent\Collection
        
        $count = Test::count(); //int

        $first = Test::findOrFail(1); //Modelのインスタンス

        $whereBBB = Test::where('text', '=', 'bbb');//Eloquent\Builder になるので、->get() をつけることでCollectionになる。これをつけ忘れる場合あり。

        // クエリビルダ
        $queryBuilder = DB::table('tests')->where('text', '=', 'bbb')
        ->select('id', 'text')
        ->get();

        // dd($values, $count, $first, $whereBBB, $queryBuilder);

        return view('tests.test', compact('values'));

    }
}
