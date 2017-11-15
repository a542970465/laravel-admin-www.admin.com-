<?php

namespace App\Admin\Controllers;

use App\Admin\Entitys\Movie;

use App\Admin\Extensions\ExcelExpoter;
use App\Admin\Extensions\Tools\ReleasePost;
use App\Admin\Extensions\Tools\UserGender;
use App\User;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Illuminate\Support\Facades\DB;

class MovieController extends Controller
{
    use ModelForm;

    /**
     * Index interface.
     *
     * @return Content
     */
    public function index()
    {
        return Admin::content(function (Content $content) {

            $content->header('header');
            $content->description('description');

            $content->body($this->grid());
        });
    }

    /**
     * Edit interface.
     *
     * @param $id
     * @return Content
     */
    public function edit($id)
    {
        return Admin::content(function (Content $content) use ($id) {

            $content->header('header');
            $content->description('description');

            $content->body($this->form()->edit($id));
        });
    }

    /**
     * Create interface.
     *
     * @return Content
     */
    public function create()
    {
        return Admin::content(function (Content $content) {

            $content->header('header');
            $content->description('description');

            $content->body($this->form());
        });
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Admin::grid(Movie::class, function(Grid $grid){

            // 第一列显示id字段，并将这一列设置为可排序列
            $grid->id('ID')->sortable();
            //#
            //直接通过字段名添加列
            $grid->username(trans('movie.username'));
//            $grid->column('username', '用户名');
//            $grid->columns('username','email');

            // 第二列显示title字段，由于title字段名和Grid对象的title方法冲突，所以用Grid的column()方法代替
            $grid->column('title')->sortable()->display(function($item){

                return "<span style='color:blue'>$item</span>";

            })->editable('textarea');

            // 第三列显示director字段，通过display($callback)方法设置这一列的显示内容为users表中对应的用户名
            $grid->director(trans('movie.director'))->display(function() {
                return User::find($this->director)->name;
            });

            // 第四列显示为describe字段
            $grid->describe()->limit(6)->ucfirst();

            // 第五列显示为rate字段
            $grid->rate();

            // 第六列显示released字段，通过display($callback)方法来格式化显示输出
            $grid->released('上映?')->display(function ($released) {
                return $released ? '是' : '否';
            });

            // 下面为三个时间字段的列显示
            $grid->release_at()->editable('datetime');
            $grid->created_at();
            $grid->updated_at();
//            $grid->column('year')->editable('year');
//            $grid->column('month')->editable('month');
//            $grid->column('day')->editable('day');

            // filter($callback)方法用来设置表格的简单搜索框
            $grid->filter(function ($filter) {

            // 设置created_at字段的范围查询
            $filter->between('created_at', 'Created Time')->datetime();

            });

            //修改来源数据
//            $grid->model()->where('id',2);
//            $grid->model()->orderBy('id','desc');

            //设置每页显示行数
            $grid->paginate(5);

            //修改显示输出
//            $grid->title()->display(function($text) {
//               return str_limit($text, 2, '**');
//            });

//            $grid->director()->display(function ($name) {
//                return "<span class='label' style='color: #2a2a2a'>$name</span>";
//            });

//            $grid->email()->display(function ($email) {
//                return User::find($email)->email;
//            });
//            $grid->email()->display(function($email){
//               return Uesr::find($email)->email;
//            });

//            $grid->column('x')->display(function(){
//               return 'balbalbal...';
//            });

            //不存在的字段列
//            $grid->column('full_name')->display(function(){
//                return $this->title . '' . $this->describe;
//            });


//            $grid->actions(function($actions='怒火攻心') {
//                //当前行的数据数组
//                $actions->row;
//
//                //获取当前行主键值
//                $actions->getKey();
//            });

            //添加自定义的操作按钮
//            $grid->actions(function ($actions){
//
//                // append一个操作
//                $actions->append('<a href=""><i class="fa fa-eye"></i></a>');
//
//                // prepend一个操作
//                $actions->prepend('<a href=""><i class="fa fa-paper-plane"></i></a>');
//            });

            //列操作
//            $grid->column('title')->display(function ($title){
//               return "<span style='color:blue'>$title</span>";
//            });

//            $grid->title()->editable('textarea');

//            $grid->status()->switch();
//            $states = [
//              'on' => ['value'=>1,'text'=>'打开','color'=>'primary'],
//              'off' => ['value' => 2, 'text' => '关闭', 'color' => 'default'],
//            ];
//
//            $grid->status()->switch($states);

//            $states = [
//              'on'=>['text'=>'YES'],
//                'off'=>['text'=>'NO'],
//            ];
//            $grid->column('switch_group')->switchGroup([
//               'hot'    =>  '热门',
//                'new'   =>  '最新',
//                'recommend' => '推荐'
//            ],$states);

//            $grid->options()->select([
//                1 => 'Sed ut perspiciatis unde omni',
//                2 => 'voluptatem accusantium doloremque',
//                3 => 'dicta sunt explicabo',
//                4 => 'laudantium, totam rem aperiam',
//            ]);

//            $grid->options()->radio([
//                1 => 'one',
//                2 => 'two',
//                3 => 'three',
//                4 => 'four',
//            ]);

//            $grid->options(1)->checkbox([
//                1 => 'one',
//                2 => 'two',
//                3 => 'three',
//                4 => 'four'
//            ]);

//            $grid->picture()->image();

//设置服务器和宽高
//            $grid->picture()->image(150,150);
////
//// 显示多图
//            $grid->pictures()->display(function ($pictures) {
//
//                return json_decode($pictures, true);
//
//            })->image('http://img.dongqiudi.com/uploads/avatar/2015/07/25/QM387nh7As_thumb_1437790672318.jpg', 100, 100);

//            $grid->director()->label();
            //设置颜色,默认'success',可选'danger','warning','info','primary','default','success'
//            $grid->director()->label('danger');

//            $grid->tools(function ($tools){
//               $tools->append(new UserGender());
//            });

//            $grid->tools(function ($tools) {
//                $tools->batch(function ($batch) {
//                    $batch->disableDelete();
//                });
//            });

//            $grid->tools(function ($tools) {
//               $tools->batch(function ($batch) {
//                   $batch->add('发布文章', new ReleasePost(1));
//                   $batch->add('文章下线', new ReleasePost(0));
//               }) ;
//            });

            $grid->filter(function ($filter) {
                //去掉默认的id过滤器
//                $filter->disableIdFilter();

                // 再这里添加字段过滤器
//                $filter->like('name','name');

//                $filter->in('title')->multipleSelect(['怒火攻心'=>'怒火攻心','战狼2'=>'剑神','3'=>'测试']);

//                $filter->equal('released')->radio([
//                   '' => 'all',
//                    0 => 'Unreleased',
//                    1 => 'Released',
//                ]);
            });



        });

    }


    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
            return Admin::form(Movie::class, function(Form $form){
             if($form->model()->id)
             {

             }
            // 显示记录id
            $form->display('id', 'ID');

            // 添加text类型的input框
            $form->text('title', '1电影标题');

            $directors = [
                1  => '汉武帝',
                2  => '毛泽东',
                3  => '习近平',
            ];

            $form->select('director', '伟人')->options($directors);

            // 添加describe的textarea输入框
            $form->textarea('describe', '描述');

            // 数字输入框
            $form->number('rate', '打分');

            // 添加开关操作
            $form->switch('released', '发布？');

            // 添加日期时间选择框
            $form->datetime('release_at', '发布时间');

            //图片上传
            $form->image('img_url');

            // 两个时间显示
            $form->display('created_at', '创建时间');
            $form->display('updated_at', '修改时间');

            //自定义工具
                $form->tools(function (Form\Tools $tools) {
                   // 去掉返回按钮
                    $tools->disableBackButton();
                    //去掉跳转列表按钮
                    $tools->disableListButton();
                    //添加一个按钮,参数可以是字符串,或者实现了Renderable或Htmlable接口的对象实例
                    $tools->add('<a class="btn btn-sm btn-danger"><i class="fa fa-trash"></i>&nbsp;&nbsp;delete</a>');

                });
//                $form->setWidth(8,2);


        });
    }
}
