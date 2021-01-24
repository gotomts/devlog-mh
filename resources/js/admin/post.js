// マークダウンに入力があった場合はHTMLを生成
$(function(){
    let text = $('#content').text();
    if ("" !== text) {
        document.getElementById('html-preview').innerHTML =
        marked(text);
    }
    // テキスト入力した場合にマークダウンからHTMLを生成
    $('#content').on('input', function(){
        text = $('#content').val();
        document.getElementById('html-preview').innerHTML =
        marked(text);
    });
    // 保存するボタンをクリックしたら「html-preview」内のHTMLを取得し、hidden-contentに代入
    let html = null;
    $('.save').on('click', function(){
        html = $('#html-preview').html();
        $('#hidden-content').val(html);
    });
});

// ステータスで限定公開が選択された場合のみ表示する
$(function(){
    // 会員種別チェックボックスリスト
    const $memberLimitationList = $('.member-limitation-list');
    const $status = $('#inputStatus1');
    if ($status.val() === '3') {
        console.log($memberLimitationList.find('.form-check-input').show());
        // 限定公開だったら表示
        $memberLimitationList.find('.form-check-input').prop('disabled', false);
        $memberLimitationList.show();
    } else {
        // 限定公開以外は非表示
        $memberLimitationList.hide();
        $memberLimitationList.find('.form-check-input').prop('disabled', true);
    }
    // プルダウンが選択されたときの動き
    $status.on('change', function() {
        if ($(this).val() === '3') {
            // 限定公開が選択されたら表示
            $memberLimitationList.find('.form-check-input').prop('disabled', false);
            $memberLimitationList.show();
        } else {
            // 限定公開以外は非表示
            $memberLimitationList.hide();
            $memberLimitationList.find('.form-check-input').prop('disabled', true);
        }
    });
});