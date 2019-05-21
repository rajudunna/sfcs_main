/*#1984 menu link name update*/
USE central_administration_sfcs;

UPDATE central_administration_sfcs.tbl_menu_list SET link_description = 'Hourly Efficiency Report 02' WHERE menu_pid = '1653';

UPDATE central_administration_sfcs.rbac_role_menu SET menu_description = 'Hourly Efficiency Report 02' WHERE menu_pid = '1653';