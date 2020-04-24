/*#3407 alter queries indexing*/

ALTER TABLE bai_pro4.week_delivery_plan ADD KEY act_ex (act_exfact);

ALTER TABLE bai_pro4.week_delivery_plan ADD KEY ship (rev_exfactory);