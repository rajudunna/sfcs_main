<?php
class TaskTypeEnum { 
    const CUTJOB = 'CUTJOB';
    const DOCKET = 'DOCKET';
    const DOCKETBUNDLE = 'DOCKETBUNDLE';
    const SEWINGJOB = 'SEWINGJOB';
    const PACKINGJOB = 'PACKINGJOB';
    const CARTON = 'CARTON';
    const EMBELLISHMENTJOB = 'EMBJOB';
    const LOGICALBUNDLE = 'LOGICALBUNDLE';
    const POLYBAG = 'POLYBAG';
    const PLANNEDSEWINGJOB = 'PSJ';
    const PLANNEDEMBELLISHMENTJOB = 'PCEJ';
}

class DepartmentTypeEnum
{
    const CUTTING = 'CUTTING';
    const SEWING = 'SEWING';
    const PACKING = 'PACKING';
    const INSPECTION = 'INSPECTION';
    const EMBELLISHMENT = 'EMBELLISHMENT';
    const MACHINE = 'MACHINE';
    const AQL = 'AQL';
    const CIF = 'CIF';
    const PLANNEDSEWINGJOB = 'PSJ';
    const PLANNEDEMBELLISHMENTJOB = 'PCEJ';
}


class OperationCategory {
	const CUTTING = 'CUTTING';
    const EMBELLISHMENT = 'EMBELLISHMENT';
    const SEWING = 'SEWING';
    const PACKING = 'PACKING';
}

class OperationType {
    const PANELFORM = 'PANEL-FORM';
    const SEMIGARMENTFORM = 'SEMI-GARMENT-FORM';
    const GARMENTFORM = 'GARMENT-FORM';
    const CARTONFORM = 'CARTON-FORM';
}

class TaskStatusEnum {
    const OPEN = 'OPEN';
    const INPROGRESS = 'INPROGRESS';
    const COMPLETED = 'COMPLETED';
}
?>