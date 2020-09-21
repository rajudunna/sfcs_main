<?php
class TaskTypeEnum { 
    const CUTJOB = 'CUTJOB';
    const DOCKET = 'DOCKET';
    const DOCKETBUNDLE = 'DOCKETBUNDLE';
    const SEWINGJOB = 'SEWINGJOB';
    const PACKINGJOB = 'PACKINGJOB';
    const CARTON = 'CARTON';
    const EMBELLISHMENTJOB = 'CUTEMBJOB';
    const LOGICALBUNDLE = 'LOGICALBUNDLE';
    const POLYBAG = 'POLYBAG';
    const PLANNEDSEWINGJOB = 'PSJ';
    const PLANNEDEMBELLISHMENTJOB = 'PCEJ';
    const PLANNEDSEWEMBELLISHMENTJOB = 'PSEJ';
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
    const HOLD = 'HOLD';
}

class TrimStatusEnum {
    const OPEN = 'OPEN';
    const PREPARINGMATERIAL = 'Preparing material';
    const MATERIALREADYFORPRODUCTION = 'Material ready for Production';
    const PARTIALISSUED = 'Partial Issued';
    const ISSUED = 'Issued To Module';
}
?>