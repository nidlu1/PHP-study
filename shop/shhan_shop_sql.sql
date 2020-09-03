create table shhan_shopitem (
num int not null auto_increment primary key,
item_model varchar(40) not null,
item_name varchar(40) not null,
item_memo varchar(40) not null,
item_price int not null,
item_stack int not null,
item_regist_day char(20),
item_img_0 varchar(40),
item_img_1 varchar(40),
item_img_2 varchar(40)
);
