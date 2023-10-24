@extends('layouts.app')

@push('custom-css-end')
    <link rel="stylesheet" href="{{ asset('assets/css/pages/fontawesome.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/extensions/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/pages/datatables.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/extensions/sweetalert2/sweetalert2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/extensions/flatpickr/flatpickr.min.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')
    <div class="page-heading">

        <!-- Basic Tables start -->
        <section class="section">
            <div class="card">
                <div class="card-header">
                    <div class="float-start">
                        <button type="button" class='btn btn-primary' onclick="tambahData()">
                            Tambah Data</button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%">
                            <thead>
                                <tr>
                                    <th class="text-center" width="20%">Email</th>
                                    <th class="text-center" width="35%">Nama</th>
                                    <th class="text-center" width="10%">Sisa Limit</th>
                                    <th class="text-center" width="15%">Status Aktif</th>
                                    <th class="text-center" width="20%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </section>
        <!-- Basic Tables end -->
    </div>

    {{-- modal --}}
    <form id="form" class="form" enctype="multipart/form-data">
        <div class="modal fade text-left" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel1">Tambah Data</h5>
                        <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                            <i data-feather="x"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row mb-2">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="input-email">Email</label>
                                    <input id="input-email" type="email" name="email" class="form-control mb-3 "
                                        required />
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="input-nama">Nama</label>
                                    <input id="input-id" type="hidden" name="id">
                                    <input id="input-is-aktif" type="hidden" name="is_aktif" value="1">
                                    <input id="input-nama" type="text" name="nama" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="input-is-unlimited">Unlimited</label>
                                    <select name="is_unlimited" id="input-is-unlimited" class="form-control">
                                        <option value="0">Tidak Aktif</option>
                                        <option value="1">Aktif</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="input-limit">Limit</label>
                                    <input id="input-limit" type="text" name="limit" value="0"
                                        class="form-control rupiah mb-3" required />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary ml-1">Simpan</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <form id="form-ubah-password" class="form" enctype="multipart/form-data">
        <div class="modal fade text-left" id="myModalUbahPassword" tabindex="-1" role="dialog"
            aria-labelledby="myModalLabel1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel1">Ubah Password</h5>
                        <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                            <i data-feather="x"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row mb-2">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="password">Password Baru</label>
                                    <input type="hidden" name="id_user" id="input-id-password">
                                    <input type="password" id="password" name="password" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="konfirmasi-password">Konfirmasi Password</label>
                                    <input type="password" id="konfirmasi-password" name="konfirmasi_password"
                                        class="form-control" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary ml-1">Simpan</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@push('custom-script')
    <script src="{{ asset('assets/extensions/jquery/jquery.min.js') }}"></script>
    <script src="https://cdn.datatables.net/v/bs5/dt-1.12.1/datatables.min.js"></script>
    <script src="{{ asset('assets/js/pages/datatables.js') }}"></script>
    <script src="{{ asset('assets/extensions/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('assets/extensions/flatpickr/flatpickr.min.js') }}"></script>
    <script src="{{ asset('assets/static/js/page/date-picker.js') }}"></script>
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script>
        const formatter = Intl.NumberFormat('id-ID');

        $(document).ready(function() {
            ajaxSetup()
            initTable()
            $(".rupiah").mask('#.##0', {
                reverse: true
            });
        })

        function ajaxSetup() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            })
        }

        function initTable() {
            $('#dataTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('daftar-admin.index') }}"
                },
                columns: [{
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'nama',
                        name: 'nama'
                    },
                    {
                        data: 'limit',
                        name: 'limit'
                    },
                    {
                        data: 'is_aktif',
                        name: 'is_aktif',
                        className: 'text-center'
                    },
                    {
                        data: 'aksi',
                        name: 'aksi',
                        className: 'text-center'
                    },
                ],
            })
        }

        function reinitTable() {
            $('#dataTable').DataTable().clear().destroy()
            initTable()
        }

        function tambahData() {
            $('#input-email').prop('readonly', false);
            $('#form').trigger("reset")
            $('#myModal').modal('show')
        }

        $('#form').submit(function(e) {
            e.preventDefault()
            let form = new FormData(this)
            $.ajax({
                url: "{{ route('daftar-admin.store') }}",
                type: "POST",
                data: form,
                contentType: false,
                cache: false,
                processData: false,
                success: function(data) {
                    $('#myModal').modal('hide')
                    Swal.fire({
                        icon: 'success',
                        title: 'Sukses',
                        text: 'Data berhasil disimpan!',
                        willClose: () => {
                            reinitTable()
                        }
                    })
                },
                error: function(request, msg, error) {
                    console.log(msg)
                }
            })
        })

        function editData(id) {
            $('#myModal').modal('show')
            $.get("daftar-admin/" + id + "/edit", function(data) {
                console.log(data)
                $('#input-id').val(data.id)
                $('#input-email').val(data.email)
                $('#input-email').prop('readonly', true);
                $('#input-nama').val(data.nama)
                $('#input-is-aktif').val(data.is_aktif)
                $('#input-is-unlimited').val(data.is_unlimited)
                $('#input-limit').val(formatter.format(data.limit))
            })
        }

        function ubahPassword(id) {
            $('#myModalUbahPassword').modal('show')
            $('#input-id-password').val(id)
        }

        function updateData(id) {
            var isChecked = $("#checkbox" + id).prop("checked");
            var is_aktif;
            var text;
            (isChecked == true) ? is_aktif = 1: is_aktif = 0;
            var url = "{{ route('daftar-admin.update', ':id') }}";
            url = url.replace(':id', id);
            $.ajax({
                type: "PATCH",
                url: url,
                data: {
                    id: id,
                    is_aktif: is_aktif
                },
                success: function(res) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Sukses',
                        text: 'Status berhasil diperbarui!',
                        willClose: () => {
                            reinitTable()
                        }
                    })
                }
            })
        }

        function deleteData(id) {
            var url = "{{ route('daftar-admin.destroy', ':id') }}";
            url = url.replace(':id', id);
            Swal.fire({
                title: 'Konfirmasi',
                text: "Apakah anda yakin ingin menghapus?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, saya yakin!',
                cancelButtonText: "Batal",
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "DELETE",
                        url: url,
                        success: function(res) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Sukses',
                                text: 'Data berhasil dihapus!',
                                willClose: () => {
                                    reinitTable()
                                }
                            })
                        }
                    })
                }
            })
        }

        $('#form-ubah-password').submit(function(e) {
            e.preventDefault()
            let form = new FormData(this)
            let password = $('#password').val()
            let konfirmasi_password = $('#konfirmasi-password').val()
            if (password != konfirmasi_password) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Peringatan',
                    text: 'Password dan konfirmasi password harus sama!'
                })
            } else {
                $.ajax({
                    url: "{{ route('ubah-password-admin') }}",
                    type: "POST",
                    data: form,
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function(data) {
                        $('#myModalUbahPassword').modal('hide')
                        if (data.status === true) {
                            $('#form-ubah-password').trigger("reset")
                            Swal.fire({
                                icon: 'success',
                                title: 'Sukses',
                                text: data.message,
                                willClose: () => {
                                    reinitTable()
                                }
                            })
                        } else {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Peringatan',
                                text: data.message,
                                willClose: () => {
                                    reinitTable()
                                }
                            })
                        }
                    },
                    error: function(request, msg, error) {
                        $('#form-ubah-password').trigger("reset")
                        console.log(msg)
                    }
                })
            }
        })
    </script>
@endpush
