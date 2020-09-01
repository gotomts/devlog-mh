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
$ docker-compose exec app compose install
$ docker-compose exec app php artisan key:generate
$ docker-compose exec app php artisan key:generate --env=testing
```

### 3. サンプルデータの挿入
```
$ docker-compose exec app php artisan migrate --seed
```

### 4. ユニットテスト
```
$ docker-compose exec app ./vendor/bin/phpunit
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
