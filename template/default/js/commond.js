function ValidateMobile(mobile) {
    if (mobile.length != 11) { return false; }
    var myreg = /^(((13[0-9]{1})|(15[0-9]{1})|(18[0-9]{1})|147|177)+\d{8})$/;
    if (!myreg.test(mobile)) { return false; }
    return true;
}

//电子邮件的验证 
function CheckEmail(email) {
    var myreg = /^([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/;
    if (email.value == "") { return false; }
    if (!myreg.test(email)) { return false; }
    return true;
}