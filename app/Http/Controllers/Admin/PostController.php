<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{


public function index()
{

    $posts = Post::with('user')
        ->withCount('views')
        ->latest()
        ->paginate(10);


    return view(
        'posts.index',
        compact('posts')
    );

}



public function create()
{
    return view('posts.create');
}

public function edit(Post $post)
{
    return view('posts.edit',compact('post'));
}



public function update(Request $request, Post $post)
{

$data = $request->validate([
'title'=>'required',
'content'=>'required',
'image'=>'nullable|image'
]);


if($request->hasFile('image')){

$data['image'] =
$request->file('image')
->store('posts','public');

}


$post->update($data);


return redirect()
->route('posts.index');

}




public function store(Request $request)
{

    $data = $request->validate([

        'title'=>'required',
        'content'=>'required',
        'image'=>'nullable|image'

    ]);


    if($request->hasFile('image')){

        $data['image'] =
            $request
            ->file('image')
            ->store('posts','public');

    }


    $data['user_id'] =
        auth()->id();


    Post::create($data);


    return redirect()
        ->route('posts.index');

}





public function destroy(Post $post)
{

    if($post->image){

        Storage::disk('public')
            ->delete($post->image);

    }


    $post->delete();


    return back();

}


}
