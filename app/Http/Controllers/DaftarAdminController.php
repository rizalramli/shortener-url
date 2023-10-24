<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\User;

class DaftarAdminController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if (request()->ajax()) {
            $data = User::getData();

            return DataTables::of($data)
                ->addColumn('aksi', function ($row) {
                    $aksi = '';
                    $aksi .= '<span class="badge bg-primary me-1"><a href="javascript:void(0)" onclick="ubahPassword(' . $row->id . ')" class="text-white">ubah password</a></span>';
                    $aksi .= '<span class="badge bg-warning me-1"><a href="javascript:void(0)" onclick="editData(' . $row->id . ')" class="text-white">edit</a></span>';
                    $aksi .= '<span class="badge bg-danger"><a href="javascript:void(0)" onclick="deleteData(' . $row->id . ')" class="text-white">hapus</a></span>';
                    return $aksi;
                })
                ->editColumn('is_aktif', function ($row) {
                    $checked = $row->is_aktif == 1 ? 'checked' : '';
                    return '<input id="checkbox' . $row->id . '" onclick="updateData(' . $row->id . ')" type="checkbox" ' . $checked . '>';
                })
                ->editColumn('limit', function ($row) {
                    $content = $row->is_unlimited == 1 ? '<span style="font-size:30px">&infin;</span>' : $row->limit;
                    return $content;
                })
                ->rawColumns(['is_aktif', 'limit', 'aksi'])
                ->toJson();
        }
        return view('daftar_admin.index');
    }

    public function store()
    {
        $data = User::simpanData(request());
        return Response()->json($data);
    }

    public function edit($id)
    {
        $data = User::editData($id);
        return response()->json($data);
    }

    public function update(Request $request, $id)
    {
        $data = User::updateData($request, $id);
        return Response()->json($data);
    }

    public function destroy($id)
    {
        $data = User::deleteData($id);
        return Response()->json($data);
    }

    public function ubah_password_admin()
    {
        $data = User::UbahPasswordAdmin(request());
        return $data;
    }
}
