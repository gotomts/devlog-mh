# 環境構築

## バージョン
* PHP 7.4
* Laravel 6.*
* MySQL 8.0
* Nginx 1.19.2

## 環境構築手順
### 1. 初期設定

画像アップロード先にAWS S3を使っています。
S3のバケットを作成後、`.env.example`を修正してください。

```
AWS_ACCESS_KEY_ID=XXXXXXXXXXXXXXXXXXX
AWS_SECRET_ACCESS_KEY=XXXXXXXXXXXXXXXXXXX
AWS_DEFAULT_REGION=XXXXXXXXXXXXXXXXXXX
AWS_BUCKET=XXXXXXXXXXXXXXXXXXX
AWS_STORAGE_URL=XXXXXXXXXXXXXXXXXXX
```

`.env.example`の修正が完了後、ファイルをコピーしてください。

```
$ cp .env.example .env
```

### 2. 環境構築

```
$ docker-compose up -d
$ docker exec wwwdevlog-mhcom_app_1 composer install
$ docker exec wwwdevlog-mhcom_app_1 php artisan key:generate
$ docker exec wwwdevlog-mhcom_app_1 php artisan key:generate --env=testing
$ docker exec wwwdevlog-mhcom_app_1 php artisan storage:link
```

### 3. サンプルデータの挿入
```
$ docker exec wwwdevlog-mhcom_app_1 php artisan migrate --seed
```

### 4. ユニットテスト
```
$ docker exec wwwdevlog-mhcom_app_1 ./vendor/bin/phpunit
```

## 管理画面へのアクセス
管理画面URL  
```
http://localhost:8080/admin
```

開発用アカウント
| メールアドレス | パスワード |
| --- | --- |
| admin@example.com | Password! |
