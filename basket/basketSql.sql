임시장바구니 테이블.
 
create table shhan_temp (
 num int not null auto_increment primary key,
 id varchar(15) ,
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
