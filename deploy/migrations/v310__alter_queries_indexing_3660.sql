/*#3660 alter queries indexing*/

ALTER TABLE bai_pro3.ship_stat_log CHANGE ship_up_date ship_up_date VARCHAR (50) NOT NULL COMMENT 'R-schedule-ship_tid', ADD KEY ship_update (ship_up_date), ADD KEY ship_stat_tid (ship_status, ship_tid), ADD KEY sty_sch_clr (ship_style, ship_schedule, ship_color);

ALTER TABLE bai_pro3.fca_audit_fail_db ADD  KEY sty_sch_clr (style, SCHEDULE, color);