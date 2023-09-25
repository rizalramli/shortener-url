<?php

namespace App\Http\Controllers;

use App\Models\ShortenerUrl;

class ContentController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index($slug)
    {
        $data = ShortenerUrl::getById($slug);

        if (empty($data)) {
            return abort(404);
        }

        return view('content.index', compact('data'));
    }
}
