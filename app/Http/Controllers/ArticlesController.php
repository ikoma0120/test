<?php

namespace App\Http\Controllers;

use App\Http\Requests;

use App\Article;
use App\Http\Controllers\Controller;

use App\Http\Requests\ArticleRequest;

use Carbon\Carbon;



class ArticlesController extends Controller
{
  public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

    public function index() {
    // $articles = Article::all();  古いコード
    // $articles = Article::orderBy('published_at', 'desc')->get();  これでもOKです
    $articles = Article::latest('published_at')->published()->get();

    return view('articles.index', compact('articles'));
    }

    public function show($id) {
      $article = Article::findOrFail($id);

      return view('articles.show', compact('article'));
    }

    public function create()
    {
        return view('articles.create');
    }

    public function store(ArticleRequest $request) {
        $article = \Auth::user()->articles()->create($request->all());
        $article->tags()->attach($request->input('tag_list'));  // ②

        \Session::flash('flash_message', '記事を追加しました。');

        return redirect()->route('articles.index');
    }

    public function edit(Article $article) {
        $tags = Tag::lists('name', 'id');  // ③

        return view('articles.edit', compact('article', 'tags'));
    }

    public function update(Article $article, ArticleRequest $request) {
        $article->update($request->all());
        $article->tags()->sync($request->input('tag_list', []));  // ④

        \Session::flash('flash_message', '記事を更新しました。');

        return redirect()->route('articles.show', [$article->id]);
    }

    public function destroy($id) {
        $article = Article::findOrFail($id);

        $article->delete();
        \Session::flash('flash_message', '記事を削除しました。');

        return redirect('articles');
    }

}
