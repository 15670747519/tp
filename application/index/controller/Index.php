<?php
namespace app\index\controller;

use think\Controller;
use think\Db;
use think\Model;
class Index extends Controller
{
    public function index()
    {
        //return $this->fetch('image');

        return '<style type="text/css">*{ padding: 0; margin: 0; } .think_default_text{ padding: 4px 48px;} a{color:#2E5CD5;cursor: pointer;text-decoration: none} a:hover{text-decoration:underline; } body{ background: #fff; font-family: "Century Gothic","Microsoft yahei"; color: #333;font-size:18px} h1{ font-size: 100px; font-weight: normal; margin-bottom: 12px; } p{ line-height: 1.6em; font-size: 42px }</style><div style="padding: 24px 48px;"> <h1>:)</h1><p> ThinkPHP V5<br/><span style="font-size:30px">十年磨一剑 - 为API开发设计的高性能框架</span></p><span style="font-size:22px;">[ V5.0 版本由 <a href="http://www.qiniu.com" target="qiniu">七牛云</a> 独家赞助发布 ]</span></div><script type="text/javascript" src="https://tajs.qq.com/stats?sId=9347272" charset="UTF-8"></script><script type="text/javascript" src="https://e.topthink.com/Public/static/client.js"></script><think id="ad_bd568ce7058a1091"></think>';
    }
    public function news(){
        $info = db('user')->limit(2,2)->select();
        return json($info);
        print_r($info);
    }

    public function image(){
        print_r(12);exit;
        return $this->fetch('image');
    }
    public function hello(){
        print_r('hello word');
    }
    public function upload(){
        // 获取表单上传文件 例如上传了001.jpg
        $file = request()->file('image');

        // 移动到框架应用根目录/public/uploads/ 目录下
        if($file){
            $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
            if($info){
                // 成功上传后 获取上传信息
                // 输出 jpg
                echo $info->getExtension();
                // 输出 20160820/42a79759f284b767dfcb2a0197904287.jpg
                echo $info->getSaveName();
                // 输出 42a79759f284b767dfcb2a0197904287.jpg
                echo $info->getFilename();
            }else{
                // 上传失败获取错误信息
                echo $file->getError();
            }
        }
    }
    public function showname(){
        echo '332';
//        return $this->fetch('show');
    }

    public function create(){
        $to = 'jz.li@rootant.com';
        $subject= '测试mail函数';
        $message = '你好吗';
        $result = mail($to,$subject,$message);
        print_r($result);exit;
        print_r(phpinfo());
        $test = new \test\test();
        $r = $test->test();
        print_r($r);
    }

    public function sms(){
        //第四步：在你需要用到的控制器中调用send_sms(‘电话号码’,‘短信模板’,‘需要替换的变量’)，OK大功告成！

        $sender = '15670747519';
        $code = '8989';
        $send = send_sms($sender, 1, ['code'=>$code]);
        print_r($send);
    }
    public function semdemail(){
        $to = '1247504434@qq.com';
        $title = '测试email';
        $message = '这个世界会好吗?';

        $result = SendMail($to,$title,$message);
        print_r($result);
    }
    public function send_email()
    {
        $toemail='1247504434@qq.com';//收件人邮箱
        $name='亲爱的Pedro，您好！';//接收邮件者名称
        $subject='QQ邮件发送测试';//邮件主题
        $content='恭喜你，邮件测试成功。';//邮件内容
        //调用方法发送邮件
        dump(send_mail($toemail,$name,$subject,$content));
    }

    public function data(){
        $data = Db::table('area')->select();
        $result = $this->getTree($data);
        print_r($result);
    }

    //将数据转换成树形结构
    public function treeData($pid,$data){
        print_r($pid);
        print_r($data);
        $result = '';
        if($pid == $data)
        foreach($data as $value){
            var_dump($value);
            if($value['pid'] == $pid){
                $result[] = $value;
                $value['pid']=$this->treeData($value['pid'],$value);
            }
        }
//        print_r($result);





    }


    function getTree($array, $pid = 0){

//        print_r($pid);
        //声明静态数组,避免递归调用时,多次声明导致数组覆盖
          $list = [];
        foreach ($array as $key => $value){
//            print_r($pid);
//            print_r('你好');
//            print_r('</br>');
//            print_r($value);
//            print_r($value['id']);
//            print_r($value);
//            第一次遍历,找到父节点为根节点的节点 也就是pid=0的节点
            if ($value['pid'] == $pid){
//                //把数组放到list中
//                $list[] = $value;
                //开始递归,查找父ID为该节点ID的节点,级别则为原级别+1
                $value['son'] = $this->getTree($array, $value['id']);
                if($value['son'] == null){
                    unset($value['son']);
                }
                $list[] = $value;
            }
        }
        return $list;

//        $tree = [];
//        foreach ($array as $k=>$v){
//            if ($v['pid'] == $pid){
//                $v['son'] = $this->getTree($array,$v['id']);
////                if ($v['son'] == null){
////                    unset($v['son']);
////                }
//                $tree[] = $v;
//            }
//        }
//        return $tree;
    }

