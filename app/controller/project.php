<?php
namespace app\controller;

use app\BaseController;
use think\facade\View;
use think\Request;
use think\facade\Db;

class project extends BaseController
{
    public function index()
    {
        // 获取数据
        $list = Db::table("project")->order('id', 'desc')->limit(10)->select()->toArray();

        // 直接在 fetch 里传参，这是最稳妥的
        return View::fetch('index', [
            'list'  => $list,
            'count' => count($list) // 传个计数，方便调试
        ]);
    }
    public function _add(Request $request)
    {
        //添加项目的方法 向数据库写入添加项目的信息数据
        $name = $request->param('name');
        $gitAddrs = $request->param('git_addrs');
        $gitAddrArr = explode("\n", $gitAddrs);
        foreach ($gitAddrArr as $gitAddr) {
            $gitAddr = trim($gitAddr);
            Db::table('project')->insertGetId([
                'name' => $name,
                'addr' => $gitAddr,
            ]);
        }
        return redirect("/index.php/project");

    }
    public function _del(Request $request)
    {
        // 1. 获取前端传过来的 id
        $id = $request->param('id');

        if ($id) {
            // 2. 执行删除操作
            // 使用 Db::name('project') 更加规范
            Db::name('project')->where('id', $id)->delete();
        }

        // 3. 删除后重定向回列表页
        return redirect("/index.php/project");
    }


}
