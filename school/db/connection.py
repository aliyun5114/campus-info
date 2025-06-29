import pymysql
from .config import DB_CONFIG
import contextlib

class DatabaseConnection:
    def __init__(self):
        self.connection = None
    
    def connect(self):
        try:
            ssl = {
                   'ca': '/path/to/rds_ssl.pem'  # 从RDS控制台下载的SSL证书
                  }
            self.connection = pymysql.connect(
            **DB_CONFIG,
            ssl=ssl  # 如需SSL请启用
            )
            print("数据库连接成功")
            return self.connection
        except pymysql.Error as e:
            print(f"数据库连接失败: {e}")
            if "caching_sha2_password" in str(e):
                print("错误原因：认证方式不兼容，请确保已将用户认证改为mysql_native_password")
            return None
    
    def close(self):
        if self.connection:
            self.connection.close()
            print("数据库连接已关闭")


@contextlib.contextmanager
def get_db_connection():
    db = DatabaseConnection()
    conn = db.connect()
    try:
        yield conn
    finally:
        if conn:
            db.close()
