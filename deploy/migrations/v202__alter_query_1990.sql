TRUNCATE brandix_bts.open_style_wip;

ALTER TABLE brandix_bts.open_style_wip DROP INDEX wip, ADD UNIQUE INDEX wip (style, schedule, color, operation_code, size);
