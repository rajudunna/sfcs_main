<?php

class OperationType
{
	static $OperationTypeArray = array(10=>'Laying',15=>'Cut',17=>'CutPanelInspection',30=>'Fusing',18=>'BundlingOne',20=>'Numbering',40=>'AINPRTSendPF',50=>'AINPRTReceivePF',60=>'AINEMBSendPF',70=>'AINEMBReceivePF',41=>'EM1SQSendPF',42=>'EM1SQReceivePF',61=>'EM2PASendPF',62=>'EM2PAReceivePF',63=>'EM3SQSendPF',64=>'EM3SQReceivePF',75=>'BundlingTwo',100=>'SewInPrep',101=>'SewOutPrep',110=>'EM1SendSFG',115=>'EM1ReceiveSFG',120=>'EM2SendSFG',125=>'EM2ReceiveSFG',126=>'EM3SendSFG',127=>'EM3ReceiveSFG',128=>'BundlingThree',129=>'SewIn',130=>'SewOut',140=>'EndLineQuality',143=>'EM1SendFG',144=>'EM1ReceiveFG',147=>'EM2SendFG',148=>'EM2ReceiveFG',151=>'WashingSend',154=>'EM3SendFG',155=>'EM3ReceiveFG',160=>'WashingReceive',180=>'Finishing',190=>'PolyBagPacking',200=>'CartonPacking',300=>'WaistBlockContrastPanelCut',301=>'EM1SendBLC',305=>'EM1ReceiveBLC',306=>'EM2SendBLC',307=>'EM2ReceiveBLC',21=>'MOLS01MoldingSend',22=>'MOLR01MoldingReceive');

    const __default = 'Laying';
    const V10 = 'Laying';
    const V15 = 'Cut';
    const V17 = 'CutPanelInspection';
    const V30 = 'Fusing';
    const V18 = 'BundlingOne';
    const V20 = 'Numbering';
    const V40 = 'AINPRTSendPF';
    const V50 = 'AINPRTReceivePF';
    const V60 = 'AINEMBSendPF';
    const V70 = 'AINEMBReceivePF';
    const V41 = 'EM1SQSendPF';
    const V42 = 'EM1SQReceivePF';
    const V61 = 'EM2PASendPF';
    const V62 = 'EM2PAReceivePF';
    const V63 = 'EM3SQSendPF';
    const V64 = 'EM3SQReceivePF';
    const V75 = 'BundlingTwo';
    const V100 = 'SewInPrep';
    const V101 = 'SewOutPrep';
    const V110 = 'EM1SendSFG';
    const V115 = 'EM1ReceiveSFG';
    const V120 = 'EM2SendSFG';
    const V125 = 'EM2ReceiveSFG';
    const V126 = 'EM3SendSFG';
    const V127 = 'EM3ReceiveSFG';
    const V128 = 'BundlingThree';
    const V129 = 'SewIn';
    const V130 = 'SewOut';
    const V140 = 'EndLineQuality';
    const V143 = 'EM1SendFG';
    const V144 = 'EM1ReceiveFG';
    const V147 = 'EM2SendFG';
    const V148 = 'EM2ReceiveFG';
    const V151 = 'WashingSend';
    const V154 = 'EM3SendFG';
    const V155 = 'EM3ReceiveFG';
    const V160 = 'WashingReceive';
    const V180 = 'Finishing';
    const V190 = 'PolyBagPacking';
    const V200 = 'CartonPacking';
    const V300 = 'WaistBlockContrastPanelCut';
    const V301 = 'EM1SendBLC';
    const V305 = 'EM1ReceiveBLC';
    const V306 = 'EM2SendBLC';
    const V307 = 'EM2ReceiveBLC';
    const V21 = 'MOLS01MoldingSend';
    const V22 = 'MOLR01MoldingReceive';

}

class UpdateM3{
var $type;//OperationType
var $action;//Action
var $inputData;//InputData
}
class UpdateM3Response{
var $UpdateM3Result;//ArrayOfM3UpdateResult
}
class UpdateScrap{
var $type;//OperationType
var $action;//Action
var $inputData;//InputData
}
class UpdateScrapResponse{
var $UpdateScrapResult;//ArrayOfM3UpdateResult
}
class IsOperationReported{
var $RemarkKey;//string
}
class IsOperationReportedResponse{
var $IsOperationReportedResult;//boolean
}
class InputData{
var $Application;//string
var $DeviationWorkCenter;//string
var $FactoryCode;//string
var $InputValues;//ArrayOfInputValue
var $JobNumber;//string
var $ShiftCode;//string
var $TransactionDate;//dateTime
var $UserName;//string
}
class ArrayOfInputValue{
var $InputValue;//InputValue
}
class InputValue{
var $ColorCode;//string
var $JobNumber;//string
var $MONumber;//string
var $Quantity;//int
var $RemarkKey;//string
var $SchelduleCode;//string
var $ScrapReason;//string
var $SizeCode;//string
var $StyleCode;//string
}
class ArrayOfM3UpdateResult{
var $M3UpdateResult;//M3UpdateResult
}
class M3UpdateResult{
var $ColorCode;//string
var $ErrorCode;//int
var $ErrorDescription;//string
var $HasError;//boolean
var $IsSucess;//boolean
var $JobNumber;//string
var $MONumber;//string
var $Quantity;//int
var $ScheduleCode;//string
var $ScrapReason;//string
var $SizeCode;//string
var $StyleCode;//string
}
class FaultDetail{
var $ErrorCode;//int
var $Message;//string
var $Type;//ExceptionType
}
class PTSService 
 {
 var $soapClient;
 
private static $classmap = array('UpdateM3'=>'UpdateM3'
,'UpdateM3Response'=>'UpdateM3Response'
,'UpdateScrap'=>'UpdateScrap'
,'UpdateScrapResponse'=>'UpdateScrapResponse'
,'IsOperationReported'=>'IsOperationReported'
,'IsOperationReportedResponse'=>'IsOperationReportedResponse'
,'InputData'=>'InputData'
,'ArrayOfInputValue'=>'ArrayOfInputValue'
,'InputValue'=>'InputValue'
,'ArrayOfM3UpdateResult'=>'ArrayOfM3UpdateResult'
,'M3UpdateResult'=>'M3UpdateResult'
,'FaultDetail'=>'FaultDetail'

);

function __construct($url='http://bci-mvxtest-01:1021/PTSService.svc?singleWsdl')
{
  $this->soapClient = new SoapClient($url,array("trace" => true,"exceptions" => true));
}
 
function UpdateM3(UpdateM3 $UpdateM3)
{

try {
	$UpdateM3Response = $this->soapClient->UpdateM3($UpdateM3);
} catch (SoapFault $fault) {
	$UpdateM3Response = $fault;
}
return $UpdateM3Response;

}
function UpdateScrap(UpdateScrap $UpdateScrap)
{
try {
   $UpdateScrapResponse = $this->soapClient->UpdateScrap($UpdateScrap);
} catch (SoapFault $fault) {
	$UpdateScrapResponse = $fault;
}
return $UpdateScrapResponse;

}
function IsOperationReported(IsOperationReported $IsOperationReported)
{

$IsOperationReportedResponse = $this->soapClient->IsOperationReported($IsOperationReported);
return $IsOperationReportedResponse;

}}


?>                                
                            