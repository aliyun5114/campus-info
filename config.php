<?php
// 生产环境从环境变量读取配置
define('DB_HOST', getenv('DB_HOST') ?: 'rm-bp1xxxx.mysql.rds.aliyuncs.com');
define('DB_NAME', getenv('DB_NAME') ?: 'campus_db');
define('DB_USER', getenv('DB_USER') ?: '');
define('DB_PASS', getenv('DB_PASS') ?: '');

// OSS配置
define('OSS_ENDPOINT', 'oss-cn-hangzhou.aliyuncs.com');
define('OSS_BUCKET', 'campus-info-oss');
