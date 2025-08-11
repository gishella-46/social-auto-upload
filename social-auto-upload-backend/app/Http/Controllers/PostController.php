<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        $posts = Post::where('user_id', Auth::id())
            ->orderBy('schedule', 'desc')
            ->get();

        return response()->json(['status' => 'success', 'data' => $posts], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:jpg,jpeg,png,mp4|max:10240',
            'caption' => 'required|string|max:2200',
            'platform' => 'required|string|in:instagram,linkedin',
            'schedule' => 'required|date|after:' . now()->toDateTimeString(),
        ]);

        $path = $request->file('file')->store('uploads', 'public');

        $post = Post::create([
            'user_id' => Auth::id(),
            'file_path' => $path,
            'caption' => $request->caption,
            'platform' => $request->platform,
            'schedule' => $request->schedule,
            'status' => 'scheduled',
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Postingan berhasil dijadwalkan',
            'data' => $post
        ], 201);
    }

    public function show($id)
    {
        $post = Post::where('user_id', Auth::id())->findOrFail($id);
        return response()->json(['status' => 'success', 'data' => $post], 200);
    }

    public function update(Request $request, $id)
    {
        $post = Post::where('user_id', Auth::id())->findOrFail($id);

        $request->validate([
            'caption' => 'nullable|string|max:2200',
            'platform' => 'nullable|string|in:instagram,linkedin',
            'schedule' => 'nullable|date|after:' . now()->toDateTimeString(),
            'file' => 'nullable|file|mimes:jpg,jpeg,png,mp4|max:10240',
        ]);

        if ($request->hasFile('file')) {
            if ($post->file_path && Storage::disk('public')->exists($post->file_path)) {
                Storage::disk('public')->delete($post->file_path);
            }
            $post->file_path = $request->file('file')->store('uploads', 'public');
        }

        $post->caption = $request->caption ?? $post->caption;
        $post->platform = $request->platform ?? $post->platform;
        $post->schedule = $request->schedule ?? $post->schedule;

        $post->save();

        return response()->json(['status' => 'success', 'message' => 'Postingan berhasil diperbarui', 'data' => $post], 200);
    }

    public function destroy($id)
    {
        $post = Post::where('user_id', Auth::id())->findOrFail($id);

        if ($post->file_path && Storage::disk('public')->exists($post->file_path)) {
            Storage::disk('public')->delete($post->file_path);
        }

        $post->delete();

        return response()->json(['status' => 'success', 'message' => 'Postingan berhasil dihapus'], 200);
    }
}
