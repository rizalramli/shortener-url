<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ShortenerUrl extends Model
{
    use HasFactory;

    public $table = 'shortener_url';

    public $timestamps = true;

    public $fillable = [
        'nama',
        'is_aktif'
    ];

    public static function simpanData($data)
    {
        // Insert Data
        $sql = DB::table('shortener_url')->insert($data);

        return $sql;
    }
}
