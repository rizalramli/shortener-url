<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=yes">

    <meta property="og:type" content="website">
    <meta property="og:site_name" content="{{ $data->title }}">
    <meta property="og:title" content="{{ $data->title }}">
    <meta property="og:description" content="{{ $data->description }}">
    <meta property="og:url" content="{{ $data->url_short }}">
    @if ($data->link_image_online != null)
        <meta property="og:image" itemprop="image" content="{{ $data->link_image_online }}">
    @else
        <meta property="og:image" itemprop="image"
            content="{{ asset('assets/images/content/' . $data->link_image_offline) }}">
    @endif
    @if ($data->link_image_online != null)
        <meta property="twitter:image" content="{{ $data->link_image_online }}">
    @else
        <meta property="twitter:image" content="{{ asset('assets/images/content/' . $data->link_image_offline) }}">
    @endif
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ $data->url_short }}">
    <meta property="twitter:title" content="{{ $data->title }}">
    <meta property="twitter:description" content="{{ $data->description }}">

    <meta http-equiv="refresh" content="0;url={{ $data->url_destination }}">
</head>

<body>
</body>

</html>