    public function tree(){

        $items = array(
              1 => array('id' => 1, 'pid' => 0, 'name' => '江西省'),
              2 => array('id' => 2, 'pid' => 0, 'name' => '黑龙江省'),
              3 => array('id' => 3, 'pid' => 1, 'name' => '南昌市'),
              4 => array('id' => 4, 'pid' => 2, 'name' => '哈尔滨市'),
//              5 => array('id' => 5, 'pid' => 2, 'name' => '鸡西市'),
              6 => array('id' => 6, 'pid' => 4, 'name' => '香坊区'),
              7 => array('id' => 7, 'pid' => 4, 'name' => '南岗区'),
              8 => array('id' => 8, 'pid' => 6, 'name' => '和兴路'),
              9 => array('id' => 9, 'pid' => 7, 'name' => '西大直街'),
//              10 => array('id' => 10, 'pid' => 8, 'name' => '东北林业大学'),
              11 => array('id' => 11, 'pid' => 9, 'name' => '哈尔滨工业大学'),
              12 => array('id' => 12, 'pid' => 8, 'name' => '哈尔滨师范大学'),
              13 => array('id' => 13, 'pid' => 1, 'name' => '赣州市'),
//              14 => array('id' => 14, 'pid' => 13, 'name' => '赣县'),
//              15 => array('id' => 15, 'pid' => 13, 'name' => '于都县'),
//              16 => array('id' => 16, 'pid' => 14, 'name' => '茅店镇'),
//              17 => array('id' => 17, 'pid' => 14, 'name' => '大田乡'),
//              18 => array('id' => 18, 'pid' => 16, 'name' => '义源村'),
//              19 => array('id' => 19, 'pid' => 16, 'name' => '上坝村'),
//              20 => array('id' => 20, 'pid' => 0, 'name' => '广东省'),
              21 => array('id' => 21, 'pid' => 20, 'name' => '广州市'),

            );
    $t = array();
    foreach ($items as $id => $item) {
      if ($item['pid']) {
//          print_r($item);
//          print_r($item['pid']);
//          print_r('</br>');
          $items[$item['pid']][$item['id']] = &$items[$item['id']];
          $t[] = $id;
      }
    }
    foreach($t as $u) {
      unset($items[$u]);
    }
    echo "<pre>";
    print_r($items);

    }

    public function dataarr(){
        $items = array(
            1 => array('id' => 1, 'pid' => 0, 'name' => '江西省'),
            2 => array('id' => 2, 'pid' => 0, 'name' => '黑龙江省'),
            3 => array('id' => 3, 'pid' => 1, 'name' => '南昌市'),
            4 => array('id' => 4, 'pid' => 2, 'name' => '哈尔滨市'),
            5 => array('id' => 5, 'pid' => 2, 'name' => '鸡西市'),
            6 => array('id' => 6, 'pid' => 4, 'name' => '香坊区'),
            7 => array('id' => 7, 'pid' => 4, 'name' => '南岗区'),
            8 => array('id' => 8, 'pid' => 6, 'name' => '和兴路'),
            9 => array('id' => 9, 'pid' => 7, 'name' => '西大直街'),
            10 => array('id' => 10, 'pid' => 8, 'name' => '东北林业大学'),
            11 => array('id' => 11, 'pid' => 9, 'name' => '哈尔滨工业大学'),
            12 => array('id' => 12, 'pid' => 8, 'name' => '哈尔滨师范大学'),
            13 => array('id' => 13, 'pid' => 1, 'name' => '赣州市'),
            14 => array('id' => 14, 'pid' => 13, 'name' => '赣县'),
            15 => array('id' => 15, 'pid' => 13, 'name' => '于都县'),
            16 => array('id' => 16, 'pid' => 14, 'name' => '茅店镇'),
            17 => array('id' => 17, 'pid' => 14, 'name' => '大田乡'),
            18 => array('id' => 18, 'pid' => 16, 'name' => '义源村'),
            19 => array('id' => 19, 'pid' => 16, 'name' => '上坝村'),
            20 => array('id' => 20, 'pid' => 0, 'name' => '广东省'),
            21 => array('id' => 21, 'pid' => 20, 'name' => '广州市'),
        );

        print_r($items[1]);

    }






}
