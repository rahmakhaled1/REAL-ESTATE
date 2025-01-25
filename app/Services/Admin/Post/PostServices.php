<?php

namespace App\Services\Admin\Post;

use App\Helpers\ImageHelper;
use App\Http\Requests\Admin\Post\PostRequest;
use App\Http\Requests\Admin\Post\UpdatePostRequest;
use App\Models\Post;

class PostServices
{
    public function fetch_posts()
    {
        $posts = Post::with('images')->paginate(10);
        return response()->json([
            "data" => $posts
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
