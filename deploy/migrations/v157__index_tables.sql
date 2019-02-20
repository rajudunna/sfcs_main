/*1411 indexing for TMS dashboard */

alter table bai_pro3.module_master add unique Module_ix (module_name);

alter table bai_pro3.module_master add unique Module_Section_ix (module_name, section);

alter table bai_pro3.sections_master add index Section_ix (sec_id, sec_name);

alter table bai_pro3.sections_master add index SectionName_ix (sec_name, section_display_name);