<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SapaController extends Controller
{
    use RefreshDatabase;

    public function sapa(): string
    {
        return 'Assalamualaikum..saya sapa controller';
    }

    public function route_group_controller1(): string
    {
        return 'hai saya berasal dari method \'route_group_controller1\' dari controller \'sapa\'.';
    }

    public function route_group_controller2(): string
    {
        return 'hai saya berasal dari method \'route_group_controller2\' dari controller \'sapa\'.';
    }

    // method untuk implict binding pada controller
    public function imbinMethod(User $user)
    {
        return response()->json([
            'data' => [
                'user' => [
                    'nama' => $user->name,
                    'email' => $user->email
                ]
            ]
        ]);
    }

    public function softDelMeth(User $user)
    {
        if($user->trashed()) {
            return response()->json([
                'message' => 'User ini telah dihapus.',
                'email' => $user->email,
            ]);
        }

        return response()->json([
            'message' => 'User masih aktif.',
            'email' => $user->email,
        ]);
    }

    public function custome_key_imbin(User $user): JsonResponse
    {
        if($user->trashed())
        {
            return response()->json([
                'message' => 'User telah dihapus.',
                'nama' => $user->name,
                'email' => $user->email,
            ]);
        }

        return response()->json([
            'message' => 'User active.',
            'nama' => $user->name,
            'email' => $user->email,
        ]);
    }

    public function customKeyAndScoping(User $user, Post $post)
    {
        return response()->json([
            'data' => [
                'user' => [
                    'name' => $user->name,
                    'email' => $user->email
                ],
                'post' => [
                    'title' => $post->title,
                    'slug' => $post->slug,
                    'content' => $post->content,
                ]
            ]
        ]);
    }
}
