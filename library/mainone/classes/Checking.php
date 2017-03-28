<?php
class validate {

    /*
     * isNumber
     * 数字
     * @param string $number 验证数据
     *
     * @return bool
     *
     */
    public function isNumber($number) {

        return (boolean)preg_match('/^-?\d+$/', $number);
    }

    /*
     * isPhone
     * 电话号码
     * @param string $phone 验证数据
     *
     * @return bool
     *
     */
    public function isPhone($phone) {

        return (boolean)preg_match('/^((0\d{2,3})-)(\d{7,8})(-(\d{3,}))?$/', $phone);
    }

    /*
     * isMobile
     * 手机号
     * @param string $mobile 验证数据
     *
     * @return bool
     *
     */
    public function isMobile($mobile) {

        return (boolean)preg_match('/(^(\d{2,4}[-_－—]?)?\d{3,8}([-_－—]?\d{3,8})?([-_－—]?\d{1,7})?$)|(^0?1[35]\d{9}$)/', $mobile);
    }

    /*
     * isPostCode
     * 邮编
     * @param string $postCode 验证数据
     *
     * @return bool
     *
     */
    public function isPostCode($postCode) {

        return (boolean)preg_match('/^\d{4,6}$/', $postCode);
    }

    /*
     * isEmail
     * 邮箱
     * @param string $email 验证数据
     * @param string $domain 域名
     *
     * @return bool
     *
     */
    public function isEmail($email, $domain = "") {

        // 是否是某域名下的邮箱
        if ($domain) {
            $reg = '/^[a-z0-9-_.]+@' . $domain . '$/i';
        } else {
            $reg = '/^[a-z0-9-_.]+@[\da-z][\.\w-]+\.[a-z]{2,4}$/i';
        }

        return (boolean)preg_match($reg, $email);
    }

    /*
     * isDate
     * 日期
     * @param string $date 验证数据
     *
     * @return bool
     *
     */
    public function isDate($date) {
        return (boolean)preg_match('/^\d{4}\-[]\d{2}\-\d{2}$/', $date);
    }

    /*
     * isIp
     * ip
     * @param string $ip 验证数据
     *
     * @return bool
     *
     */
    public function isIp($ip) {
        return (boolean)ip2long($ip);
    }

    /*
     * isMoney
     * 金额
     * @param string $money 验证数据
     *
     * @return bool
     *
     */
    public function isMoney($money) {

        return (boolean)preg_match('/^\d+(\.\d{1,2})?$/', $money);
    }

    /*
     * isChinese
     * 中文
     * @param string $string 验证数据
     *
     * @return bool
     *
     */
    public function isChinese($string) {

        return (boolean)preg_match("/^[\x7f-\xff]+$/", $string);
    }
}
?>