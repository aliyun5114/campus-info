<?php 
include('config.php');
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

$result = $conn->query("SELECT * FROM news ORDER BY id DESC");
?>
<!DOCTYPE html>
<html>
<head>
    <title>校园信息展示</title>
    <style>body{font-family:Arial,sans-serif;}</style>
</head>
<body>
    <h1>校园最新资讯</h1>
    <?php while($row = $result->fetch_assoc()): ?>
    <div style="border:1px solid #ccc;padding:20px;margin:10px;">
        <h2><?= $row['title'] ?></h2>
        <p><?= nl2br($row['content']) ?></p>
        <?php if($row['image_url']): ?>
        <img src="<?= $row['image_url'] ?>" width="300">
        <?php endif; ?>
    </div>
    <?php endwhile; ?>
</body>
</html> 
