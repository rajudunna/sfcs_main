/*#3843 Update query for link visibility in central_administration_sfcs*/

UPDATE central_administration_sfcs.tbl_menu_list SET link_visibility=0 WHERE link_description='weekly delivery upload tool';

UPDATE central_administration_sfcs.tbl_menu_list SET link_visibility=0 WHERE link_description='weekly delivery plan upload';
