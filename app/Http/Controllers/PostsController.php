<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;

class PostsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
     public function __construct()
     {
         $this->middleware('auth',['except' => ['index', 'show']]); //posts will be bloked except for views included
     }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $post=Post::orderBy('created_at','desc')->get();
        //$post = Post::all();
        //$post=Post::orderBy('created_at','desc')->paginate(1); //each page will have certain # of posts according to parameter passed
        return view("posts.index")->with("posts",$post);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("posts.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'body' => 'required',
            'cover-image' => 'image|nullable|mimes:jpeg,png,jpg,gif,svg|max:1999'
        ]);
        if($request->hasFile('cover_image')){
            //get file name with extension
            $fileNameWithExt = $request->file('cover_image')->getClientOriginalName();
            //get only file name
            $fileName = pathInfo($fileNameWithExt, PATHINFO_FILENAME);
            //get file extenstion
            $fileExtension = $request->file('cover_image')->getClientOriginalExtension();
            $fileNameToStore=$fileName.'_'.time().'.'.$fileExtension;
            $path = $request->file('cover_image')->storeAs('\public\cover_images',$fileNameToStore);
        }
        else{
            $fileNameToStore = 'noimage.jpg';
        }
        //store the post
        $post = new Post;
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        $post->user_id = auth()->user()->id;
        $post->cover_image = $fileNameToStore;
        $post->save();
        return redirect('/posts')->with('success','Post Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $posts=Post::find($id);
        return view('posts.show')->with('post',$posts);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $posts=Post::find($id);
        if(auth()->user()->id != $posts->user_id){
            return redirect('/posts')->with('error','Unauthorized page');
        }
        return view('posts.edit')->with('post',$posts);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required',
            'body' => 'required'
        ]);
        //store the post
        $post = Post::find($id);
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        $post->save();
        return redirect('/posts')->with('success','Post Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::find($id);
        if(auth()->user()->id != $post->user_id){
            return redirect('/posts')->with('error','Unauthorized page');
        }
        $post->delete();
        return redirect('/posts')->with('success','Post Removed');

    }
}
