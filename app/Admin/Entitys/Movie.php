<?php

namespace App\Admin\Entitys;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;


class Movie extends Model
{
    const TABLE      = 'movies';
    protected $table = Movie::TABLE;

    public function paginate($total = 0)
    {
        $perPage = Request::get('per_page',10);
        $page = Request::get('page', 1);
        $start = ($page-1)*$perPage;

        // 运行sql获取数据数组
        $sql = 'select * from movies where id > 0';
        $result = DB::select($sql);

        $movies = static::hydrate($result);

        $paginator = new LengthAwarePaginator($movies, $total, $perPage);

        $paginator->setPath(url()->current());

        return $paginator;
    }

    public static function with($relations)
    {
        return new static;
    }
}

























