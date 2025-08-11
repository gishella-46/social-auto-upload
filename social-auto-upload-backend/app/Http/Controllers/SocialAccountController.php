<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SocialAccountController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        // TODO: Implement social accounts listing
        return response()->json([
            'status' => 'success',
            'data' => []
        ], 200);
    }

    public function connect(Request $request)
    {
        // TODO: Implement social account connection
        return response()->json([
            'status' => 'success',
            'message' => 'Social account connection feature coming soon'
        ], 200);
    }

    public function destroy($id)
    {
        // TODO: Implement social account disconnection
        return response()->json([
            'status' => 'success',
            'message' => 'Social account disconnected'
        ], 200);
    }
}
