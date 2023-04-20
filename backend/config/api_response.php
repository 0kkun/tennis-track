<?php

return [
    'response_format' => [
        'status' => '',
        'message' => '',
        'data' => ''
    ],
    /**
     * APIのレスポンスステータスコード
     */
    'result_status' => [
        'success' => 200, // 正常に成功にした場合
        'created' => 201, // レコードを新規作成した場合
        'no_content' => 204, // 正常なリクエストが来たが、レスポンスの中身が無かった場合
        'bad_request' => 400, // リクエストが間違っている
        'unauthorized' => 401, // 未認証
        'forbidden' => 403,
        'not_found' => 404,
        'method_not_allowed' => 405, // ルーティングが無い
        'unprocessable_entity' => 422, // リクエストは正常だが引数が足りない・バリデーションに引っかかった場合など
        'server_error' => 500, // サーバ内部にエラーが発生した場合。予期しないサーバー処理のエラー。
        'service_unavailable' => 503, // 一時的にサービス提供ができない場合。（メンテナンス等）
    ],
    /**
     * ステータスコードに基づくエラーメッセージ
     */
    'messages' => [
        200 => 'Success',
        201 => 'Created',
        204 => 'No Content. There was no data to return as a response.',
        400 => 'Bad Request',
        401 => 'Unauthorized Error.',
        403 => 'Forbidden',
        404 => 'Not Found',
        405 => 'Method Not Allowed.',
        422 => 'Validation Error. There is a problem with the request params.',
        500 => 'Server Error',
        503 => 'Server Unavailable. Contact your server administrator.',
    ],
];