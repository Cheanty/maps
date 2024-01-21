<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 检查是否有上传文件
    if (isset($_FILES['file'])) {
        $file = $_FILES['file'];

        // 目标存储文件夹
        $targetDirectory = "data/";
        $targetFile = $targetDirectory . basename($file['name']);

        $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
        if ($fileType !== 'json') {
            echo "只允许上传 JSON 文件. ";
            exit;
        }
        // 检查是否文件已经存在
        if (file_exists($targetFile)) {
            // 如果存在，删除旧文件
            unlink($targetFile);
            echo "已存在的文件已被替换. ";
        }

        // 处理上传文件
        if (move_uploaded_file($file['tmp_name'], $targetFile)) {
            echo "文件上传成功: " . $targetFile;
        } else {
            echo "文件上传失败";
        }
    } else {
        echo "没有上传文件";
    }
} else {
    echo "Invalid request method. This endpoint only accepts POST requests.";
}
?>
