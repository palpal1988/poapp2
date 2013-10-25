$(function () {
    $(".focus").focus(function () {
        if (this.value == "エリア・駅名") {
            $(this).val("").css("color", "#f39");
        }
    });
    $(".focus").blur(function () {
        if (this.value == "") {
            $(this).val("エリア・駅名").css("color", "#969696");
        }
    });
    $("input[type='text']").keypress(function (ev) {
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
            if ($(this).val() == "エリア・駅名") {
                $(this).parent().prepend("<p class='error'>＊エリア・駅名を入力して下さい。</p>");
            }
        });
        //hiddenが空の場合はエラー
        $(":text").filter("#ido, #keido").each(function () {
            if ($(this).val() == "") {
                $(this).parent().prepend("<p class='error'>＊エリア・駅名を正しく入力して下さい。</p>");
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