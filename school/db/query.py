from .connection import get_db_connection

# 查询最新新闻（带分页）
def get_latest_news(limit=3, page=1):
    offset = (page - 1) * limit
    news_list = []
    with get_db_connection() as conn:
        if conn:
            try:
                with conn.cursor() as cursor:
                    sql = """
                    SELECT news_id, title, SUBSTRING(content, 1, 200) AS short_content, 
                           publish_time, create_time
                    FROM news 
                    WHERE status=1 
                    ORDER BY publish_time DESC 
                    LIMIT %s OFFSET %s
                    """
                    cursor.execute(sql, (limit, offset))
                    news_list = cursor.fetchall()
            except pymysql.Error as e:
                print(f"查询新闻失败: {e}")
    return news_list

# 查询即将举行的活动（带时间过滤）
def get_upcoming_events(limit=3):
    events_list = []
    with get_db_connection() as conn:
        if conn:
            try:
                with conn.cursor() as cursor:
                    sql = """
                    SELECT event_id, name, event_time, location, description
                    FROM events 
                    WHERE status=1 AND event_time > NOW() 
                    ORDER BY event_time ASC 
                    LIMIT %s
                    """
                    cursor.execute(sql, (limit,))
                    events_list = cursor.fetchall()
                    # 转换时间格式
                    for event in events_list:
                        event['event_time'] = event['event_time'].strftime('%Y-%m-%d %H:%M:%S')
            except pymysql.Error as e:
                print(f"查询活动失败: {e}")
    return events_list

# 查询校园图片（带分类过滤）
def get_gallery_images(category=None, limit=8):
    images_list = []
    with get_db_connection() as conn:
        if conn:
            try:
                with conn.cursor() as cursor:
                    if category:
                        sql = """
                        SELECT gallery_id, path, description, category, upload_time
                        FROM gallery 
                        WHERE status=1 AND category=%s 
                        ORDER BY upload_time DESC 
                        LIMIT %s
                        """
                        cursor.execute(sql, (category, limit))
                    else:
                        sql = """
                        SELECT gallery_id, path, description, category, upload_time
                        FROM gallery 
                        WHERE status=1 
                        ORDER BY upload_time DESC 
                        LIMIT %s
                        """
                        cursor.execute(sql, (limit,))
                    images_list = cursor.fetchall()
            except pymysql.Error as e:
                print(f"查询图片失败: {e}")
    return images_list

# 示例：查询建筑类图片
def get_building_images(limit=8):
    return get_gallery_images(category='building', limit=limit)
