<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables as Datatables;
use DB;

class ArticleController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function datatable()
    {
        return view('article.index');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function getPosts()
    {
        $articles = DB::table('articles')->select('*');
        return Datatables::of($articles)
            ->addColumn('action', function($id) {
                return '<a href="articles/' . $id->id . '/edit" class="btn btn-primary">Edit</a><a href="articles/' . $id->id . '/edit" class="btn btn-primary">Delete</a>';
            })
            ->make(true);
    }
}
