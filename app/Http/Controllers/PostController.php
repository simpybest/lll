<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param PostRequest $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function __construct()
    {
        $this->middleware('auth')->except('index','show');
    }
    public function index(Request $request)
    {
        if ($request->search){
            $posts = Post::join('users','author_id','=','users.id')
                ->where('title','Like','%'.$request->search.'%')
                ->orWhere('desc','Like','%'.$request->search.'%')
                ->orWhere('name','Like','%'.$request->search.'%')
                ->orWhere('category','Like','%'.$request->search.'%')
                ->orderBy('posts.created_at','desc')
                ->get();
            return view('posts.index', compact('posts'));
        }

        $posts = Post::join('users','author_id','=','users.id')
            ->orderBy('posts.created_at','desc')
            ->paginate(4);
        return view('posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(PostRequest $request)
    {
        $post = new Post();
        $post->title = $request->title;
        $post->short_title = Str::length($request->title)>30 ? Str::substr($request->title, 0, 30).'...':$request->title;
        $post->desc = $request->desc;
        $post->category = $request->category;
        $post->status = "Новая";
        $post->author_id = \Auth::user()->id;

        if ($request->file('img')){
            $path = Storage::putfile('public',$request->file('img'));
            $url = Storage::url($path);
            $post->img = $url;
        }

        $post->save();

        return redirect()->route('post.index')->with('success','Пост успешно создан');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        $post = Post::join('users','author_id','=','users.id')
            ->find($id);
        return view('posts.show',compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $post = Post::find($id);
        return view('posts.edit',compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(PostRequest $request, $id)
    {
        $post = Post::find($id);
        if (Auth::user()->admin != "yes") {
            if ($post->author_id != \Auth::user()->id) {
                return redirect()->route('post.index');
            }
        }

        $post->title = $request->title;
        $post->short_title = Str::length($request->title)>30 ? Str::substr($request->title, 0, 30).'...':$request->title;
        $post->desc = $request->desc;
        $post->category = $request->category;
        if (Auth::user()->admin == "yes") {
        $post->status = $request->status;
        }

        if ($request->file('img')){
            $path = Storage::putfile('public',$request->file('img'));
            $url = Storage::url($path);
            $post->img = $url;
        }

        $post->update();
        $id = $post->post_id;
        return redirect()->route('post.show', compact('id'))->with('success','Пост успешно обновлен');

    }




    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $post = Post::find($id);
        if (Auth::user()->admin != "yes") {
            if ($post->author_id != \Auth::user()->id) {
                return redirect()->route('post.index');
            }
        }
        $post->delete();
        return redirect()->route('post.index')->with('success','Пост успешно удален');
    }

    public function user(Request $request)
    {
        if ($request->search){
            $posts = Post::join('users','author_id','=','users.id')
                ->where('title','Like','%'.$request->search.'%')
                ->orWhere('desc','Like','%'.$request->search.'%')
                ->orWhere('name','Like','%'.$request->search.'%')
                ->orderBy('posts.created_at','desc')
                ->get();
            return view('posts.index', compact('posts'));
        }

        $posts = Post::join('users','author_id','=','users.id')
            ->orderBy('posts.created_at','desc')
            ->paginate();
        return view('posts.user', compact('posts'));
    }


}
