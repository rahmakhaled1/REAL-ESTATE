<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Post\PostRequest;
use App\Http\Requests\Website\SearchRequest;
use App\Http\Resources\Post\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function fetch()
    {
        $posts = Post::with('images')->latest()->paginate(10);
        return response()->json([
            "status" => true,
            "data" => PostResource::collection($posts)
        ]);
    }

    public function show(PostRequest $request)
    {
        $data = $request->validated();
        $post = Post::with("images")->whereId( $data['post_id'])->first();
        return response()->json(
            [
                "status" => true,
                "message" => "The post data has been accessed successfully.",
                "data" => new PostResource($post)
            ]
        );
    }

    public function search(SearchRequest $request)
    {
        $data = $request->validated();
        $posts = Post::with('images')->search($data)->paginate(15);

        if ($posts->isEmpty()) {
            return response()->json([
                "status" => false,
                "message" => "No posts found matching the search criteria.",
            ]);
        }
        if ($posts){
            return response()->json([
                "status" => true,
                "message" => "The post data has been accessed successfully.",
                "data" => PostResource::collection($posts)
            ]);
        }else{
            return response()->json([
                "status" => false,
                "message" => "The post data has not been accessed successfully.",
            ]);
        }


    }
}
