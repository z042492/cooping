<?php
// $_FILES['photofile']:是获得上传图片的数组
// $uploadfile：存放地址
$uploadfile = "D:/".$_FILES['photofile']['name'];
copy( $_FILES['photofile']['tmp_name'], $uploadfile );
echo "URL: <a href='http://localhost/".$_FILES['photofile']['name']."' target='_blank'>".$_FILES['photofile']['name']."</a><br/>";
?>