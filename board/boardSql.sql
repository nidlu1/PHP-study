 create table shhan_board (
 num int not null auto_increment primary key,
 group_num int not null,
 depth int not null,
 ord int not null,
 id varchar(15) not null,
 nick varchar(10) not null,
 subject varchar(100) not null,
 content text not null,
 regist_day char(20),
 hit int,
 is_html char(1),
 file_name_0 varchar(40),
 file_name_1 varchar(40),
 file_name_2 varchar(40),
 file_type_0 varchar(40),
 file_type_1 varchar(40),
 file_type_2 varchar(40),
 file_copied_0 varchar(30),
 file_copied_1 varchar(30),
 file_copied_2 varchar(30)
 );

 create table shhan_board_ripple (
 num int not null auto_increment primary key,
 parent int not null,
 id varchar(15) not null,
 nick varchar(10) not null,
 content text not null,
 regist_day char(20)
 );
