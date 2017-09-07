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
            ->addColumn('action', function($article) {
                return '<a id="' . $article->id . '" data-target="#delModal" href="#delModal" role="button" class="btn btn-large btn-primary edit" data-toggle="modal" data-article-title="'.$article->title.'" data-article-description="'.$article->description.'" data-article-main_image="'.$article->main_image.'" data-article-data="'.$article->data.'" data-article-url="'.$article->url.'">Edit</a> <a href="#delModal" id="' . $article->id . '" data-target="#delModal" role="button" class="btn btn-large btn-primary delete" data-toggle="modal" >Delete</a>';
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
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        $status = 'fail';
        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'main_image' => $request->main_image,
            'url' => $request->url,
            'data' => $request->data
        ];

        $article = Article::create($data);
        if ($article->exists){
            $status = 'ok';
        }

        return response()->json(['status' => $status]);

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
     * Update the specified article
     *
     * @param  Request  $request
     * @param  string  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
       $status = 'fail';

        $article = Article::where('id', $request->id)->first();
        if($article) {
            $article
                ->update(['title' => $request->title, 'description' => $request->description, 'main_image' => $request->main_image, 'url' => $request->url, 'data' => $request->data]);
            $status = 'ok';
        }

        return response()->json(['status' => $status]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $status = 'fail';
        $article = Article::where('id', $id)->first();
        if($article){
            $article->delete();
            $status = 'ok';
        }
        return response()->json(['status' => $status]);
    }
}
