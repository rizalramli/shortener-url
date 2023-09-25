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
                        <div class="col-12">
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
                                            <label for="">Url Image</label>
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
                                                        <input type="file" id="link-image-offline"
                                                            name="link_image_offline">
                                                    </p>
                                                </div>
                                                <div class="tab-pane fade" id="profile" role="tabpanel"
                                                    aria-labelledby="profile-tab">
                                                    <p class='my-2'>
                                                        <input id="link-image-online" name="link_image_online"
                                                            type="text" class="form-control"
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
                    </div>
                </div>
            </div>

        </section>

        <section id="result" class="section">
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

            urlsArray = urlsArray.filter(function(url) {
                return url.trim() !== "";
            });

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
                var link_image_offline = $('#link-image-offline').val();
                var link_image_online = $('#link-image-online').val();

                if (link_image_offline || link_image_online) {
                    form.append('url', urlsArray)
                    $.ajax({
                        url: "{{ route('generate-link.store') }}",
                        type: "POST",
                        data: form,
                        contentType: false,
                        cache: false,
                        processData: false,
                        success: function(data) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Sukses Generate!',
                                showConfirmButton: false,
                                timer: 750
                            });
                            printResult(data);
                        },
                        error: function(request, msg, error) {
                            console.log(msg)
                        }
                    })
                } else {
                    Swal.fire({
                        icon: 'info',
                        title: 'Informasi!',
                        text: 'Mohon isi salah satu opsi untuk URL Image.',
                    });
                }

            }

        })

        function printResult(data) {
            $('#result').empty();

            const groupedData = groupBy(data, 'url_destination'); // Group data by 'url_destination'

            let html = '';

            for (const urlDestination in groupedData) {
                if (groupedData.hasOwnProperty(urlDestination)) {
                    const items = groupedData[urlDestination];

                    html += `<div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header bg-primary">
                            <h6 class="text-white">${urlDestination}</h6>
                        </div>
                        
                        <div class="card-body mt-3">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <tbody>`;

                    for (let i = 0; i < items.length; i++) {
                        const item = items[i];
                        html += `<tr>
                            <td width="2%">${i + 1}</td>
                            <td>${item.url_short}</td>
                            <td width="5%"><button class="btn btn-sm btn-primary copy-button" data-placement="top" title="Copy">Copy</button></td>
                        </tr>`;
                    }

                    html += `</tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>`;
                }
            }

            $('#result').html(html);

            // Add click event handler for copy buttons
            $('.copy-button').click(function() {
                const urlShort = $(this).closest('tr').find('td:nth-child(2)').text();
                if (copyToClipboard(urlShort)) {
                    // Show SweetAlert success notification
                    Swal.fire({
                        icon: 'success',
                        title: 'Copied!',
                        showConfirmButton: false,
                        timer: 750
                    });
                }
            });
        }

        function copyToClipboard(text) {
            const tempInput = $('<input>');
            $('body').append(tempInput);
            tempInput.val(text).select();
            try {
                document.execCommand('copy');
                tempInput.remove();
                return true;
            } catch (err) {
                tempInput.remove();
                return false;
            }
        }

        function groupBy(array, property) {
            return array.reduce(function(acc, obj) {
                const key = obj[property];
                if (!acc[key]) {
                    acc[key] = [];
                }
                acc[key].push(obj);
                return acc;
            }, {});
        }
    </script>
@endpush
