<img width="1359" alt="ss" src="https://user-images.githubusercontent.com/59838965/186791099-7541a2ad-4d32-43c2-b922-f736e3503f34.png">

### 概要
Webで動く大富豪です。
現在の状況。
 - ゲーム開始やカードを出す、パスをするところあたりまで。
 - 手札なくなっても勝利しない。というかラウンド終わらない。
 - 階段の判定ができていない。

## 開発向け
### イベントリプレイ
イベントソーシングを採用しているので、これをしないと入退室やゲーム処理が動かない。

```
env XDEBUG_SESSION=docker php artisan journal:replay
```
