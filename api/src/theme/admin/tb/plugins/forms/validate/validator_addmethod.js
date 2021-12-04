jQuery.extend(jQuery.validator.messages, {
    required: "必須項目です",
    maxlength: jQuery.format("{0} 文字以内で入力してください"),
    minlength: jQuery.format("{0} 文字以上で入力してください"),
    rangelength: jQuery.format("{0} 文字以上 {1} 文字以下で入力してください"),
    email: "正しいEメールアドレスを入力してください",
    url: "正しいURLを入力してください",
    dateISO: "日付を入力してください",
    number: "半角数字のみで入力してください",
    digits: "数字のみを入力してください。",
    equalTo: "同じ値を入力してください",
    range: jQuery.format(" {0} から {1} までの値を入力してください"),
    max: jQuery.format("{0} 以下の値（半角）を入力してください"),
    min: jQuery.format("{0} 以上の値（半角）を入力してください"),
    creditcard: "正しいクレジットカード番号を入力してください",
    accept: "有効な拡張子を含む値を入力してください。"
});

//filename
jQuery.validator.addMethod("filename", function(value, element){
    return this.optional(element) || /^[a-zA-Z0-9_\.\-]*$/.test(value);
}, "半角英数（0〜9、a〜z、A〜z）のみで入力してください（「-」「_」「.」含む）");

//path
jQuery.validator.addMethod("path", function(value, element){
    return this.optional(element) || /^[a-zA-Z0-9/_\.\-]*$/.test(value);
}, "半角英数（0〜9、a〜z、A〜z）のみで入力してください（「/」「-」「_」「.」含む）");

//datetype
jQuery.validator.addMethod("datetype", function(value, element){
    return this.optional(element) || /^[0-9/-]*$/.test(value);
}, "半角数字と（/-）のみで入力してください");

//datetime
jQuery.validator.addMethod("datetime", function(value, element){
    return this.optional(element) || /^[0-9/-: ]*$/.test(value);
}, "半角数字と（/-:）のみで入力してください");

//tel
jQuery.validator.addMethod("tel", function(value, element){
    return this.optional(element) || /^[\d-]*$/.test(value);
}, "正しい電話番号を入力してください");

//zip
jQuery.validator.addMethod("zip", function(value, element){
    return this.optional(element) || /\d\d\d\-?\d\d\d\d/.test(value);
}, "正しい郵便番号を入力してください");

//leng
jQuery.validator.addMethod("leng", function(value, element, param){
    return this.optional(element) || this.getLength($.trim(value), element) != param;
}, "{0} 文字で入力してください");

//numonly
jQuery.validator.addMethod("numonly", function(value, element){
    return this.optional(element) || /^\d*$/.test(value);
}, "半角数字のみで入力してください");

//hankaku
jQuery.validator.addMethod("hankaku", function(value, element){
    return this.optional(element) || /^[a-zA-Z0-9@\;\:\[\]\^\=\/\!\*\"\#\$j\%\&\'\(\)\,\.\-\_\?\\\s]*$/.test(value);
}, "半角英数のみで入力してください");

//kana
jQuery.validator.addMethod("kana", function(value, element){
    return this.optional(element) || /^([ァ-ヶー|ぁ-ん]+)$/.test(value);
}, "カタカナまたはひらがなのみで入力してください。");

//katakana
jQuery.validator.addMethod("katakana", function(value, element){
    return this.optional(element) || /^([ァ-ヶー]+)$/.test(value);
}, "カタカナのみで入力してください。");

//hiragana
jQuery.validator.addMethod("hiragana", function(value, element){
    return this.optional(element) || /^([ぁ-ん]+)$/.test(value);
}, "ひらがなのみで入力してください。");

//numeric
jQuery.validator.addMethod("numeric", function(value, element){
    return this.optional(element) || /^([0-9|０-９]+)$/.test(value);
}, "数字で入力してください。");

//nagasacheck
jQuery.validator.addMethod("nagasacheck", function(value, element){
    return this.optional(element) || (nagasa(value) < 101);
}, "101文字を超えています");

//nagasa
function nagasa(v){
    var c=0; for(i=0;i<v.length;i++){
    if(escape(v.charAt(i)).length < 4){ c++; }else{ c+=2; } } return c;
}

// 時間チェック (時分二つに分かれたフィールドをチェック)
jQuery.validator.addMethod("time_hm", function(value, element, params){
    var hour =$('#'+params[0]), min = $('#'+params[1]);
    return ( this.optional(hour) && this.optional(min) ) || ( 0 <= hour.val() && hour.val() < 24 && 0 <= min.val() && min.val() < 60 );
}, "正しい時間を入力してください");

// 日付チェック (カレンダーから入力された日付をチェック)
jQuery.validator.addMethod("date_cal", function(value, element, params){
    if ( $.isEmptyObject(value) ) return false; var parts = value.split('/'); var date = new Date(parts[0], parts[1]-1, parts[2]);
    return this.optional(element) || !( date == null || date.getFullYear() != parts[0] || date.getMonth() + 1 != parts[1] || date.getDate() != parts[2]);
}, "正しい日付を入力してください");

//複数選択肢チェック
//choice
jQuery.validator.addMethod("choice", function(value, element, params){
    return this.optional(element) || (function(){
        if ( typeof params == "undefined" || typeof params[0] == "undefined" ){
            return true;
        }
        var words = params[0].split('|');
        for ( i in words ){
            if ( words[i] == value ){
                return true;
            }
        }
            return false;
    });
}, "正しい選択肢を選んでください。");

//html記号チェック()
//htmlspecialchar <>"'  を許さない
jQuery.validator.addMethod("htmlspecialchar", function(value, element, params){
    return this.optional(element) || (function(){
        if ( typeof params == "undefined" || typeof params[0] == "undefined" ){
            return true;
        }
        var words = params[0].split('|');
        for ( i in words ){
            if ( words[i] == value ){
                return true;
            }
        }
            return false;
    });
}, "正しい選択肢を選んでください。");
