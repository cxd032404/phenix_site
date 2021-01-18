<!DOCTYPE html>
<html lang="en">
<?php require_once "function/init.php";
$id = $_GET['id']??1;
$data = [
    "information"=>[$id],
];
$return = curl_post($config['api_get'],json_encode($data),1);
$urlList = ["hero"=>"herodetail/",
    "team"=>"teamdetail/",
    "player"=>"playerdetail/",
];
$return["information"]['data']['keywords_list'] = json_decode($return["information"]['data']['keywords_list'],true);
$keywordsList = [];
if(is_array($return["information"]['data']['keywords_list']))
{
    foreach($return["information"]['data']['keywords_list'] as $type => $list)
    {
        foreach($list as $word => $wordInfo)
        {
            if(isset($keywordsList[$word]))
            {
                if($wordInfo['count']>$keywordsList[$word]['count'])
                {
                    $keywordsList[$word] = ["word"=>$word,"id"=>$wordInfo['id'],"type"=>$type,"count"=>$wordInfo['count'],'url'=>$urlList[$type].$wordInfo['id']];
                }
            }
            else
            {
                $keywordsList[$word] = ["word"=>$word,"id"=>$wordInfo['id'],"type"=>$type,"count"=>$wordInfo['count'],'url'=>$urlList[$type].$wordInfo['id']];
            }
        }
    }
}
array_multisort(array_combine(array_keys($keywordsList),array_column($keywordsList,"count")),SORT_DESC,$keywordsList);
?>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="screen-orientation" content="portrait">
    <meta name="browsermode" content="application">
    <meta name="x5-orientation" content="portrait">
    <meta name="apple-mobile-web-app-title" content="弹址签发">
    <meta name="format-detection" content="telphone=no, email=no"/>
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate"/>
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />
    <meta name="renderer" content="webkit">
    <meta name="full-screen" content="yes">
    <meta name="x5-fullscreen" content="true">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0,user-scalable=no, viewport-fit=cover"/>
    <title>热门资讯</title>
    <link rel="stylesheet" href="<?php echo $config['site_url'];?>/assets/css/common.css">
    <link rel="stylesheet" href="<?php echo $config['site_url'];?>/assets/css/detail.css">
</head>
<body>
<div class="container">
    <?php generateNav($config,"news");?>
    <div class="content">
        <div class="detail">
            <h5><?php echo $return['information']['data']['title'];?></h5>
            <p>
                <img src="<?php echo $return['information']['data']['logo'];?>" alt="<?php echo $return['information']['data']['title'];?>">
            </p>
            <p><?php echo $return['information']['data']['content'];?></p>
            <div class="tips clearfix">
                <span class="left">
                    <?php
                    $i = 1;
                    foreach($keywordsList as $word => $info)
                    {
                        if($i<=3)
                        {
                            echo '<a href="##">'.$info['word'].'</a>';
                            //echo '<a href="'.$config['site_url'].'/'.$info['url'].'">'.$info['word'].'</a>';
                        }
                        $i++;
                    }?>
                </span>
                <span class="rig">
                        <?php echo ($return['information']['data']['type']==2)?$return['information']['data']['site_time']:$return['information']['data']['create_time'];?>
                </span>
            </div>
        </div>
        <div class="extra">
            <h6>相关文章推荐</h6>
            <div>
                <ul>
                    <li><a href="">虎牙明星主播踢馆名校战队，峡谷高材生与学霸的荣耀对决</a></li>
                    <li><a href="">【KPL今日预报】成都AG超玩会 vs 重庆QG，揭幕战宿敌再遇谁能首胜？</a></li>
                    <li><a href="">王者荣耀世界冠军杯总决赛落地首都北京</a></li>
                </ul>
            </div>
        </div>
        <div class="extra">
            <h6>热门资讯</h6>
            <div>
                <ul>
                    <li><a href="">2021年KPL春季赛常规赛赛程公布</a></li>
                    <li><a href="">强强联合！LGD携手大鹅文化，斥资8000万进军KPL</a></li>
                    <li><a href="">2021年KPL春季赛常规赛赛程公布</a></li>
                </ul>
            </div>
        </div>
    </div>
    <?php renderCertification();?>
</div>
</body>
</html>
