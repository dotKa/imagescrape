<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />

</head>
<body>
<?php 


//$urlkey = htmlspecialchars($_GET['ara']);
$urlkey = urldecode($_GET['ara']);//aranacak kelimeyi çekiyoruz
?>
<h2 style="-moz-user-select: none; -webkit-user-select: none; -ms-user-select:none; user-select:none;-o-user-select:none;" 
 unselectable="on"
 onselectstart="return false;" 
 onmousedown="return false;">google görseller <?php echo $urlkey; ?></h2>
<?php
$urlkey = str_replace(" ","+",$urlkey);//kelimedeki boşluk karakterlerini "+" ile değiştiriyoruz


$urlsay = intval($_GET['adet']);//kaç adet içerik çekileceğini çekiyoruz
$urltld = htmlspecialchars($_GET['tld']);//hangi domainde arama yapacağımızı seçiyoruz

//----------------//
//burada çekilecek içerik sayısını
//6 dan küçükse 6 ya eşitliyoruz
//12 den büyükse 12 ye eşitliyoruz
if ($urlsay <6){
	$urlsay=6;
}
elseif($urlsay>12){
	$urlsay=12;
}
//----------------//
?>






<?php 
//----------------//
//cek fonksiyonunu tanımlıyoruz
//cek fonksiyonu () içine yazdığımız
//adresin kaynak kodunu almamızı sağlıyor
function cek($url){ 
$oturum = curl_init(); 
curl_setopt($oturum, CURLOPT_URL, $url); 
$h4 = $_SERVER['HTTP_USER_AGENT']; 
curl_setopt($oturum, CURLOPT_USERAGENT, $h4); 
curl_setopt($oturum, CURLOPT_HEADER, 0); 
curl_setopt($oturum, CURLOPT_RETURNTRANSFER, true); 
$source=curl_exec($oturum); 
curl_close($oturum); 
return $source; 
} 
//----------------//

//----------------//
//googleda arama yapıyoruz
$site =  cek("https://www.".$urltld."/search?site=&tbm=isch&source=hp&biw=1366&bih=657&q=".$urlkey."&gs_l=img.3..0l10.15056.15579.0.15742.4.4.0.0.0.0.174.400.0j3.3.0....0...1ac.1.64.img..1.3.399.Z5URzULlTaQ&gws_rd=cr&ei=c3ONVrrMEsmtsAHk8L3wDw#imgrc=_");  
//----------------//


// buradaki for döngümüzde kaç adet içerik çekeceksek işlemlerin o kadar tekrar etmesini sağlıyoruz
for ($k=0;$k<$urlsay;$k++){

?>
<br>
<div id="DIV<?php echo $k;?>" style="display:none">{<?php

//burada googledan çektiğimiz görsellerin verilerini ayıklıyoruz
for ($i=0;$i<1;$i++){
	$teklik=$site;
$ptcikti = explode("</div></a><div class=\"rg_meta\">{", $teklik);   
$ptcikti = explode("}</div></div><!--n--><!--m-->", $ptcikti[$k+1]);

	echo strip_tags($ptcikti[$i]);

}
?>}</div>

<script type="text/javascript">
//Google dan çektiğimiz görsel verileri json olduğu için javascript kullandık görsel bilgilerinden başlığı okuyup yazıyoruz
var cekcek = document.getElementById('DIV<?php echo $k;?>').innerHTML;


var parsedJSON = eval('('+cekcek+')');

var result=parsedJSON.pt;
var count=parsedJSON.s;

document.write('&lt;h2&gt;'+result+'&lt;/h2&gt;');

</script>

<br>
<?php
$teklik2=$site; // döngü içinde olduğumuz ve $site verisini bir seferden fazla işleyeceğimiz için $teklik2 içerisinde aktarıyoruz
$resimlink = explode("&amp;imgrefurl=", $teklik2);   //bu ve alttaki satırda ressmin linkini ayıklıyoruz
$resimlink = explode("imgres?imgurl=", $resimlink[$k]);
?>
<div id="linkler">
&lt;br&gt;&lt;a href=&quot;<?php echo strip_tags($resimlink[$i]);?>&quot; target=&quot;_blank&quot;&gt;&lt;img src=&quot;<?php echo strip_tags($resimlink[$i]);?>&quot; width=&quot;400&quot; height=&quot;400&quot;/&gt;&lt;/a&gt;
&lt;br&gt;
&lt;br&gt;
&lt;br&gt;

</div>
<?php

}//k değişkenli for döngüsünün kapanışı
?>
</body>
</html>
