구매내역 테이블.
 
create table shhan_buy (
 num int not null auto_increment primary key,
 id varchar(15) ,
order_id  varchar(15),
 nick varchar(10) ,
 parent int ,
 count int ,
 price int ,
 money int ,
 item_model varchar(100) ,
 item_name varchar(100) ,
 item_img_0 varchar(100) ,
 regist_day char(20)
 );

주문정보 테이블

create table shhan_order (
num int not null auto_increment primary key,
order_id  varchar(15),
id varchar(15) ,
address1 varchar(50) ,
address2 varchar(50) ,
tel varchar(50) ,
zip varchar(20) ,
email varchar(50) ,
memo varchar(500) ,
 regist_day char(20)
 );