<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta property="og:title" content="{{ $data->title }}">
    <meta property="og:description" content="{{ $data->description }}">
    @if ($data->link_image_online != null)
        <meta property="og:image" content="{{ $data->link_image_online }}">
    @else
        <meta property="og:image" content="{{ asset('assets/images/content/' . $data->link_image_offline) }}">
    @endif
    <meta property="og:url" content="{{ $data->url_short }}">
    <meta property="og:type" content="website">
    <title>{{ $data->title }}</title>
</head>

<body>
</body>

</html>
