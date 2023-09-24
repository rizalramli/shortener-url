<?php

namespace App\Http\Controllers;

use App\Models\ShortenerUrl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class GenerateLinkController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('generate_link.index');
    }

    public function store(Request $request)
    {
        $title = $request->title;
        $url_destination = explode(',', $request->url);
        $description = $request->description;
        $link_image_offline = null;
        $link_image_online = $request->link_image_online;
        $row_print = (int)$request->row_print;

        $data = [];
        foreach ($url_destination as $item) {
            for ($i = 1; $i <= $row_print; $i++) {
                $slug = Str::random(10);
                $data[] = [
                    'id_user' => Auth::id(),
                    'slug' => $slug,
                    'url_destination' => $item,
                    'url_short' => request()->getHost() . '/' . $slug,
                    'visitors' => 0,
                    'title' => $title,
                    'description' => $description,
                    'link_image_offline' => $link_image_offline,
                    'link_image_online' => $link_image_online,
                    'created_at' => now(),
                    'updated_at' => now()
                ];
            }
        }

        ShortenerUrl::simpanData($data);

        return response()->json($data);
    }
}
