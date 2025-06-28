<?php 
include('config.php');
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($conn->connect_error) die('数据库连接失败: ' . $conn->connect_error);

$result = $conn->query("SELECT * FROM news ORDER BY id DESC LIMIT 10");
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>校园信息展示系统</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: "Microsoft YaHei", sans-serif; }
        body { background-color: #f5f7fa; color: #333; line-height: 1.6; }
        .container { width: 90%; max-width: 1200px; margin: 0 auto; padding: 20px; }
        header { text-align: center; padding: 30px 0; border-bottom: 2px solid #4a90e2; }
        h1 { color: #2c3e50; margin-bottom: 10px; }
        .news-list { display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 20px; margin-top: 30px; }
        .news-item { background: white; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.05); transition: transform 0.3s; }
        .news-item:hover { transform: translateY(-5px); }
        .news-image { width: 100%; height: 180px; object-fit: cover; }
        .news-content { padding: 15px; }
        .news-title { font-size: 1.2rem; margin-bottom: 10px; color: #2c3e50; }
        .news-desc { color: #7f8c8d; font-size: 0.9rem; line-height: 1.5; }
        .news-date { font-size: 0.8rem; color: #95a5a6; margin-top: 10px; }
        @media (max-width: 768px) {
            .news-list { grid-template-columns: 1fr; }
            header { padding: 20px 0; }
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>校园最新资讯</h1>
            <p>实时更新校园动态、活动通知与学术新闻</p>
        </header>
        
        <div class="news-list">
            <?php while($row = $result->fetch_assoc()): ?>
            <div class="news-item">
                <?php if($row['image_url']): ?>
                <img src="<?= $row['image_url'] ?>" alt="<?= $row['title'] ?>" class="news-image">
                <?php endif; ?>
                <div class="news-content">
                    <h2 class="news-title"><?= $row['title'] ?></h2>
                    <p class="news-desc"><?= mb_strimwidth(strip_tags($row['content']), 0, 120, '...') ?></p>
                    <span class="news-date"><?= date('Y-m-d', strtotime($row['created_at'])) ?></span>
                </div>
            </div>
            <?php endwhile; ?>
            
            <?php if($result->num_rows === 0): ?>
            <div style="width: 100%; text-align: center; padding: 30px; color: #7f8c8d;">
                暂无新闻数据，请先发布内容
            </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
