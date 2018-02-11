$(".forgot-password").click(function (e) {
    e.preventDefault();
    $("#sign_in_portion").css('display','none');
    $("#forgot_password_portion").css('display','block');
    $("#create_account_portion").css('display','none');
});

$(".create-account").click(function (e) {
    e.preventDefault();
    $("#sign_in_portion").css('display','none');
    $("#forgot_password_portion").css('display','none');
    $("#create_account_portion").css('display','block');
});

$(".already_sign_in_button").click(function (e) {
    e.preventDefault();
    $("#sign_in_portion").css('display','block');
    $("#forgot_password_portion").css('display','none');
    $("#create_account_portion").css('display','none');
});