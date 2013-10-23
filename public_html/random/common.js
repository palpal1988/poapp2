$(function () {
    //バリデーション
    $("form").submit(function () {

        $("p.error").remove();

        //好きな作家
        $(":text").filter("#searchBox").each(function () {
            if ($(this).val() == "") {
                $(this).parent().prepend("<p class='error'>＊エリアを入力して下さい。</p>");
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