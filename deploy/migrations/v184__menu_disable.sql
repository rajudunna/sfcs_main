/*#1735 menu disable*/
UPDATE central_administration_sfcs.tbl_menu_list SET link_visibilty = 0 WHERE menu_pid IN (202,175,512,1515);

