# 環境構築

## ディレクトリ構成
* src:Laravelプロジェクト
* tests:SeleniumIDE用テストデータ
* vagrant
    * Vagrantfile:Vagrant設定ファイル
    * ansible:環境構築用設定ファイル

## 環境構築手順
### 1. 仮想環境起動
ターミナルを開いてvagrantディレクトリへ移動してください。  
下記のコマンドを入力し、Vagrantを起動します。  
Vagrant起動時にansibleが動き、プロジェクトの環境が自動で構築されます。

```
$ cd vagrant
$ vagrant up
```

### 2. テストデータの挿入
`vagrant ssh`で仮想環境内へアクセスし、 `/home/vagrant/www.devlog-mh.com` へ移動します。  
マイグレーションとシーダーを流し、開発用にデータを準備します。

```
$ vagrant ssh
$ cd ~/www.devlog-mh.com
$ php artisan migrate --seed
```

### 3. hosts設定
hostsファイルに下記の内容を記載します。  
* Windows `C:\Windows\System32\drivers\etc\hosts`
* Mac `/etc/hosts`

下記のURLでブラウザからアクセスし、画面が表示されれば環境構築完了です。  
http://localdev/
```
192.168.33.101 localdev
```

## ユニットテスト起動
```
$ cd ~/www.devlog-mh.com
$ ./vendor/bin/phpunit
```

## 管理画面へのアクセス
管理画面URL  
```
http://localdev/admin
```

開発用アカウント
| メールアドレス | パスワード |
| --- | --- |
| admin@example.com | Password! |
