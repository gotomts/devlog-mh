$(function(){
    // マークダウンに入力があった場合はHTMLを生成
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
