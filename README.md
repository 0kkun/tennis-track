# 概要

- 　テニスアプリ

# 環境情報

### Backend

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

### Frontend

|*Tool*|*Version*|
|---|---|
|React|*|

## 環境構築手順

```
$ git clone git@github.com:0kkun/tennis-track.git

$ cd tennis-track

$ touch .env

$ cp .env.example .env

$ make init
```

## ER図作成・確認

- 以下コマンドを実行

```
$ make ss-run
$ make ss-open

```
