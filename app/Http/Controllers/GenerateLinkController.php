<?php

namespace App\Http\Controllers;

use App\Models\ShortenerUrl;
use App\Models\User;
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
        $result = ShortenerUrl::getLimit(Auth::id());
        if ($result->is_unlimited == 1) {
            $limit =  '&infin;';
        } else {
            $limit = $result->limit;
        }
        return view('generate_link.index', compact('limit'));
    }

    public function store(Request $request)
    {
        $title = $request->title;
        $url_destination = explode(',', $request->url);
        $description = $request->description;
        $link_image_offline = null;
        $link_image_online = $request->link_image_online;
        $row_print = (int)$request->row_print;

        $result = ShortenerUrl::getLimit(Auth::id());
        if ($result->is_unlimited != 1) {
            $limit = $result->limit;
            if ($row_print > $limit) {
                return response()->json([
                    'code' => 400,
                    'status' => 'bad_request',
                    'message' => 'Sisa limit anda tidak mencukupi. Silahkan hubungi Admin',
                ], 400);
            } else {
                User::updateLimit($row_print, Auth::id());
            }
        }

        if (request()->file('link_image_offline')) {
            $file = request()->file('link_image_offline');
            $file_name = 'image-' . time() . '.' . $file->extension();

            request()->file('link_image_offline')->move('assets/images/content', $file_name);

            $link_image_offline = $file_name;
            $link_image_online = null;
        }

        if (request()->secure()) {
            $http = 'https://';
        } else {
            $http = 'http://';
        }

        $data = [];
        foreach ($url_destination as $item) {
            for ($i = 1; $i <= $row_print; $i++) {
                $subdomain = Str::random(10);
                $slug = Str::random(10);
                $data[] = [
                    'id_user' => Auth::id(),
                    'subdomain' => $subdomain,
                    'slug' => $slug,
                    'url_destination' => $item,
                    'url_short' => $http . $subdomain . '.' . env('APP_DOMAIN') . '/' . $slug,
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

        $result = ShortenerUrl::getLimit(Auth::id());
        if ($result->is_unlimited == 1) {
            $limit =  '&infin;';
        } else {
            $limit = $result->limit;
        }

        return response()->json([
            'data' => $data,
            'limit' => $limit
        ]);
    }
}
