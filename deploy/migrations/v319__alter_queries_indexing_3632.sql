/*#3632 Alter queries indexing*/

ALTER TABLE bai_pro3.pac_stat_log ADD KEY sch_stat (SCHEDULE, status);

ALTER TABLE bai_pro3.pac_stat ADD KEY id_carton_status (id, carton_status);