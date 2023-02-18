<?php
ob_start();
//201201/10
$timeDir = date("Ym")."/".date("d");
//data/media/
$webRoot = str_replace("\\","/",dirname(__FILE__));
$webRoot = str_replace("lib/ueditor/WordPaster","",$webRoot);
$pathSvr = $webRoot.'/uploadfile/'.$timeDir;
//http://www.qq.com/upload.php
$urlRoot = "http://".$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"];
$urlRoot = str_replace("lib/ueditor/WordPaster/upload.php","",$urlRoot);
//相对路径 http://www.ncmem.com/upload/2012-1-10/
$urlUpload = $urlRoot ."data/media/" . $timeDir . "/";

//自动创建目录。upload/2012-1-10
if(!is_dir($pathSvr))
{
	mkdir($pathSvr,0777,true);
}


//如果PHP页面为UTF-8编码，请使用urldecode解码文件名称
//$fileName = urldecode($_FILES['postedFile']['name']);
//如果PHP页面为GB2312编码，则可直接读取文件名称
$fileName = $_FILES['file']['name'];
$tmpName = $_FILES['file']['tmp_name'];

//取文件扩展名jpg,gif,bmp,png
$path_parts = pathinfo($fileName);
$ext = $path_parts["extension"];
$ext = strtolower($ext);//jpg,png,gif,bmp

//只允许上传图片类型的文件
if($ext == "jpg"
	|| $ext == "jpeg"
	|| $ext == "png"
	|| $ext == "gif"
	|| $ext == "bmp"
	|| $ext == "webp")
{
	//年_月_日_时分秒毫秒.jpg
	$saveFileName = $fileName;

	//xxx/2011_05_05_091250000.jpg
	$savePath = $uploadDir . "/" . $saveFileName;

	//另存为新文件名称
	if (!move_uploaded_file($tmpName,$savePath))
	{
		exit('upload error!' . "文件名称：" .$fileName . "保存路径：" . $savePath);
	}
}

//输出图片路径
echo $urlUpload .  $fileName;
?>