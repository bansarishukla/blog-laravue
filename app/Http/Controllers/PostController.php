<?php
namespace App\Http\Controllers;
use App\Post;
use App\Category;
use Illuminate\Http\Request;
class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::with('categories')->get();
        return view('admin.adminhome', compact(['posts']));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
        'name' => 'required|max:500',
        'description' => 'required|min:1',
        ]);
        $formData= new Post;
        $formData->name = $request->name;
        $formData->description = $request->description;
        $formData->save();
        $formData->categories()->attach($request->categories);
        $formData->categories;
        return response()->json([
        'formData' => $formData
        ]);
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        //
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::with('categories')->findOrFail($id);
        return view('admin.edit', compact('post'));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $postData = Post::with('categories')->findOrFail($id);
        $postData->name = $request->name;
        $postData->description = $request->description;
        $postData->save();
        $postData->categories()->sync($request->categories);
        return response()->json([
            'formData' => $postData
        ]);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $formData = Post::findOrFail($id);
        $formData->delete();
        return response()->json([
            'status' => 'Deleted'
        ]);
    }
    public function getPosts(Request $request)
    {
        $posts = Post::all();
        $categories = Category::all();
        return view('welcome', compact('posts', 'categories'));
    }
    public function readMore($id) {
        $posts = Post::findOrFail($id);
        return view('displayPost', compact('posts'));
    }
    public function filterByCategory ($id)
    {
        $category = Category::find($id);
        $posts = $category->posts;
        return view('showPostsByCategory',compact('posts', 'category'));
    }
}
