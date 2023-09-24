@php
    $sql = 'SELECT * FROM instansi';
    
    $result = DB::selectOne($sql);
@endphp
@php
    $role_user = '';
@endphp
@if (Auth::check())
    @foreach (auth()->user()->getRoleNames() as $role)
        @php
            $role_user = $role;
        @endphp
    @endforeach
@endif
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $result->nama_sekolah }}</title>
    <link rel="stylesheet" href="{{ asset('assets/css/main/app.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/pages/error.css') }}">
    <link rel="shortcut icon" href="{{ asset('assets/images/logo/' . $result->logo) }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ asset('assets/images/logo/' . $result->logo) }}" type="image/png">
</head>

<body>
    <div id="error">


        <div class="error-page container">
            <div class="col-md-8 col-12 offset-md-2">
                <div class="text-center">
                    <img class="img-error" src="{{ asset('assets/images/samples/error-500.svg') }}" alt="Not Found">
                    <h1 class="error-title">System Error</h1>
                    <p class="fs-5 text-gray-600">Halaman yang anda akses mengalami kendala di server. Kontak admin
                        untuk memperbaikinya</p>
                    @if ($role_user == 'Admin')
                        <a href="{{ route('absensi.daftar-absensi.index') }}"
                            class="btn btn-lg btn-outline-primary mt-3">Kembali</a>
                    @else
                        <a href="{{ route('home') }}" class="btn btn-lg btn-outline-primary mt-3">Kembali</a>
                    @endif
                </div>
            </div>
        </div>


    </div>
</body>

</html>
