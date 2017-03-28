jQuery.validator.addMethod("isPhone", function (value, element, param) {
	var pattern = /^(((13[0-9]{1})|(15[0-9]{1})|(18[0-9]{1})|147|177)+\d{8})$/;
	return this.optional(element) || (pattern.test(value));
}, "手机号码不正确请重新输入");

jQuery.validator.addMethod("isEmail", function (value, element, param) {
	var pattern = /^([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/;
	return this.optional(element) || (pattern.test(value));
}, "邮箱不正确请重新输入");


