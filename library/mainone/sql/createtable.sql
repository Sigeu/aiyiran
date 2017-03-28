/*从表*/
CREATE TABLE IF NOT EXISTS `$tablename` (
  `id`              int(11)                       NOT NULL  auto_increment,            /*主键*/
  `maintable_id`     int(11)                      NOT NULL,                            /*主表ID*/
  `content`         text                          NOT NULL,                            /*内容*/
  `template`        varchar(150)                  NOT NULL,                            /*模板*/
  `readpower`       varchar(255)                  NOT NULL,                            /*阅读权限 null或者0 则为开放浏览 */
  `allowcomment`    tinyint(2)      DEFAULT '1'   NOT NULL,                            /*评论选项 1允许评论,2不允许评论*/
  PRIMARY KEY  (`id`)
/* ,CONSTRAINT `subsidiary_maintable_id` FOREIGN KEY (`maintable_id`) REFERENCES `$maintable` (`id`)*/
)  ENGINE=InnoDB  DEFAULT  CHARSET=charset;

