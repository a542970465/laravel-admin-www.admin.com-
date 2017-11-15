<?php
/**
 * Created by PhpStorm.
 * User: Jun
 * Date: 2017/11/15
 * Time: 11:19
 */

namespace App\Admin\Extensions\Tools;


use Encore\Admin\Grid\Tools\BatchAction;

class ReleasePost extends BatchAction
{
    protected $action;

    public function __construct($action = 1)
    {
        $this->action = $action;
    }

    public function script()
    {
        return <<<EOT
$('{$this->getElementClass()}').on('click',function(){
    $.ajax({
        method: 'post',
        url: '{$this->resource}/release',
        data: {
            _token:LA.token,
            ids: selectedRows(),
            action: {$this->action}
        },
        success: function () {
            $.pjax.reload('#pjax-container');
            toastr.success('操作成功');
        }
    });
});

EOT;


    }

}