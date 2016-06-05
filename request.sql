
CREATE TABLE `table_list`(
`id`int(100) not NULL AUTO_INCREMENT PRIMARY KEY,
`user_name`VARCHAR (255)not NULL,
`parent_id`int(100),

`lft`int(100) not NULL,
`rgt`int(100) not NULL
);


INSERT INTO `table_list` (`id`,`user_name`,`lft`,`rgt`,`parent_id`)
VALUES (1,'root',1,4,0);

INSERT INTO `table_list` (`user_name`,`lft`,`rgt`,parent_id)
VALUES ('Alex',2,3,1);
