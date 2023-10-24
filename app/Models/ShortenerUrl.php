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

    public static function simpanData($data)
    {
        // Insert Data
        $sql = DB::table('shortener_url')->insert($data);

        return $sql;
    }

    public static function getById($subdomain, $slug)
    {
        $sql = "SELECT slug,title,description,url_short,url_destination,link_image_offline,link_image_online FROM shortener_url
        WHERE subdomain = :subdomain AND slug = :slug ORDER BY id desc";

        $result = DB::selectOne($sql, [
            'subdomain' => $subdomain,
            'slug' => $slug
        ]);

        return $result;
    }

    public static function updateVisitor($subdomain, $slug)
    {
        DB::table('shortener_url')
            ->where('subdomain', $subdomain)
            ->where('slug', $slug)
            ->increment('visitors', 1);
    }

    public static function getLimit($id_user)
    {
        $sql = "SELECT u.is_unlimited,u.limit FROM users u
        WHERE u.id = :id_user";

        $result = DB::selectOne($sql, [
            'id_user' => $id_user,
        ]);

        return $result;
    }
}
