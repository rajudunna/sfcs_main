/*#2374 alter index*/

USE bai_pro3;

ALTER TABLE bai_pro3.embellishment_plan_dashboard ADD KEY send_qty
(module, send_qty);