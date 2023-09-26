<?php

namespace App\Http\Controllers;

use App\Models\ShortenerUrl;

class ContentController extends Controller
{

    public function index($slug)
    {
        $data = ShortenerUrl::getById($slug);

        if (empty($data)) {
            return abort(404);
        }

        $visitor = ShortenerUrl::updateVisitor($slug);

        return view('content.index', compact('data'));
    }
}
