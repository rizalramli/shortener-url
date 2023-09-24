<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_aktif'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */

    public static function getData()
    {
        $sql = "SELECT u.id,u.email,u.name as nama,u.is_aktif FROM users u";

        $sql = $sql . " WHERE u.deleted_at IS NULL";

        $sql = $sql . " ORDER BY u.id ASC";

        $result = DB::select($sql);

        return $result;
    }

    public static function simpanData($request)
    {
        if (empty($request->id)) {
            // Insert Data
            $sql = DB::table('users')->insert([
                'email' => $request->email,
                'name' => $request->nama,
                'password' => Hash::make($request->email),
                'is_aktif' => $request->is_aktif,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        } else {
            // Update Data
            $sql = DB::table('users')
                ->where('id', $request->id)
                ->update([
                    'email' => $request->email,
                    'name' => $request->nama,
                    'is_aktif' => $request->is_aktif,
                    'updated_at' => now()
                ]);
        }

        return $sql;
    }

    public static function editData($id)
    {
        $sql = "SELECT u.id,u.email,u.name as nama,u.is_aktif FROM users u
        WHERE u.id = :id";

        $result = DB::selectOne($sql, [
            'id' => $id,
        ]);

        return $result;
    }

    public static function updateData($request, $id)
    {
        $sql = DB::table('users')
            ->where('id', $id)
            ->update([
                'is_aktif' => $request->is_aktif,
                'updated_at' => now()
            ]);

        return $sql;
    }

    public static function deleteData($id)
    {
        $sql = DB::table('users')
            ->where('id', $id)
            ->update([
                'is_aktif' => 0,
                'deleted_at' => now()
            ]);

        return $sql;
    }

    public static function UbahPasswordAdmin($request)
    {
        $newPassword = $request->input('password');

        DB::table('users')
            ->where('id', $request->id_user)
            ->update(['password' => Hash::make($newPassword)]);

        return response()->json(['status' => true, 'message' => 'Password berhasil diperbarui']);
    }
}
