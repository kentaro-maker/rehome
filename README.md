# rehome++ 設計書

## 環境
* PHP 7.4.8
* Laravel 8
* MySQL 8.0
* Composer 2.0.3

## ロゴ
![rehome Logo](document-image/rehome_logo.png)

## ルーティング
<table>
    <thead>
        <tr>
            <td>view</td>
            <td>controller</td>
            <td>path</td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>landing-page</td>
            <td>LandingPageController</td>
            <td>/</td>
        </tr>
        <tr>
            <td>-</td>
            <td>-</td>
            <td>/login</td>
        </tr>
        <tr>
            <td>-</td>
            <td>-</td>
            <td>/logout</td>
        </tr>
        <tr>
            <td>-</td>
            <td>-</td>
            <td>/register</td>
        </tr>
        <tr>
            <td>home</td>
            <td>HomeController</td>
            <td>/home</td>
        </tr>
        <tr>
            <td>serach</td>
            <td>SearchController</td>
            <td>/search</td>
        </tr>
        <tr>
            <td>profile</td>
            <td>ProfileController</td>
            <td>/profile</td>
        </tr>
        <tr>
            <td>setting</td>
            <td>SettingController</td>
            <td>/setting</td>
        </tr>
        <tr>
            <td>city</td>
            <td>CityController</td>
            <td>/city</td>
        </tr>
    </tbody>
</table>