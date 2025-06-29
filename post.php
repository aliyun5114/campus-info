<?php
include('config.php');
if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];
    
    require_once 'oss-sdk/autoload.php';
    use OSS\OssClient;
    
    $imageUrl = '';
    if(isset($_FILES['image'])) {
        $file = $_FILES['image'];
        $object = 'images/' . time() . '_' . $file['name'];
        
        $ossClient = new OssClient(
            'aliyun5114.oss-cn-hangzhou.aliyuncs.com' 
        );
        
        try {
            $ossClient->uploadFile('campus-info-oss', $object, $file['tmp_name']);
            $imageUrl = 'https://campus-info-oss.oss-cn-hangzhou.aliyuncs.com/' . $object;
        } catch(Exception $e) {
            die('上传失败: '.$e->getMessage());
        }
    }
    
    $stmt = $conn->prepare("INSERT INTO news (title, content, image_url) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $title, $content, $imageUrl);
    $stmt->execute();
    
    header("Location: /");
    exit;
}
?>
<!DOCTYPE html>
<html>
<body>
    <h1>发布新信息</h1>
    <form method="POST" enctype="multipart/form-data">
        <p>标题: <input type="text" name="title" required></p>
        <p>内容: <textarea name="content" rows="5" required></textarea></p>
        <p>图片: <input type="file" name="image"></p>
        <button type="submit">提交</button>
    </form>
</body>
</html>
