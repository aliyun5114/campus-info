<?php
include('config.php');

// 测试数据库连接
echo "<h2>数据库连接测试</h2>";
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($conn->connect_error) {
    echo "<div style='color:red;padding:10px;'>连接失败: " . $conn->connect_error . "</div>";
} else {
    echo "<div style='color:green;padding:10px;'>数据库连接成功!</div>";
    
    // 测试数据库查询
    $result = $conn->query("SELECT COUNT(*) AS count FROM news");
    if ($result) {
        $row = $result->fetch_assoc();
        echo "<p>news 表中有 {$row['count']} 条记录</p>";
    } else {
        echo "<p>查询失败: " . $conn->error . "</p>";
    }
}

// 测试OSS配置
echo "<h2>OSS配置测试</h2>";
echo "<p>Endpoint: " . OSS_ENDPOINT . "</p>";
echo "<p>Bucket: " . OSS_BUCKET . "</p>";

// 测试OSS SDK是否可用
if (file_exists('oss-sdk/autoload.php')) {
    require_once 'oss-sdk/autoload.php';
    try {
        $ossClient = new OSS\OssClient(OSS_ACCESS_KEY_ID, OSS_ACCESS_KEY_SECRET, OSS_ENDPOINT);
        $doesExist = $ossClient->doesBucketExist(OSS_BUCKET);
        if ($doesExist) {
            echo "<div style='color:green;padding:10px;'>OSS Bucket 存在且可访问!</div>";
        } else {
            echo "<div style='color:red;padding:10px;'>OSS Bucket 不存在或无法访问</div>";
        }
    } catch (Exception $e) {
        echo "<div style='color:red;padding:10px;'>OSS连接失败: " . $e->getMessage() . "</div>";
    }
} else {
    echo "<div style='color:red;padding:10px;'>OSS SDK未找到!</div>";
}

// 服务器信息
echo "<h2>服务器信息</h2>";
echo "<p>PHP版本: " . phpversion() . "</p>";
echo "<p>服务器软件: " . $_SERVER['SERVER_SOFTWARE'] . "</p>";

// 文件权限检查
echo "<h2>文件权限检查</h2>";
$writable = is_writable('.') ? '可写' : '不可写';
echo "<p>当前目录: " . getcwd() . " ($writable)</p>";

// 测试完成
echo "<h2 style='color:green;'>测试完成</h2>";
?>
