# 概要

- OpenAPI用
- http://localhost:10082/ (swagger-ui)
- `http://localhost:10083/APIのエンドポイント`(swagger-api)

## 環境構築手順

```
$ git clone git@github.com:arsaga-partners/cloud-dental.git

$ cd .openapi

$ make init
※コンテナ起動時にapi_spec.yamlがないと失敗する恐れがあるので、
直接dockerコマンドを実行する場合はsrc/api_spec.yamlファイルがあることを確認した方がよい。
```

## 手で反映する場合
```
※基本的にはコンテナ起動時にindex.yamlの内容をマージしたapi_spec.yamlが生成される。
1. 分割した単位でファイルを生成する(pathsやschemasなど)
2. index.yamlに反映させたい内容を記載する
3. $make merge-apiを実行する
  → api_spec.yamlに反映
```