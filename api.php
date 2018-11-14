
<?php
//參數
$KEY="";//授權KEY
$l="";//地區(格式:臺北市,新北市)地區多個需要,間格，如要全部縣市請空白
$limits="";//請求數量，預設空白(好像沒用途)
$times="1";//時間排序1啟用0關閉
@$ln=urlencode($l);//轉換中文字成UTF-8
//判斷
if($times=="1"){$time="&sort=time";}elseif($times=="0"){$time="";}else{$time="";}//判斷是否有設定時間排序
if($limits!==""){$limit="&limit=".$limits;}elseif($limits!==null){$limit="&limit=".$limits;}else{$limit="";}//判斷是否有設定請求數量

//API網址
$url = "https://opendata.cwb.gov.tw/api/v1/rest/datastore/F-C0032-001?Authorization=".$KEY.$limit."&format=JSON&locationName=".$ln.$time;
 
//請求程序 
$ch = curl_init();
 
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$output = curl_exec($ch);
$answer1=json_decode($output,true);

//$a=json_decode($a,true);
if($answer1['success']=="true"){echo "請求成功"; echo "<BR>標題<BR>". $answer1['records']['datasetDescription']."<BR>地區<BR>";
foreach($answer1['records']['location'] as &$loc) {
    $lname=$loc['locationName']; // 位置
foreach($loc['weatherElement'] as $weatherElem) { // 如果固定只有一筆可以直接 $...[0] 就好
$name=$weatherElem['elementName']; //資料屬性名稱
foreach($weatherElem['time'] as $weather) {
$weather; // 最裡面的資料
echo "{$lname}\t{$name}\t{$weather['startTime']}\t{$weather['endTime']}\t{$weather['parameter']['parameterName']}\t".@$weather['parameter']['parameterValue'].@$weather['parameter']['parameterUnit']."<BR>";
}
}
}}else{echo "ERROR請求失敗";}
curl_close($ch);
echo "<BR><BR>躍空團隊製作";
?>
