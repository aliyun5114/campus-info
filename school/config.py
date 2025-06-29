DEBUG = True
PORT = 5000
from .connection import DatabaseConnection


def get_latest_news(limit=3):
    db = DatabaseConnection()
    conn = db.connect()
    news_list = []
    
    if conn:
        try:
            with conn.cursor() as cursor:
                sql = "SELECT news_id, title, content, publish_time FROM news WHERE status=1 ORDER BY publish_time DESC LIMIT %s"
                cursor.execute(sql, (limit,))
                news_list = cursor.fetchall()
        finally:
            db.close()
    
    return news_list

def get_upcoming_events(limit=3):
    db = DatabaseConnection()
    conn = db.connect()
    events_list = []
    
    if conn:
        try:
            with conn.cursor() as cursor:
                sql = "SELECT event_id, name, event_time, location FROM events WHERE status=1 AND event_time > NOW() ORDER BY event_time ASC LIMIT %s"
                cursor.execute(sql, (limit,))
                events_list = cursor.fetchall()
        finally:
            db.close()
    
    return events_list

def get_gallery_images(category=None, limit=8):
    db = DatabaseConnection()
    conn = db.connect()
    images_list = []
    
    if conn:
        try:
            with conn.cursor() as cursor:
                if category:
                    sql = "SELECT gallery_id, path, description FROM gallery WHERE status=1 AND category=%s ORDER BY upload_time DESC LIMIT %s"
                    cursor.execute(sql, (category, limit))
                else:
                    sql = "SELECT gallery_id, path, description FROM gallery WHERE status=1 ORDER BY upload_time DESC LIMIT %s"
                    cursor.execute(sql, (limit,))
                images_list = cursor.fetchall()
        finally:
            db.close()
    
    return images_list
