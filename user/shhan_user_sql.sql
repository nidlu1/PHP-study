/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Author:  My
 * Created: 2020. 8. 29
 */

 create table shhan_user (
 id varchar(20) not null  primary key,
 pw varchar(20) not null,
 nick varchar(20) not null,
 tel varchar(30) not null,
 email varchar (100) not null,
 regist_day char(20),
 level int (10),
 cash int (50),
 mileage int (50)    
);