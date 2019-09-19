/*#2113 new_menu_link disable*/


USE central_administration_sfcs;

UPDATE `central_administration_sfcs`.`tbl_menu_list` SET `link_visibility` = '0' WHERE `menu_pid` = '1663'; 

