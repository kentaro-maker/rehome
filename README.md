# rehome++ 設計書

## 環境
* PHP 7.4.8
* Laravel 8
* MySQL 8.0
* Composer 2.0.3

## ロゴ
![rehome Logo](document-image/rehome_logo_w300.png)

## セットアップ
1. git clone https://github.com/kentaro-maker/rehome.git
2. composer install
3. php artisan migrate
4. php artisan db:seed
5. php artisan storage:link
6. php artisan serve

## 完成イメージ
* [グーネット](https://www.goo-net.com/)
* [カーセンサー](https://www.carsensor.net/)
* [価格ドットコム　自動車・バイク](https://kakaku.com/kuruma/used/)

こういう感じになる

## TODO
* Userの登録情報を変更できるようにする
* CityControllerの作成
* 検索部分 
    * 条件検索
        * 補助金別検索
        * 現居住地から距離検索
        * 出身地から距離検索
        * 都市へのアクセス検索
        * 画像ギャラリーから検索
        など
    * 質問検索
        * 今の職業への満足度
        * 生活に求めるもの
        * 行政に求めるもの


## つまったところ
LaravelとMySQLで文字コードを設定しなおしても、コマンドプロント上で日本語が表示されない場合
コマンドプロンプトの文字コードを変更する必要がある
```
C:\Users\ユーザ名>chcp
現在のコード ページ: 932    # shift-js
C:\Users\ユーザ名>CHCP 65001 #utf-8
``` 

これだと再起動時に932(Shift-js)に戻ってしまう。

#### 対処法
Windowsキー + R で 「cmd /K "chcp 65001"」でコマンドプロンプトを起動する。