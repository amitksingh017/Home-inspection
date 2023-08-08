function login () {

    $("#kt_login_signin_submit").click(function (i) {
        i.preventDefault();
        var e = $(this), n = $(this).closest("form");
        const url = n.attr('action');
        n.find('.invalid-feedback').remove();
        e.addClass("kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light").attr("disabled", !0), n.ajaxSubmit({
            url: url,
            headers: {
                "Accept": "application/json"
            },
            success: function (i, s, r, a) {
                e.removeClass("kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light").attr("disabled", !1);
                if (i.success && i.url) {
                    window.location.href = i.url;
                }
            },
            error: function (response) {
                e.removeClass("kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light").attr("disabled", !1);
                errors(response.responseJSON.errors, n);
            }
        });
    });

}
