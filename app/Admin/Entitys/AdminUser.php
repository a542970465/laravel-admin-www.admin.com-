<?php

namespace App\Admin\Entitys;

use Illuminate\Database\Eloquent\Model;

class AdminUser extends Model
{
    const TABLE      = 'admin_users';
    protected $table = AdminUser::TABLE;

    public static function grid($callback)
    {
        return new Grid(new self, $callback);
    }

    public static function getUser($username)
    {
        return self::where('username',$username)->first();
    }

    /**
     * 修改账户密码
     * @param  [type] $id          账号ID
     * @param  [type] $newPassword 账号新密码
     * @return [type]              boolean
     */
    public static function changedPassword($id, $newPassword)
    {
        $item = self::find($id);
        if (!empty($newPassword) && $newPassword != $item->password) {
            $item->password = bcrypt($newPassword);
            return $item->save();
        }

        return false;
    }

    public function save(array $options = null)
    {

    }
}
