@extends('layouts.app')

@push('custom-css-end')
    <link rel="stylesheet" href="{{ asset('assets/css/pages/fontawesome.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/extensions/sweetalert2/sweetalert2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/extensions/flatpickr/flatpickr.min.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')
    <div class="page-heading">

        <!-- Basic Tables start -->
        <section class="section">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-8">
                            <form id="form">
                                <div class="form-group">
                                    <label for="input-url">Long URL</label>
                                    <textarea id="input-url" name="url" class="form-control" rows="5"
                                        placeholder="https://...&#10;https://...&#10;https://..." required></textarea>
                                </div>

                                <div class="form-group">
                                    <label for="input-title">Judul</label>
                                    <input id="input-title" name="title" type="text" class="form-control" required>
                                </div>

                                <div class="form-group">
                                    <label for="input-description">Deskripsi</label>
                                    <input id="input-description" name="description" type="text" class="form-control"
                                        required></input>
                                </div>

                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="input-jumlah-cetak">Url Gambar</label>
                                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                                <li class="nav-item" role="presentation">
                                                    <a class="nav-link active" id="home-tab" data-bs-toggle="tab"
                                                        href="#home" role="tab" aria-controls="home"
                                                        aria-selected="true">Upload Image</a>
                                                </li>
                                                <li class="nav-item" role="presentation">
                                                    <a class="nav-link" id="profile-tab" data-bs-toggle="tab"
                                                        href="#profile" role="tab" aria-controls="profile"
                                                        aria-selected="false">Use URL</a>
                                                </li>
                                            </ul>
                                            <div class="tab-content" id="myTabContent">
                                                <div class="tab-pane fade show active" id="home" role="tabpanel"
                                                    aria-labelledby="home-tab">
                                                    <p class='my-2'>
                                                        <input type="file">
                                                    </p>
                                                </div>
                                                <div class="tab-pane fade" id="profile" role="tabpanel"
                                                    aria-labelledby="profile-tab">
                                                    <p class='my-2'>
                                                        <input name="link_image_online" type="text" class="form-control"
                                                            placeholder="https://website.com/image.png"></input>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="input-row-print">Cetak Berapa kali</label>
                                            <input id="input-row-print" name="row_print" type="number" value="1"
                                                class="form-control" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group mt-3">
                                    <button type="submit" class="btn btn-primary">Generate</button>
                                </div>
                            </form>
                        </div>

                        <div class="col-4">
                            <div class="form-group">
                                <label for="input-keterangan">Preview</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </section>

        <!-- Basic Tables end -->
    </div>
@endsection

@push('custom-script')
    <script src="{{ asset('assets/extensions/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/extensions/sweetalert2/sweetalert2.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            ajaxSetup()
        })

        function ajaxSetup() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            })
        }

        function isValidUrl(url) {
            var pattern = /^(https?:\/\/)?([\w\d.-]+\.[a-z]{2,})(:\d{1,5})?(\/\S*)?$/i;
            return pattern.test(url);
        }

        $('#form').submit(function(e) {
            e.preventDefault()
            let form = new FormData(this)
            var textareaValue = $("#input-url").val();
            var urlsArray = textareaValue.split('\n');

            // Remove empty strings and trim whitespace
            urlsArray = urlsArray.filter(function(url) {
                return url.trim() !== "";
            });

            // Do something with the urlsArray, for example, log it to the console
            var invalidUrls = [];
            for (var i = 0; i < urlsArray.length; i++) {
                if (!isValidUrl(urlsArray[i])) {
                    invalidUrls.push(urlsArray[i]);
                }
            }

            if (invalidUrls.length > 0) {
                Swal.fire({
                    icon: 'info',
                    title: 'Informasi!',
                    html: 'URL tidak valid :<br><ul>' +
                        invalidUrls.map(url => `<li>${url}</li>`).join('') +
                        '</ul>'
                })
            } else {
                form.append('url', urlsArray)
                $.ajax({
                    url: "{{ route('generate-link.store') }}",
                    type: "POST",
                    data: form,
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function(data) {},
                    error: function(request, msg, error) {
                        console.log(msg)
                    }
                })
            }

        })
    </script>
@endpush
