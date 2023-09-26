<?php

namespace App\Http\Controllers;

use App\Models\ShortenerUrl;

class ContentController extends Controller
{

    public function index($subdomain, $slug)
    {
        $data = ShortenerUrl::getById($subdomain, $slug);

        if (empty($data)) {
            return abort(404);
        } else if ($data->link_image_offline == null && $data->link_image_online == null) {
            $visitor = ShortenerUrl::updateVisitor($subdomain, $slug);
            return redirect($data->url_destination);
        }

        $visitor = ShortenerUrl::updateVisitor($subdomain, $slug);

        return view('content.index', compact('data'));
    }
}
