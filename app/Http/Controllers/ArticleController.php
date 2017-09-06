<?php

namespace App\Http\Controllers;

use App\Article;
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
                return '<a id="' . $id->id . '" data-target="#myModal" href="#myModal" role="button" class="btn btn-large btn-primary" data-toggle="modal" class="btn btn-primary">Edit</a> <a href="#myModal" role="button" class="btn btn-large btn-primary" data-toggle="modal" class="btn btn-primary">Delete</a>';
            })
            ->make(true);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
       Article::where('id', $id)->first()->delete();
    }
}
