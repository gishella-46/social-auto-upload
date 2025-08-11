<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;

class SchedulerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function getScheduledPosts()
    {
        $posts = Post::where('status', 'scheduled')
            ->where('schedule', '<=', now())
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $posts
        ], 200);
    }

    public function updatePostStatus(Request $request)
    {
        $request->validate([
            'post_id' => 'required|exists:posts,id',
            'status' => 'required|in:posted,failed',
            'message' => 'nullable|string'
        ]);

        $post = Post::findOrFail($request->post_id);
        $post->status = $request->status;
        $post->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Post status updated successfully'
        ], 200);
    }
}
