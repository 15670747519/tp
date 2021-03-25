<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
use Aliyun\Core\Config;
use Aliyun\Core\Profile\DefaultProfile;
use Aliyun\Core\DefaultAcsClient;
use Aliyun\Api\Sms\Request\V20170525\SendSmsRequest;



/**
 * 短信发送
 * @param $to    接收人
 * @param $model    短信模板ID
 * @param $code   短信验证码
 * @return json
 */
function send_sms($to, $model, $code){
    require_once '../extend/alisms/vendor/autoload.php';
    Config::load(); //加载区域结点配置
    $config = '根据你的实际情况读取配置文件或读取数据库，本项目是将配置写入数据库实现';
    $accessKeyId = 'LTAI4FocTXteRQYPzrvqg4QW';
    $accessKeySecret = 'hU4I8N5E1Y49tbs1QzyK7935H2k68E';
    $templateParam = $code;
    //短信签名
//    $signName = $config['sign_name'];
    $signName = '买买电脑';
    //短信模板ID
//    switch($model){
//        case 1:
//            $templateCode = $config['model_code_rl']; // 注册登录短信验证码模板
//            break;
//        case 2:
//            $templateCode = $config['model_code_reset']; // 重置密码短信验证码模板
//            break;
//    }
    $templateCode = 'SMS_183160264';
    //短信API产品名（短信产品名固定，无需修改）
    $product = "Dysmsapi";
    //短信API产品域名（接口地址固定，无需修改）
    $domain = "dysmsapi.aliyuncs.com";
    //暂时不支持多Region（目前仅支持cn-hangzhou请勿修改）
    $region = "cn-hangzhou";
    // 初始化用户Profile实例
    $profile = DefaultProfile::getProfile($region, $accessKeyId, $accessKeySecret);
    // 增加服务结点
    DefaultProfile::addEndpoint("cn-hangzhou", "cn-hangzhou", $product, $domain);
    // 初始化AcsClient用于发起请求
    $acsClient= new DefaultAcsClient($profile);
    // 初始化SendSmsRequest实例用于设置发送短信的参数
    $request = new SendSmsRequest();
    // 必填，设置雉短信接收号码
    $request->setPhoneNumbers($to);
    // 必填，设置签名名称
    $request->setSignName($signName);
    // 必填，设置模板CODE
    $request->setTemplateCode($templateCode);
    // 可选，设置模板参数
    if($templateParam) {
        $request->setTemplateParam(json_encode($templateParam));
    }
    //发起访问请求
    $acsResponse = $acsClient->getAcsResponse($request);
    //返回请求结果
    $result = json_decode(json_encode($acsResponse),true);
    // 具体返回值参考文档：https://help.aliyun.com/document_detail/55451.html?spm=a2c4g.11186623.6.563.YSe8FK
    return $result;
}

/**
 * 发送邮件
 * @param $address
 * @param $title
 * @param $message
 * @return mixed
 */
function SendMail($address,$title,$message){
//    $mail = new PHPMailer\PHPMailer\PHPMailer();           //实例化PHPMailer对象

//    vendor ('phpmailer.phpmailer.src.PHPMailer');
    vendor('phpmailer.phpmailer.src.PHPMailer.php');
    $mail = new \PHPMailer();
    // 设置PHPMailer使用SMTP服务器发送Email
    $mail->IsSMTP();
    // 设置邮件的字符编码，若不指定，则为'UTF-8'
    $mail->CharSet='UTF-8';
    // 添加收件人地址，可以多次使用来添加多个收件人
    $mail->AddAddress($address);
    // 设置邮件正文
    $mail->Body=$message;
    //设置发件人邮箱地址 这里填入上述提到的“发件人邮箱”
    $mail->From='1247504434@qq.com';
    //设置发件人姓名（昵称） 任意内容，显示在收件人邮件的发件人邮箱地址前的发件人姓名
//    $mail->FromName('皮特张');
    // 设置邮件标题
    $mail->Subject=$title;
    // 设置SMTP服务器。
    $mail->Host='smtp.qq.com';
    // 设置为"需要验证"
    $mail->SMTPAuth=true;
    //smtp登录的账号 这里填入字符串格式的qq号即可
    $mail->Username='1247504434@qq.com';
    //smtp登录的密码 使用生成的授权码 你的最新的授权码
    $mail->Password='pseafnytfvncbaaj';
    // 发送邮件。    成功返回true或false
    return($mail->Send());
}

function send_mail($tomail, $name, $subject = '', $body = '', $attachment = null) {

    $mail = new PHPMailer\PHPMailer\PHPMailer();           //实例化PHPMailer对象
    $mail->CharSet = 'UTF-8';           //设定邮件编码，默认ISO-8859-1，如果发中文此项必须设置，否则乱码
    $mail->IsSMTP();                    // 设定使用SMTP服务
    $mail->SMTPDebug = 0;               // SMTP调试功能 0=关闭 1 = 错误和消息 2 = 消息
    $mail->SMTPAuth = true;             // 启用 SMTP 验证功能
    $mail->SMTPSecure = 'ssl';          // 使用安全协议
    $mail->Host = "smtp.qq.com"; // SMTP 服务器
    $mail->Port = 465;                  // SMTP服务器的端口号
    $mail->Username = "1247504434@qq.com";    // SMTP服务器用户名
    $mail->Password = "pseafnytfvncbaaj";     // SMTP服务器密码，这里是你开启SMTP服务时生成密码
    $mail->SetFrom('1247504434@qq.com', '发件人昵称');
    $replyEmail = '';                   //留空则为发件人EMAIL
    $replyName = '';                    //回复名称（留空则为发件人名称）
    $mail->AddReplyTo($replyEmail, $replyName);
    $mail->Subject = $subject;
    $mail->MsgHTML($body);
    $mail->AddAddress($tomail, $name);
    if (is_array($attachment)) { // 添加附件
        foreach ($attachment as $file) {
            is_file($file) && $mail->AddAttachment($file);
        }
    }
    return $mail->Send() ? true : $mail->ErrorInfo;
}
