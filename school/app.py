#!/usr/bin/env python
# -*- coding: utf-8 -*-
from flask import Flask, render_template
import pymysql  # 添加缺失的导入
from flask_sqlalchemy import SQLAlchemy
app = Flask(__name__)
# 数据库连接函数
def get_db_connection():
    conn = pymysql.connect(
        host='rm-bp1scl44p14c5bgxc.mysql.rds.aliyuncs.com',
        user='root',
        password='9123520525zS@',
        database='school_info',
        charset='utf8mb4',
        cursorclass=pymysql.cursors.DictCursor
    )
    return conn
app.config['SQLALCHEMY_DATABASE_URI'] = 'mysql+pymysql://root:9123520525zS@rm-bp1scl44p14c5bgxc.mysql.rds.aliyuncs.com/school_info'
app.config['SQLALCHEMY_TRACK_MODIFICATIONS'] = False

db = SQLAlchemy(app)

# 定义新闻模型
class News(db.Model):
    __tablename__ = 'news'
    news_id = db.Column(db.Integer, primary_key=True)  # 根据实际表结构修改
    title = db.Column(db.String(100))
    content = db.Column(db.Text)
    image_url = db.Column(db.String(200))
    create_time = db.Column(db.TIMESTAMP)

@app.route('/')
def index():
    conn = None  # 初始化 conn 为 None
    try:
        conn = get_db_connection()
        with conn.cursor() as cursor:
            sql = "SELECT * FROM news ORDER BY news_id DESC LIMIT 5"
            cursor.execute(sql)
            news = cursor.fetchall()
        return render_template(
            'index.html',
            title='校园新闻',
            news_list=news
        )
    except Exception as e:
        return f"数据库错误: {str(e)}", 500
    finally:
        # 只在 conn 存在且未关闭时关闭
        if conn and not conn._closed:
            conn.close()

if __name__ == '__main__':
    app.run(host='0.0.0.0', port=5000)
