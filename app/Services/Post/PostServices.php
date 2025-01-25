<?php

namespace App\Services\Post;

use App\Helpers\ImageHelper;
use App\Http\Requests\Dashboard\Post\PostRequest;
use App\Http\Requests\Dashboard\Post\StorePostRequest;
use App\Http\Requests\Dashboard\Post\UpdatePostRequest;
use App\Models\Post;

class PostServices
{
    public function fetch_posts()
    {
        $posts = Post::with('images')->where('user_id', auth()->user()->id)->get();
        return response()->json([
            "data" => $posts
        ]);
    }

    public function store(StorePostRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->user()->id;
        $post = Post::create($data);
        if ($request->hasFile("images")){
            foreach ($request->file('images') as $image) {
                $path = ImageHelper::uploadImage($image);
                $post->images()->create(['image' => $path]);
            }
        }
        return response()->json([
            "status" => true,
            "message" => "Post created successfully",
            "data" =>$post->load('images'),
        ]);
    }

    public function update(UpdatePostRequest $request)
    {
        $data = $request->validated();
        $postId = $data['post_id'];
        unset($data['post_id']);

        $post = Post::find($postId);

        if (!$post) {
            return response()->json([
                "status" => false,
                "message" => "Post not found",
            ], 404);
        }
        if ($post->user_id != auth()->user()->id) {
            return response()->json([
                "status" => false,
                "message" => "You are not authorized to update this post",
            ], 403);
        }
        $post->update($data);
        if ($request->hasFile("images")) {
            $newImages = $request->file('images');
            $oldImages = $post->images;
            $newImagesPaths = ImageHelper::updateImage($newImages, $oldImages);

            foreach ($newImagesPaths as $image) {
                $post->images()->create(['image' => $image]);
            }
        }
        return response()->json([
            "status" => true,
            "message" => "Post updated successfully",
            "data" => $post->load('images'),
        ]);

    }

    public function delete(PostRequest $request)
    {
        $data = $request->validated();
        $postId = $data['post_id'];
        unset($data['post_id']);

        $post = Post::find($postId);
        if (!$post) {
            return response()->json([
                "status" => false,
                "message" => "Post not found",
            ], 404);
        }
        if ($post->user_id != auth()->user()->id) {
            return response()->json([
                "status" => false,
                "message" => "You are not authorized to delete this post",
            ], 403);
        }
        foreach ($post->images as $image) {
            ImageHelper::deleteImage($image->image);
            $image->delete();
        }
        $post->delete();
        return response()->json([
            "status" => true,
            "message" => "Post deleted successfully",
        ], 200);
    }

}
