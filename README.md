# 概要

- 　テニスアプリ

# 環境情報

## Backend

|*Tool*|*Version*|
|---|---|
|laravel|9.52.6|
|PHP|8.1.8|
|Composer|2.4.4|
|Nginx|1.20.1|
|MySQL|8.0.28|
|node|v16.14.0|
|npm|v8.3.1|
|nvm|0.34.0|
|schemaspy|6.1.0|

## Frontend

|*Tool*|*Version*|
|---|---|
|React|18.0.28|
|Typescript|5.0.2|
|vite|4.3.2|
|node|v16.14.0|
|npm|8.3.1|

# 環境構築手順

```
$ git clone git@github.com:0kkun/tennis-track.git

$ cd tennis-track

$ touch .env

$ cp .env.example .env

$ make init

$ make npm-run
```

- 以下がログイン画面

`http://localhost:3000/login`

# ER図作成・確認

- 以下コマンドを実行

```
$ make ss-run
$ make ss-open

```

# OpenAPI

- 以下コマンドを実行。swagger-uiで確認できる

```
$ cd .openapi
$ make init
$ make open
```

# コマンド

- 初回、以下順番にて実行する必要がある

```
$ php artisan command:ScrapeTennisRanking
$ php artisan command:ScrapeTennisPlayer
$ php artisan command:ScrapeTennisPlayerInfo
```

# ログイン情報 (local)

- admin

`POST http://localhost:80/api/v1/admins/login`

```
{
  "email":"admin@example.com",
  "password":"password"
}
```

- user

`POST http://localhost:80/api/v1/users/login`

```
{
  "email":"user@example.com",
  "password":"password"
}
```

- レスポンス

以下、tokenをBearerトークンとしてヘッダーに入れる

```
{
  "status": 200,
  "message": "Success",
  "data": {
  "token": "1|llQKbJTcGAIXI4W7en1To9yXL37U0UxahT0pC0t3"
}
} 
```


# ディレクトリ構成 (/backend)

```
.
├── .docker/
│   ├── db/
│   │   ├── Dockerfile
│   │   └── my.cnf
│   ├── nginx/
│   │   ├── Dockerfile
│   │   └── nginx.conf
│   └── php/
│       ├── Dockerfile
│       └── php.ini
├── backend/
│       ├── app/
│       ├── bootstrap/
│       ├── config/
│       ├── database/
│       ├── lang/
│       ├── public/
│       ├── resources/
│       ├── routes/
│       ├── storage/
│       ├── tests/
│       ├── .env.example
│       ├── composer.json
│       ├── composer.lock
│       ├── package.json
│       ├── package-lock.json
.
.
.
```

# ディレクトリ構成 (/frontend)

```
.
├── public/
├── src/
│   ├── @types/
│   ├── components/
│   │   ├── elements/
│   │   └── layouts/
│   ├── features/
│   ├── components/
│   ├── hooks/
│   ├── libs/
│   ├── pages/
│   │   ├── users/
│   │   └── admins/
│   ├── providers/
│   ├── routes/
│   │   └── AppRoutes.tsx
│   ├── App.css
│   ├── App.tsx
│   └── main.tsx
├── index.html
```

- `public/`: パブリックなリソース（HTML、画像、フォントなど）が格納されるディレクトリです。ここに配置されたファイルは、ビルドプロセスで自動的にコピーされます。
- `src/`: ソースコードが格納されるメインのディレクトリです。
  - `@types/`: 型定義ファイル（TypeScriptの型情報）が格納されるディレクトリです。外部ライブラリの型定義やカスタムの型定義を追加することができます。
  - `components/`: Reactのコンポーネントが格納されるディレクトリです。UIの再利用可能な部品やレイアウト用のコンポーネントなどが含まれます。
    - `elements/`: UIの基本要素となる小さなコンポーネント（ボタン、テキストフィールドなど）が格納されるディレクトリです。
    - `layouts/`: アプリケーションのレイアウト用のコンポーネントが格納されるディレクトリです。ヘッダーやフッターなどのアプリケーション全体のレイアウトを定義するために使用されます。
  - `features/`: アプリケーションの機能ごとに分割された機能モジュールが格納されるディレクトリです。例えば、ユーザー機能や管理者機能など、独立した機能を持つ部分をまとめて管理するために使用されます。
  - `hooks/`: カスタムフック（Custom Hook）が格納されるディレクトリです。再利用可能なロジックや状態管理のためのカスタムフックが定義されます。
  - `libs/`: ユーティリティ関数や共通の処理など、ライブラリとして使用されるコードが格納されるディレクトリです。
  - `pages/`: アプリケーションの各ページに対応するコンポーネントが格納されるディレクトリです。ルーティングされる各ページごとにディレクトリを作成し、その中にコンポーネントを配置します。
    - `users/`: ユーザー関連のページに対応するコンポーネントが格納されるディレクトリです。ユーザーのプロファイル、ログイン、サインアップなどの機能を持つページコンポーネントが配置されます。
    - `admins/`: 管理者関連のページに対応するコンポーネントが格納されるディレクトリです。管理者ダッシュボード、ユーザー管理、設定などの機能を持つページコンポーネントが配置されます。 
  - `providers/`: Reactのコンテキストプロバイダーや状態管理ライブラリ（例：Redux）のプロバイダーが格納されるディレクトリです。アプリケーション全体での状態管理や共有のために使用されます。
  - `routes/`: アプリケーションのルーティングに関連するファイルが格納されるディレクトリです。通常はルーティングの設定やプライベートルートの認証などを管理します。
    - AppRoutes.tsx: アプリケーションのルートコンポーネントやルーティングの設定が定義されるファイルです。
  - App.css: アプリケーション全体のスタイルを定義するためのCSSファイルです。
  - App.tsx: アプリケーションのエントリーポイントであり、ルートコンポーネントが定義されるファイルです。
  - main.tsx: アプリケーションの起動やDOMのレンダリングを行うファイルです。
- index.html: アプリケーションのエントリーポイントとなるHTMLファイルです。Reactアプリケーションのビルド時に生成されるJavaScriptファイルが読み込まれます。

## 外部APIのメモ

### Rapidapi
- [ダッシュボード](https://rapidapi.com/developer/dashboard)

### SportRador
- [コンソール](https://console.sportradar.com/accounts/6605310de53c782eb5b6cfaa/6605310de53c782eb5b6cfab)
