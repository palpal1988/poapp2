$(function () {
    $("input[type='text']").keypress(function(ev) {
        if ((ev.which && ev.which === 13) || (ev.keyCode && ev.keyCode === 13)) {
            return false;
        } else {
            return true;
        }
    });
    //バリデーション
    $(".searchButton").click(function () {
        $("p.error").remove();

        //好きな作家
        $(":text").filter("#searchBox").each(function () {
            if ($(this).val() == "") {
                $(this).parent().prepend("<p class='error'>＊エリアを入力して下さい。</p>");
            }
        });
        //hiddenが空の場合はエラー
        $(":text").filter("#ido, #keido").each(function () {
            if ($(this).val() == "") {
                $(this).parent().prepend("<p class='error'>＊エリアを正しく入力して下さい。</p>");
            }
        });

        //エラーの際の処理
        if ($("p.error").size() > 0) {
            $('html,body').animate({ scrollTop: $("p.error:first").offset().top - 40 }, 'slow');
            $("p.error").parent().addClass("error");
            return false;
        }
    });
});