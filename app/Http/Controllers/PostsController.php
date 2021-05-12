<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Contracts\Cache\Store;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Validator;
use Illuminate\Support\Facades\Storage;
class PostsController extends Controller
{
    //Adding the middleware for authentication purpose
    //Only logged users will be able to create and edit posts
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index','show']]);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$posts = Post::all();
        //return Post::where('title','Post Two')->get();
        //$posts = DB::select('SELECT * FROM posts');
        $posts = Post::orderBy('created_at','desc')->paginate(2); //here $post is an array of all the posts
        return view('posts/index')->with('posts',$posts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('posts/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   //Validating the required fields in here
        $this->validate($request,[
            'title' => 'required',
            'body' => 'required',
            'cover_image' => 'image|nullable|max:1999' //max:1999 coz apache servers max limit is 2 megabytes
        ]);
        //Handle File Upload
        if($request->hasFile('cover_image')){
            //Get File Name with extension
            $filenameWithExt = $request->file('cover_image')->getClientOriginalName();
            //Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            //Get just ext
            $extension = $request->file('cover_image')->getClientOriginalExtension();
            // Filename to store
            $fileNameToStore = $filename.'_'.time().'.'.$extension; //This format makes the file unique.
            // Upload Image
            $path = $request->file('cover_image')->storeAs('public/cover_images', $fileNameToStore);

        }else{
            $fileNameToStore = 'noimage.jpg';
        }

        //Creating Post
        $post = new Post;
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        //For obtaining the user id after the authentication has been enabled.
        $post->user_id = auth()->user()->id;
        $post->cover_image = $fileNameToStore;
        $post->save();
        return redirect('/posts')->with('message','Post has been created successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
       // $user_id = auth()->user()->id;
        $post =  Post::find($id);
        //$post = Post::find('id', $user_id)->get();

       //return $post;
       return view('posts.show')->with('post', $post);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //$user_id = auth()->user()->id;
        $post =  Post::find($id);
        /*  //Brad's code
        //Check if post exists before deleting
        if (!isset($post)) {
            return redirect('/posts')->with('error', 'No Post Found');
        }
      */
        // Check for correct user
        if (auth()->user()->id !== $post->user_id) {
            return redirect('/posts')->with('error', 'You do not have access to that page !');
        }
        //$post = Post::find('id', $user_id)->get();
        return view('posts.edit')->with('post', $post);
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
        //
        $this->validate($request, [
            'title' => 'required',
            'body' => 'required'
        ]);
        // Handle File Upload
        if ($request->hasFile('cover_image')) {
            // Get Filename with extension
            $filenameWithExt = $request->file('cover_image')->getClientOriginalName();
            // Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            //Get just extension
            $extension = $request->file('cover_image')->getClientOriginalExtension();
            // filename to store
            $fileNameToStore = $filename . '_' . time() . '.' . $extension;
            // upload the image
            $path = $request->file('cover_image')->storeAs('public/cover_images', $fileNameToStore);
        } else {
            $fileNameToStore = 'noimage.jpg';
        }
        $post =  Post::find($id);
        //check if there is old file
        if ($post->cover_image != 'noimage.jpg') {
            //Use backslash if you dont want to use namespace
            Storage::delete('public/cover_images/' . $post->cover_image);
        }
        // if($request->hasFile('cover_image')){
        $post->cover_image = $fileNameToStore;
        // }
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        $post->save();
        return redirect('/posts')->with('message','Post has been updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $post = Post::find($id);
        // Check for correct user
        if (auth()->user()->id !== $post->user_id) {
            return redirect('/posts')->with('error', 'You do not have access to that page !');
        }
        if($post->cover_image != 'noimage.jpg'){
            //Delete image
            Storage::delete('public/cover_images/'.$post->cover_image);
        }
        $post->delete();
        return redirect('/posts')->with('message', 'Post has been deleted!');

    }
}
