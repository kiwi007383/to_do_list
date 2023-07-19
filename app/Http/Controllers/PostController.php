<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Unique;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    //customer create page
    public function create()
    {
        // $posts = Post::orderBy('updated_at', 'desc')->paginate(2);
        $posts = Post::when(request('searchKey'), function ($query) {
            $data_key = request('searchKey');
            $query->orWhere('title', 'like', '%' . $data_key . '%')->orWhere('description', 'like', '%' . $data_key . '%');
        })->orderBy('updated_at', 'desc')->paginate(3);
        // dd(count($posts));
        return view('create', compact('posts'));


        // $posts = Post::select('title', 'rating')->get(); // select
        // $posts = Post::where('id', '<', 67)->pluck('address');           // pluck
        // $posts = Post::where('id', '<', 50)->get()->random();               // random
        // where (true) &&
        // orWhere ||
        // $posts = Post::orWhere('rating', '3')->orWhere('address', 'yangon')->get();

        // $posts = Post::select('title', 'price', 'address')
        //     ->where('address', 'yangon')
        //     ->whereBetween('price', [3000, 5000])
        //     ->orderBy('price')
        //     ->get();

        // $posts = DB::table('posts')->where('id', '<', 30)->max('price');
        // $posts = Post::where('address', 'yangon')->exists();  // exists()
        // $posts = Post::select('id', 'title as a', 'price as $')->get();

        // $posts = Post::select('address', DB::raw('COUNT(address) as address_count'), DB::raw('MAX(price)as max_price'))
        //     ->groupBy('address')
        //     ->get()
        //     ->toArray();
        // dd($posts);

        // map each => paginate => data
        // through => paginate => pagination + data
        // $posts =  Post::get()->map(function ($post) {
        //     $post->title = strtoupper($post->title);
        //     $post->description = strtoupper($post->description);
        //     $post->price =  $post->price * 2;
        //     return $post;
        // });

        // $posts =  Post::paginate(5)->through(function ($post) {
        //     $post->title = strtoupper($post->title);
        //     $post->description = strtoupper($post->description);
        //     $post->price =  $post->price * 2;
        //     return $post;
        // });
        // dd($posts->toArray());

        // data searching..
        // $data_key = $_REQUEST['key'];
        // $posts = Post::where('address', 'like', '%' . $data_key . '%')->get();
        // dd($posts->toArray());

        // $posts = Post::when(request('key'), function ($p) {
        //     $data_key = request('key');
        //     $p->where('address', 'like', '%' . $data_key . '%');
        // })->paginate(2);

        // dd($posts->toArray());
    }

    // post create
    public function postCreate(Request $request)
    {
        // dd($request->hasFile('postImage') ? 'yes' : 'no');
        // dd($request->file('postImage'));
        $this->postValidationCheck($request);
        $data = $this->getPostData($request);
        if ($request->hasFile('postImage')) {
            $fileName = uniqid() . $request->file('postImage')->getClientOriginalName();
            $request->file('postImage')->storeAs('public', $fileName);
            $data['image'] = $fileName;
        }
        Post::create($data);
        // return view('create'); // this is the direct view file.
        // return back(); // it's like refresh the same page.
        return redirect()->route('post#createPage')->with(['insertSuccess' => 'Post created success!']);
        // return redirect('testing'); //return redirect function is taking the route's url name after the process.
        // return redirect()->route('test'); // this is taking the route name.
    }

    //post delete
    public function postDelete($id)
    {
        // first way to delete data
        Post::where('id', '=', $id)->delete();
        return back();
        // second way to delete data
        // Post::find($id)->delete();
        // return back();
    }

    // post update
    public function postUpdate($id)
    {
        $posts = Post::where('id', $id)->get();
        // dd($posts[0]);
        return view('update', compact('posts'));
    }

    // post edit
    public function postEdit($id)
    {
        $post = Post::where('id', $id)->get();
        // dd($post[0]);
        return view('edit', compact('post'));
    }

    // final update
    public function update(Request $request)
    {
        // dd($request->all());
        $this->postValidationCheck($request);
        $updateData = $this->getPostData($request);
        $id = $request->postId;

        // dd($request->file('postImage'));
        if ($request->hasFile('postImage')) {

            // delete

            $oldImageName = Post::select('image')->where('id', $id)->first()->toArray();
            $oldImageName = $oldImageName['image'];
            // dd($oldImageName);
            if ($oldImageName != null) {
                Storage::delete('public/' . $oldImageName);
            }
            $fileName = uniqid() . $request->file('postImage')->getClientOriginalName();
            $request->file('postImage')->storeAs('public', $fileName);
            $updateData['image'] = $fileName;
        }
        Post::where('id', $id)->update($updateData);
        return redirect()->route('post#createPage')->with(['UpdateSuccess' => 'Post updated success!']);
    }

    // get post data
    private function getPostData($request)
    {
        $data =  [
            'title' => $request->postTitle,
            'description' => $request->postDescription,
        ];
        $data['price'] = $request->postFee == null ? 2000 : $request->postFee;
        $data['address'] = $request->postAddress == null ? 'yangon' : $request->postAddress;
        $data['rating'] = $request->postRating == null ? 3 : $request->postRating;

        return $data;
    }

    // post validation check
    private function postValidationCheck($request)
    {
        $validationRules = [
            'postTitle' => 'required|min:5|unique:posts,title,' . $request->postId,
            'postDescription' => 'required',
            'postImage' => 'mimes:jpg,jpeg,png',
        ];

        $validationMessages = [
            'postTitle.required' => 'Post title!',
            'postTitle.min:5' => 'At least five!',
            'postTitle.unique' => 'Unique',
            'postDescription' => 'Post Description',
            'postFee.required' => 'Post fee required!',
            'postAddress.required' => 'Post address required!'
        ];

        Validator::make($request->all(), $validationRules, $validationMessages)->validate();
    }
}
