/*#2622 disable menus*/


USE central_administration_sfcs;

UPDATE `central_administration_sfcs`.`tbl_menu_list`
SET link_status
=0,link_visibility=0 WHERE menu_pid IN
(1448,147,146,153,1089);
