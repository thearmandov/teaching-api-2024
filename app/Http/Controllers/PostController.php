<?php

namespace App\Http\Controllers;
use App\Http\Requests\CommentRequest;
use App\Http\Requests\PostRequest;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Post;
use App\Models\Tag;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $query = Post::with('comments', 'tags');

        if ($request->has('tag')) {
            $query->whereHas('tags', function($q) use ($request) {
                $q->where('name', $request->tag);
            });
        }

        $posts = $query->get();

        return response()->json($posts);
    }

    public function getPost(Post $post) {
        $post = Post::where('id', $post->id)->with('comments', 'tags')->first();

        return response()->json($post);
    }

    public function store(PostRequest $request)
    {

        $validated_request = $request->validated();
        $post = Post::create($validated_request);


        //Do we have tags? Do they exist? If not, lets create them. 
        if ($request->has('tags')) {
            $tag_names = $request->tags;

            $existing_tags = Tag::whereIn('name', $tag_names)->get();
            $existing_tag_names = $existing_tags->pluck('name')->toArray();

            $new_tag_names = array_diff($tag_names, $existing_tag_names);
            
            $new_tags = [];
            foreach ($new_tag_names as $new_tag_name) {
                $new_tags[] = Tag::create(['name' => $new_tag_name]);
            }

            $all_tags = $existing_tags->merge($new_tags);

            $post->tags()->attach($all_tags);
        }

        return response()->json($post->load('tags'), 201);
    }

    public function setComment(CommentRequest $request, Post $post) {
        $validated_request = $request->validated();

        $comment = new Comment();
        $comment->body = $validated_request['body'];
        $post->comments()->save($comment);

        return response()->json($comment, 201);
    }
}
