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
```

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