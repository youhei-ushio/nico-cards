<img width="1359" alt="ss" src="https://user-images.githubusercontent.com/59838965/186791099-7541a2ad-4d32-43c2-b922-f736e3503f34.png">

## 概要
Webで動く大富豪です。
現在の状況。
 - ラウンド開始からラウンド終了まで動作。
 - ジョーカー含みの組み合わせ未対応。
 - 前回ラウンド結果に応じたカード交換未対応。
 - 他、ローカルルール全般未対応。

## 開発向け
### Sailインストール
```
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v $(pwd):/var/www/html \
    -w /var/www/html \
    laravelsail/php81-composer:latest \
    composer install --ignore-platform-reqs
```

### Sail起動
```
sail up -d
```

### viteサーバ起動
```
sail npm run dev
```

### ユーザー登録
`http://localhost/register` にアクセス

### イベントリプレイ
イベントソーシングを採用しているので、これをしないと入退室やゲーム処理が動かない。

### 4人分の画面をタブ表示
ログインセッションはブラウザ毎なので、以下のようにGETパラメータで切り替える（もちろんローカルのみ有効）
`http://localhost/dashboard?member_id=1`<br>
`http://localhost/dashboard?member_id=2`<br>
`http://localhost/dashboard?member_id=3`<br>
`http://localhost/dashboard?member_id=4`<br>

```
env XDEBUG_SESSION=docker php artisan journal:replay
```

### イベント処理の流れ

例) 対戦部屋への入室
```mermaid
sequenceDiagram
プレイヤー->>スナップショットDB: 入室状況リクエスト
スナップショットDB->>プレイヤー: 入室状況（未入室）
プレイヤー-->>ジャーナルDB: 入室イベント送信
イベント再生バッチ-->>ジャーナルDB: イベントリクエスト
ジャーナルDB->>イベント再生バッチ: 未再生イベント
イベント再生バッチ->>スナップショットDB: 入室状況登録
プレイヤー-->>スナップショットDB: 入室状況リクエスト
スナップショットDB->>プレイヤー: 入室状況（入室済み）
```
