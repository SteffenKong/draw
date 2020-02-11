create database if not exists draw charset=utf8;
use draw;

-- 管理员表
create table if not exists draw_admin(
    id mediumint unsigned auto_increment,
    account varchar(191) not null comment '账号',
    password varchar(191) not null comment '密码',
    status tinyint default 1 comment '管理员状态 0 - 禁用 1 - 启用'
    login_setting varchar(191) not null comment '是否设置登录通知 0 - 未设置 1 - 已设置',
    created_at datetime,
    updated_at datetime,
    primary key (id),
    unique key uk_account(account)
)charset=utf8,engine=innodb;


-- 管理员信息附属表
create table if not exists draw_admin_info(
    id mediumint unsigned auto_increment,
    admin_id mediumint unsigned not null comment '管理员id',
    email varchar(191) comment '邮箱',
    phone varchar(191) comment '手机号码',
    created_at datetime,
    updated_at datetime,
    primary key (id),
    unique key uk_admin_id (admin_id),
    unique key uk_email(email)
)charset=utf8,engine=innodb;


-- 组员表
create table if not exists draw_user(
    id mediumint unsigned auto_increment,
    name varchar(191) not null comment '组员姓名',
    number varchar(191) not null comment '员工编号',
    status tinyint default 1 not null comment '是否可进行抽签 0 - 不可抽 1 - 可抽',
    is_draw tinyint not null comment '抽签状态 0 - 未抽 1 - 已抽',
    draw_time datetime comment '抽签日期',
    created_at datetime,
    updated_at datetime,
    primary key(id),
    unique key uk_name (name)
)charset=utf8,engine=innodb;


-- 管理员日志
create table if not exists draw_admin_log(

)charset=utf8,engine=innodb;


-- 登录日志
create table if not exists draw_login_log(

)charset=utf8,engine=innodb;
