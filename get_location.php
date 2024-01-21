<?php
// 读取 JSON 文件内容
$fileContent = file_get_contents("data/location.json");

// 输出 JSON 格式的数据
header('Content-Type: application/json');
echo $fileContent;
?>