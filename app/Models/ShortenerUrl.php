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

    public static function getById($slug)
    {
        $sql = "SELECT slug,title,description,url_short,link_image_offline,link_image_online FROM shortener_url
        WHERE slug = :slug ORDER BY id desc";

        $result = DB::selectOne($sql, [
            'slug' => $slug,
        ]);

        return $result;
    }
}
