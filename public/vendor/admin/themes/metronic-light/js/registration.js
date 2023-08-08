function registration() {
    $("#kt_login_signup_submit").click(function (n) {
        n.preventDefault();
        var s = $(this), r = $(this).closest("form");
        const url = r.attr('action');
        s.addClass("kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light").attr("disabled", !0);
        r.ajaxSubmit({
            url: url,
            headers: {
                "Accept": "application/json"
            },
            success: function (n, a, l, o) {
                s.removeClass("kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light").attr("disabled", !1);
                if (n.success && n.url) {
                    window.location.href = n.url;
                }
            },
            error: function (response) {
                s.removeClass("kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light").attr("disabled", !1);
                errors(response.responseJSON.errors, r);
            }
        });
    })
}
