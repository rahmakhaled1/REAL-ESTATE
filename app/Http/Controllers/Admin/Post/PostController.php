<?php

namespace App\Http\Controllers\Admin\Post;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Post\PostRequest;
use App\Http\Requests\Admin\Post\UpdatePostRequest;
use App\Services\Admin\Post\PostServices;

class PostController extends Controller
{
    public function __construct(protected PostServices $post_services){}

    public function fetch_posts()
    {
        return $this->post_services->fetch_posts();
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
