
/*#1550 -- disabling old cut reporting screen*/

UPDATE central_administration_sfcs.tbl_menu_list SET link_visibility = 0 WHERE  menu_pid = 1504;