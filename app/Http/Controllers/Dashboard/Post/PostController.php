<?php

namespace App\Http\Controllers\Dashboard\Post;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Post\PostRequest;
use App\Http\Requests\Dashboard\Post\StorePostRequest;
use App\Http\Requests\Dashboard\Post\UpdatePostRequest;
use App\Models\Post;
use App\Services\PostServices;

class PostController extends Controller
{
    public function __construct(protected PostServices $post_services){}

    public function fetch_posts()
    {
        return $this->post_services->fetch_posts();
    }
    public function store(StorePostRequest $request)
    {
        return $this->post_services->store($request);
    }
    public function update(UpdatePostRequest $request)
    {
        return $this->post_services->update($request);
    }
    public function delete(PostRequest $request)
    {
        return $this->post_services->delete($request);
    }
}
