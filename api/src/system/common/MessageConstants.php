<?php

class MessageConstants {
 	
 	const COM_ERR_REQUIRED                  = '【{0}】を入力（選択）してください。';
    const COM_ERR_MAX_BYTES                 = '【{0}】は半角{1}文字以内で入力してください。';
    const COM_ERR_DATE_FORMAT               = '【{0}】の指定が不完全です。';
    const COM_ERR_INPUT_DATA_TYPE           = '【{0}】は{1}で入力してください。';
    const COM_ERR_DUPLICATE                 = '【{0}】は既に使われています。';
    const COM_ERR_DATA_NOT_FOUND            = '情報見つかりませんでした。';

    const COM_ERR_EMAIL                     = '【{0}】メールアドレスの形式が正しくありません。';
    const COM_ERR_MAX_UPLOAD_SIZE           = '【{0}】は{1}KB以下にしてください。';
    const COM_ERR_START_DATE_END_DATE       = '【{0}】を正しく入力してください。';
    const COM_ERR_INPUT_ONLY_ONE            = '【{0}】のどちらかのみ入力して下さい。';
    const COM_ERR_EXCLUSIVE                 = '他のユーザーにより既に変更されているため更新できません。';

    const COM_INFO_ADD_SUCCESS              = '登録が完了しました。';
    const COM_INFO_UPDATE_SUCCESS           = '更新が完了しました。';
    const COM_INFO_DELETE_SUCCESS           = '削除が完了しました。';
    const COM_INFO_SEARCH_RESULT_NOT_FOUND  = '該当データが見つかりませんでした。';

    const COM_CONFIRM_DELETE                = '削除してもよろしいですか？';

	const LOGIN_NOT_SUCCESS                 = 'ログイン認証に失敗しました。';

    const COM_ERR_UPLOAD_FILE_ERR           = '【{0}】 ファイルアップロードが失敗しますた。';
    const COM_ERR_UPLOAD_FILE_TYPE          = '【{0}】 の拡張子は {1}以外でアップロードしてください。';
    const COM_ERR_MAX_MIN                   = '【{0}】 は{1}から{2}まで入力してください。';
	const COM_ERR_HAPPENED                  = '入力内容に誤りがあります。入力内容を確認して下さい。';
    const COMISSION_MAX_ALLOW_RESULT_MSG    = '結果が多かったため検索条件をご入力して再検索お願いします。';

    const COM_ERR_SECURITY_FALSE            = 'セキュリティキーに誤りがあります。不明点は管理者にご連絡下さい。';
}


?>