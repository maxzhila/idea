<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\idea;

class DashboardController extends Controller
{
    public function index(){
        $ideas=idea::orderBy('created_at','DESC');

        if (request()->has('search')) {
            $ideas = $ideas->where('content','like','%'.request()->get('search','').'%');
        }
        return view('index',[
            'ideas' => $ideas->paginate(5)
        ]);
    }
}