# sakura-github-webhook
GitHubのwebhookイベントを習得するプログラム

## 環境
- `php > 7.3`
- `apache`

## 設定
### GitHubの設定
1. レポジトリの設定から`Webhooks`を選択
2. `add Webhook`をクリック
3. `Payload URL`に`https://example.com/<レポジトリ名>`を入力
4. `Secret`に任意のパスワードを入力
5. `add Webhook`をクリック

### プログラムの設定
1. `config.php.example`をコピーして`config.php`を作成する