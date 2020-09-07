<?php
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions.php',4,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions_dashboard.php',4,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions_v2.php',4,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/enums.php',4,'R')); 
$module_limit=14;
$plant_code = $_SESSION['plantCode'];
$username =  $_SESSION['userName'];

?>
<!-- <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd"> -->

<html>
<head>
<META HTTP-EQUIV="refresh" content="900" URL="tms_dashboard_input.php">
<!-- <link rel="stylesheet" href="styles/bootstrap.min.css"> -->
<style type="text/css">
	body{
		font-family: Trebuchet MS, Lucida Sans Unicode, Arial, sans-serif;	/* Font to use */
		/* background-color:#E2EBED; */
		 background-color:white;
	}
	#footer{
		height:30px;
		vertical-align:middle;
		text-align:center;
		clear:both;
		padding-right:3px;
		background-color:#317082;
		margin-top:2px;
		width:1290px;
	}
	#footer form{
		margin:0px;
		margin-top:2px;
	}
	
	#footer p{
		float:left;
		margin-top:2px;
		color: yellow;
	}
	
	#dhtmlgoodies_dragDropContainer{	/* Main container for this script */
		width:1290px;
		height:0px;
		/* border:1px solid #317082; */
		background-color:#FFF;
		-moz-user-select:none;
	}
	#dhtmlgoodies_dragDropContainer ul{	/* General rules for all <ul> */
		margin-top:0px;
		margin-left:0px;
		margin-bottom:0px;
		padding:2px;
	}
	
	#dhtmlgoodies_dragDropContainer li,#dragContent li,li#indicateDestination{	/* Movable items, i.e. <LI> */
		list-style-type:none;
		height:25px;
		background-color:#EEE;
		border:1px solid #000;
		padding:2px;
		margin-bottom:4px;
		cursor:pointer;
		font-size:0.9em;
		border-radius:3px;
	}

	li#indicateDestination{	/* Box indicating where content will be dropped - i.e. the one you use if you don't use arrow */
		border:1px solid #317082;	
		background-color:#FFF;
	}
		
	/* LEFT COLUMN CSS */
	div#dhtmlgoodies_listOfItems{	/* Left column "Available students" */
		
		float:left;
		padding-left:10px;
		padding-right:10px;
		
		/* CSS HACK */
		width: 133px;	/* IE 5.x */
		
		/*height: 100%;*/
					
	}
	#dhtmlgoodies_listOfItems ul{	
		height:1000vh;	
		

	}
		
	div#dhtmlgoodies_listOfItems div{
		border:1px solid #999;
		border-radius:5px;	
			
	}
	div#dhtmlgoodies_listOfItems div ul{	/* Left column <ul> */
		margin-left:10px;	/* Space at the left of list - the arrow will be positioned there */
	}
	#dhtmlgoodies_listOfItems div p{	/* Heading above left column */
		margin:0px;	
		font-weight:bold;
		padding-left:32px;
		background-color:#3170A8;	
		color:#FFF;
		margin-bottom:5px;
	}
	/* END LEFT COLUMN CSS */
	
	#dhtmlgoodies_dragDropContainer .mouseover{	/* Mouse over effect DIV box in right column */
		background-color:#E2EBED;
		border:1px solid #317082;
	}
	
	/* Start main container CSS */
	
	div#dhtmlgoodies_mainContainer{	/* Right column DIV */
		width:990px; 
		float:left;	
	}
	#dhtmlgoodies_mainContainer div{	/* Parent <div> of small boxes */
		float:left;
		margin-right:10px;
		margin-bottom:10px;
		margin-top:0px;
		border:1px solid #999;
		border-radius:5px;

		/* CSS HACK */
		width: 120px;	/* IE 5.x */
		width/* */:/**/120px;	/* Other browsers */
		width: /**/120px;
				
	}
	#dhtmlgoodies_mainContainer div ul{
		margin-left:10px;
	}
	
	#dhtmlgoodies_mainContainer div p{	/* Heading above small boxes */
		margin:0px;
		padding:0px;
		padding-left:12px;
		font-weight:bold;
		background-color:#3170A8;	
		color:#FFF;	
		margin-bottom:5px;
	}
	
	#dhtmlgoodies_mainContainer ul{	/* Small box in right column ,i.e <ul> */
		width:100px;
		height:280px;	
		border:0px;	
		margin-bottom:0px;
		overflow:hidden;
		
	}
	
	#dragContent{	/* Drag container */
		position:absolute;
		width:100px;
		height:20px;
		display:none;
		margin:0px;
		padding:0px;
		z-index:2000;
	}

	#dragDropIndicator{	/* DIV for the small arrow */
		position:absolute;
		width:7px;
		height:10px;
		display:none;
		z-index:1000;
		margin:0px;
		padding:0px;
	}
	#dhtmlgoodies_mainContainer div ul {
		height: <?= ($module_limit*30).'px'; ?>
		/* overflow-y: scroll; */
	}
	</style>
	<style type="text/css" media="print">
	div#dhtmlgoodies_listOfItems{
		display:none;
	}
	body{
		background-color:#FFF;
	}
	img{
		display:none;
	}
	#dhtmlgoodies_dragDropContainer{
		border:0px;
		width:100%;
	}
	</style>	


	<script type="text/javascript">
	/************************************************************************************************************
	(C) www.dhtmlgoodies.com, November 2005
	
	Update log:
	
	December 20th, 2005 : Version 1.1: Added support for rectangle indicating where object will be dropped
	January 11th, 2006: Support for cloning, i.e. "copy & paste" items instead of "cut & paste"
	January 18th, 2006: Allowing multiple instances to be dragged to same box(applies to "cloning mode")
	
	This is a script from www.dhtmlgoodies.com. You will find this and a lot of other scripts at our website.	
	
		Terms of use:
	You are free to use this script as long as the copyright message is kept intact. However, you may not
	redistribute, sell or repost it without our permission.
	
	Thank you!
	
	www.dhtmlgoodies.com
	Alf Magne Kalleland
	
	************************************************************************************************************/
	var boxSizeArray = [];
	for(var i=0; i<200; i++){
		boxSizeArray.push('<?= $module_limit; ?>');
	}
	
	/* VARIABLES YOU COULD MODIFY */
	// var boxSizeArray = [32,32,32,32,32,32,32,32,32,32,32,32,32,32,32,32,32,32,32,32,32,32,32,32,32,32,32,32,32,32,32,32,32,32,32,32,32,32,32,32,32,32,32,32,32,32,32,32,32,32,32,32,32,32,32,32,32,32,32,32,32,32,32,32,32,32,32,32,32,32,32,32,32,32,32,32,32,32,32,32,32,32,32,32,32,32,32,32,32,32,32,32,32,32,32,32,32,32,32,32,32,32,32,32,32,32,32,32,32,32,32,32,32,32,32,32,32,32,32,32];	// Array indicating how many items there is rooom for in the right column ULs
	var arrow_offsetX = -5;	// Offset X - position of small arrow
	var arrow_offsetY = 0;	// Offset Y - position of small arrow
	
	var arrow_offsetX_firefox = -6;	// Firefox - offset X small arrow
	var arrow_offsetY_firefox = -13; // Firefox - offset Y small arrow
	
	var verticalSpaceBetweenListItems = 3;	// Pixels space between one <li> and next	
											// Same value or higher as margin bottom in CSS for #dhtmlgoodies_dragDropContainer ul li,#dragContent li
	
											
	var indicateDestionationByUseOfArrow = true;	// Display arrow to indicate where object will be dropped(false = use rectangle)

	var cloneSourceItems = false;	// Items picked from main container will be cloned(i.e. "copy" instead of "cut").	
	var cloneAllowDuplicates = false;	// Allow multiple instances of an item inside a small box(example: drag Student 1 to team A twice
	
	/* END VARIABLES YOU COULD MODIFY */
	
	var dragDropTopContainer = false;
	var dragTimer = -1;
	var dragContentObj = false;
	var contentToBeDragged = false;	// Reference to dragged <li>
	var contentToBeDragged_src = false;	// Reference to parent of <li> before drag started
	var contentToBeDragged_next = false; 	// Reference to next sibling of <li> to be dragged
	var destinationObj = false;	// Reference to <UL> or <LI> where element is dropped.
	var dragDropIndicator = false;	// Reference to small arrow indicating where items will be dropped
	var ulPositionArray = new Array();
	var mouseoverObj = false;	// Reference to highlighted DIV
	
	var MSIE = navigator.userAgent.indexOf('MSIE')>=0?true:false;
	var navigatorVersion = navigator.appVersion.replace(/.*?MSIE (\d\.\d).*/g,'$1')/1;

	
	var indicateDestinationBox = false;
	function getTopPos(inputObj)
	{		
	  var returnValue = inputObj.offsetTop;
	  while((inputObj = inputObj.offsetParent) != null){
	  	if(inputObj.tagName!='HTML')returnValue += inputObj.offsetTop;
	  }
	  return returnValue;
	}
	
	function getLeftPos(inputObj)
	{
	  var returnValue = inputObj.offsetLeft;
	  while((inputObj = inputObj.offsetParent) != null){
	  	if(inputObj.tagName!='HTML')returnValue += inputObj.offsetLeft;
	  }
	  return returnValue;
	}
	function do_disable(){
		console.log('welcome');
		  document.getElementsByClassName("saveButton").disabled = true;
		
	}
	
	function cancelEvent()
	{
		return false;
	}
	function initDrag(e)	// Mouse button is pressed down on a LI
	{
		
		var col = $(this).attr('data-color');
		if(document.all)e = event;
		var st = Math.max(document.body.scrollTop,document.documentElement.scrollTop);
		var sl = Math.max(document.body.scrollLeft,document.documentElement.scrollLeft);
		
		dragTimer = 0;
		dragContentObj.style.left = ((e.clientX + sl)) + 'px';
		dragContentObj.style.top = ((e.clientY + st)) + 'px';
		contentToBeDragged = this;
		contentToBeDragged_src = this.parentNode;
		contentToBeDragged_next = false;
		if(this.nextSibling){
			contentToBeDragged_next = this.nextSibling;
			if(!this.tagName && contentToBeDragged_next.nextSibling)contentToBeDragged_next = contentToBeDragged_next.nextSibling;
		}
		if(col == 'blue' || col == 'red'){
			timerDrag();
			return false;
		}else{
			return;
		}
	}
	
	function timerDrag()
	{
		
		if(dragTimer>=0 && dragTimer<10){
			dragTimer++;
			setTimeout('timerDrag()',10);
			return;
		}
		if(dragTimer==10){
			
			if(cloneSourceItems && contentToBeDragged.parentNode.id=='allItems'){
				newItem = contentToBeDragged.cloneNode(true);
				newItem.onmousedown = contentToBeDragged.onmousedown;
				contentToBeDragged = newItem;
			}
			dragContentObj.style.display='block';
			dragContentObj.style.marginLeft='200px';
			dragContentObj.style.marginTop='68px';
			dragContentObj.appendChild(contentToBeDragged);
		}
	}
	
	function moveDragContent(e)
	{
		
		if(dragTimer<10){
			if(contentToBeDragged){
				if(contentToBeDragged_next){
					contentToBeDragged_src.insertBefore(contentToBeDragged,contentToBeDragged_next);
				}else{
					contentToBeDragged_src.appendChild(contentToBeDragged);
				}	
			}
			return;
		}
		if(document.all)e = event;
		var st = Math.max(document.body.scrollTop,document.documentElement.scrollTop);
		var sl = Math.max(document.body.scrollLeft,document.documentElement.scrollLeft);
		
		
		dragContentObj.style.left = ((e.clientX + sl)-280) + 'px';
		dragContentObj.style.top = ((e.clientY + st)-100) + 'px';
		
		if(mouseoverObj)mouseoverObj.className='';
		destinationObj = false;
		dragDropIndicator.style.display='none';
		if(indicateDestinationBox)indicateDestinationBox.style.display='none';
		var x = e.clientX + sl;
		var y = e.clientY + st;
		var width = dragContentObj.offsetWidth;
		var height = dragContentObj.offsetHeight;
		
		var tmpOffsetX = arrow_offsetX;
		var tmpOffsetY = arrow_offsetY;
		if(!document.all){
			tmpOffsetX = arrow_offsetX_firefox;
			tmpOffsetY = arrow_offsetY_firefox;
		}

		for(var no=0;no<ulPositionArray.length;no++){
			var ul_leftPos = ulPositionArray[no]['left'];	
			var ul_topPos = ulPositionArray[no]['top'];	
			var ul_height = ulPositionArray[no]['height'];
			var ul_width = ulPositionArray[no]['width'];
			
			if((x+width) > ul_leftPos && x<(ul_leftPos + ul_width) && (y+height)> ul_topPos && y<(ul_topPos + ul_height)){
				var noExisting = ulPositionArray[no]['obj'].getElementsByTagName('LI').length;
				if(indicateDestinationBox && indicateDestinationBox.parentNode==ulPositionArray[no]['obj'])noExisting--;
				if(noExisting<boxSizeArray[no-1] || no==0){
					dragDropIndicator.style.left = ul_leftPos + tmpOffsetX + 'px';
					var subLi = ulPositionArray[no]['obj'].getElementsByTagName('LI');
					
					var clonedItemAllreadyAdded = false;
					if(cloneSourceItems && !cloneAllowDuplicates){
						for(var liIndex=0;liIndex<subLi.length;liIndex++){
							if(contentToBeDragged.id == subLi[liIndex].id)clonedItemAllreadyAdded = true;
						}
						if(clonedItemAllreadyAdded)continue;
					}
					
					for(var liIndex=0;liIndex<subLi.length;liIndex++){
						var tmpTop = getTopPos(subLi[liIndex]);
						if(!indicateDestionationByUseOfArrow){
							if(y<tmpTop){
								destinationObj = subLi[liIndex];
								indicateDestinationBox.style.display='block';
								subLi[liIndex].parentNode.insertBefore(indicateDestinationBox,subLi[liIndex]);
								break;
							}
						}else{							
							if(y<tmpTop){
								destinationObj = subLi[liIndex];
								dragDropIndicator.style.top = tmpTop + tmpOffsetY - Math.round(dragDropIndicator.clientHeight/2) + 'px';
								dragDropIndicator.style.display='block';
								break;
							}	
						}					
					}
					
					if(!indicateDestionationByUseOfArrow){
						if(indicateDestinationBox.style.display=='none'){
							indicateDestinationBox.style.display='block';
							ulPositionArray[no]['obj'].appendChild(indicateDestinationBox);
						}
						
					}else{
						if(subLi.length>0 && dragDropIndicator.style.display=='none'){
							dragDropIndicator.style.top = getTopPos(subLi[subLi.length-1]) + subLi[subLi.length-1].offsetHeight + tmpOffsetY + 'px';
							dragDropIndicator.style.display='block';
						}
						if(subLi.length==0){
							dragDropIndicator.style.top = ul_topPos + arrow_offsetY + 'px'
							dragDropIndicator.style.display='block';
						}
					}
					
					if(!destinationObj)destinationObj = ulPositionArray[no]['obj'];
					mouseoverObj = ulPositionArray[no]['obj'].parentNode;
					mouseoverObj.className='mouseover';
					return;
				}
			}
		}
		
	}
	
	/* End dragging 
	Put <LI> into a destination or back to where it came from.
	*/	
	function dragDropEnd(e)
	{
		// var module_limit = '<?= $module_limit; ?>';
		// console.log(parseInt(module_limit));
		
			if(dragTimer==-1)return;
			if(dragTimer<10){
				dragTimer = -1;
				return;
			}
			
			dragTimer = -1;
			if(document.all)e = event;	
			
			
			if(cloneSourceItems && (!destinationObj || (destinationObj && (destinationObj.id=='allItems' || destinationObj.parentNode.id=='allItems')))){
				contentToBeDragged.parentNode.removeChild(contentToBeDragged);
			}else{	
				
				if(destinationObj){
					if(destinationObj.tagName=='UL'){
						destinationObj.appendChild(contentToBeDragged);
					}else{
						destinationObj.parentNode.insertBefore(contentToBeDragged,destinationObj);
					}
					mouseoverObj.className='';
					destinationObj = false;
					dragDropIndicator.style.display='none';
					if(indicateDestinationBox){
						indicateDestinationBox.style.display='none';
						document.body.appendChild(indicateDestinationBox);
					}
					contentToBeDragged = false;
					return;
				}		
				if(contentToBeDragged_next){
					contentToBeDragged_src.insertBefore(contentToBeDragged,contentToBeDragged_next);
				}else{
					contentToBeDragged_src.appendChild(contentToBeDragged);
				}
			}
			contentToBeDragged = false;
			dragDropIndicator.style.display='none';
			if(indicateDestinationBox){
				indicateDestinationBox.style.display='none';
				document.body.appendChild(indicateDestinationBox);
				
			}
			
			mouseoverObj = false;
		
	}
	
	/* 
	Preparing data to be saved 
	*/
	function saveDragDropNodes()
	{
		
		var saveString = "";
		var sch = document.getElementById('sche').value;
		var uls = dragDropTopContainer.getElementsByTagName('UL');
		// alert (uls);
		for(var no=0;no<uls.length;no++)
		{	
			var lis = uls[no].getElementsByTagName('LI');
			for(var no2=0;no2<lis.length;no2++)
			{
				var res=lis[no2].id;
				// if(sch==res.substring(0, 6))
				// {
					if(saveString.length>0)saveString = saveString + ";";
					saveString = saveString + uls[no].id + '|' + lis[no2].id;
				//}
			}	
		}		
		
		document.forms['myForm'].listOfItems.value = saveString;
		document.forms["myForm"].submit();
		
	}
	
	function initDragDropScript()
	{
		
		dragContentObj = document.getElementById('dragContent');
		dragDropIndicator = document.getElementById('dragDropIndicator');
		dragDropTopContainer = document.getElementById('dhtmlgoodies_dragDropContainer');
		document.documentElement.onselectstart = cancelEvent;;
		var listItems = dragDropTopContainer.getElementsByTagName('LI');	// Get array containing all <LI>
		var itemHeight = false;
		for(var no=0;no<listItems.length;no++){
			listItems[no].onmousedown = initDrag;
			listItems[no].onselectstart = cancelEvent;
			if(!itemHeight)itemHeight = listItems[no].offsetHeight;
			if(MSIE && navigatorVersion/1<6){
				listItems[no].style.cursor='hand';
			}			
		}
		
		var mainContainer = document.getElementById('dhtmlgoodies_mainContainer');
		var uls = mainContainer.getElementsByTagName('UL');
		itemHeight = itemHeight + verticalSpaceBetweenListItems;
		for(var no=0;no<uls.length;no++){
			//uls[no].style.height = itemHeight * boxSizeArray[no]  + 'px';
		}
		
		var leftContainer = document.getElementById('dhtmlgoodies_listOfItems');
		var itemBox = leftContainer.getElementsByTagName('UL')[0];
		
		document.documentElement.onmousemove = moveDragContent;	// Mouse move event - moving draggable div
		document.documentElement.onmouseup = dragDropEnd;	// Mouse move event - moving draggable div
	
		
		var ulArray = dragDropTopContainer.getElementsByTagName('UL');
		for(var no=0;no<ulArray.length;no++){
			ulPositionArray[no] = new Array();
			ulPositionArray[no]['left'] = getLeftPos(ulArray[no]);	
			ulPositionArray[no]['top'] = getTopPos(ulArray[no]);	
			ulPositionArray[no]['width'] = ulArray[no].offsetWidth;
			ulPositionArray[no]['height'] = ulArray[no].clientHeight;
			ulPositionArray[no]['obj'] = ulArray[no];
		}
		
		if(!indicateDestionationByUseOfArrow){
			indicateDestinationBox = document.createElement('LI');
			indicateDestinationBox.id = 'indicateDestination';
			indicateDestinationBox.style.display='none';
			document.body.appendChild(indicateDestinationBox);

			
		}
	}
	
	window.onload = initDragDropScript;

	</script>


</head>

<body>


<?php
	$style=$_GET['style'];
	$schedule=$_GET['schedule'];
	$color=$_GET['color'];
	$cutno=$_GET['cutno'];
	$mpo=$_GET['mpo'];
	$sub_po=$_GET['sub_po'];
	$module_ref_no=$_GET["module"];
	$tasktype = TaskTypeEnum::SEWINGJOB;
	/*Function to get status from getJobsStatus
	@params : subpo,tasktype,plantcode
	@returns : task status
	*/
	if($plant_code!='')
	{
		$result_get_task_status=getJobsStatus($sub_po,$tasktype,$plant_code);
		$status=$result_get_task_status['task_status'];
	}
	

$code_db=array();
$code_db=explode("*",$code);

?>		
<br/>
<div class="col-md-12">
<div class="panel panel-primary">
<div class="panel-heading">

<?php 
$url2 = getFullURLLevel($_GET['r'],'jobs_movement_track.php',0,'N');
echo "<b>Style:</b> $style | <b>Schedule:</b> $schedule | <b>Color:</b> $color"; 
echo "<a class='btn btn-warning pull-right' style='padding: 1px 16px' href='$url2' onclick=\"return popitup2('$url2')\" target='_blank'>Sewing Jobs Movement Track</a>";
?>
</div>
<div class="panel-body">
<div>
<h4>Color Legends</h4>
<div style="margin-top: 4px;border: 1px solid #000;float: left;background-color: white;color: red;">
<div>Different Style and Schedule Jobs</div>
</div>&nbsp;&nbsp;&nbsp;
<div style="margin-top: 4px;border: 1px solid #000;float: left;background-color: yellow;color: red;margin-left: 30px;">
<div> Different Style & Schedule, Excess / Sample Jobs</div>
</div>
<div style="margin-top: 5px; border: 1px solid #000;background-color: green;color: white;float: left;margin-left: 30px;">
<div> Same Style and Schedule if Fabric requested Jobs</div>
</div>
<div style="margin-top: 4px;border: 1px solid #000;float: left;background-color: red;color: black;">
<div>Same Style and Schedule if Fabric not requested Jobs</div>
</div>
<div style="margin-top: 4px;border: 2px solid yellow;background-color: green;color: white;float: left; margin-left: 30px;">
<div>Same Style and Schedule if Fabric requested for Excess/Sample Jobs</div>
</div>
<div style="margin-top: 4px;border: 2px solid yellow;background-color: white;color: red;float: left;">
<div>Same Style and Schedule if Fabric is not requested for Excess/Sample Jobs</div> 
</div>
<div style="clear: both;"> </div>
</div>
<!-- </form> -->
<br>
<div id="dhtmlgoodies_dragDropContainer">
	<div id="dhtmlgoodies_listOfItems">
		<div id='scrollable_block' style="position: fixed;width: 150px;height:300px;overflow:scroll;margin-top: 30px;">
			<p>Jobs</p>		
		<ul id="allItems">		
		<?php
			/*To get jobs from getUnplannedJobs
			@params : sub_po,plantcode,tasktype
			@returns : job number
			*/
			$tasktype = TaskTypeEnum::SEWINGJOB;
			$result_sew_jobs=getUnplannedJobs($sub_po,$tasktype,$plant_code);
			$sewjobs=$result_sew_jobs['job_number'];
			foreach($sewjobs as $sew_num=>$jm_sew_id){
				$check="blue";
				 if($status=='OPEN')
				 {
				   echo "<li id=\"".$jm_sew_id."\" style=\" background-color:$check; color:white;\"  
				   data-color='$check'  class='apply-remove'><strong>".$sew_num."</strong></li>";
				 }
				 else
				{
					
				}

			}
		?>
			
		</ul>
		</div>

		
<form action="<?= getFullURLLevel($_GET['r'],'drag_drop_process_input.php',0,'N'); ?>" method="post" name="myForm" onclick="saveDragDropNodes()" style="position: fixed;margin-left: 47px;">
<input type="hidden" name="listOfItems" value="">
<input type="hidden" name="sche" id="sche" value="<?php echo $schedule; ?>">
<input class="btn btn-success btn-sm pull-right" type="button" name="saveButton" id="saveButton" onclick="do_disable()" value="Save">
</form>

	</div>	
	

	<div id="dhtmlgoodies_mainContainer" style="padding-left: 200px;">
	<?php
		$tasktype = TaskTypeEnum::SEWINGJOB;
		$department= DepartmentTypeEnum::SEWING;
		/** Getting work stations based on department wise
		   * @param:department,plantcode
		   * @return:workstation
		**/
		$result_worksation_id=getWorkstations($department,$plant_code);
		$workstations=$result_worksation_id['workstation'];
					            
		foreach($workstations as $work_id=>$work_des)
		{
		        echo "<div style=\"width:170px;\" align=\"center\"><h4>$work_des</h4>";

		        echo "<ul id='".$work_id."' style='width:150px'>";
		        /*
				    function to get planned jobs from workstation
				    @params:work_id,plantcode,type(sewing,cutjob,embjob)
				    @returns:job_number,task_header_id
				*/
				$result_planned_jobs=getPlannedJobs($work_id,$tasktype,$plant_code);
				$job_number=$result_planned_jobs['job_number'];
				$task_header_id=$result_planned_jobs['task_header_id'];
				    		        		            
		        //Function to get schedules from getBulkSchedules based on style,plantcode
		        $result_schedules=getBulkSchedules($style,$plant_code);
		        $schedule_details=$result_schedules['bulk_schedule'];
		        $schedule1=implode("," , $schedule_details); 
		        foreach($job_number as $sew_num=>$jm_sew_id)
		        {
					//To get taskjobs_id
					$task_jobs_id = [];
					$qry_get_task_job="SELECT task_jobs_id FROM $tms.task_jobs WHERE task_job_reference='$jm_sew_id' AND plant_code='$plant_code' AND task_type='$tasktype'";
					$qry_get_task_job_result = mysqli_query($link_new, $qry_get_task_job) or exit("Sql Error at qry_get_task_job" . mysqli_error($GLOBALS["___mysqli_ston"]));
					while ($row21 = mysqli_fetch_array($qry_get_task_job_result)) {
						$task_jobs_id[] = $row21['task_jobs_id'];
					}
                    //TO GET STYLE AND COLOR FROM TASK ATTRIBUTES USING TASK JOB ID
					$job_detail_attributes = [];
					$qry_toget_style_sch = "SELECT * FROM $tms.task_attributes where task_jobs_id ('".implode("','" , $task_jobs_id)."') and plant_code='$plant_code'";
					$qry_toget_style_sch_result = mysqli_query($link_new, $qry_toget_style_sch) or exit("Sql Error at toget_style_sch" . mysqli_error($GLOBALS["___mysqli_ston"]));
					while ($row2 = mysqli_fetch_array($get_details_result)) {
				
					   $job_detail_attributes[$row2['attribute_name']] = $row2['attribute_value'];
					
					}
					$style1 = $job_detail_attributes[$sewing_job_attributes['style']];
					$color1 = $job_detail_attributes[$sewing_job_attributes['color']]; 

					//to get qty from jm job lines
					$toget_qty_qry="SELECT sum(quantity) as qty from $pps.jm_job_bundles where jm_jg_header_id ='$jm_sew_id' and plant_code='$plant_code'";
					$toget_qty_qry_result=mysqli_query($link_new, $toget_qty_qry) or exit("Sql Error at toget_style_sch".mysqli_error($GLOBALS["___mysqli_ston"]));
					$toget_qty=mysqli_num_rows($toget_qty_qry_result);
					if($toget_qty>0){
						while($toget_qty_det=mysqli_fetch_array($toget_qty_qry_result))
						{
						   $sew_qty = $toget_qty_det['qty'];
						}
					}
			
					$id="#33AADD"; //default existing color
												
					if($style==$style1 and $color==$color1)
					{
						$id="red";
					}
					else
					{
						$id="#008080";
					}
					$title=str_pad("Style:".$style1,30)."\n".str_pad("Schedule:".$schedule1,50)."\n".str_pad("Color:".$color1,50)."\n".str_pad("Job No:".$sew_num,50)."\n".str_pad("Qty:".$sew_qty,50);

					echo '<li id="'.$jm_sew_id.'" data-color="'.$id.'" style="background-color:'.$id.';  color:white;" title="'.$title.'"><strong>'.$sew_num.'</strong></li>';  
		        }
		        echo "</ul>";
		       echo "</div>";
		}
								
	?>
	
	</div>

<br>
</div>
	</div>
	</div>
<ul id="dragContent"></ul>
<div id="dragDropIndicator">
<!--<img src='images/insert.gif'>-->
</div>
<div id="saveContent"><!-- THIS ID IS ONLY NEEDED FOR THE DEMO --></div>


</body>

</html>

<script>
    $(document).ready(function(){
        $('.apply-remove').css({'min-width':'134px'});
        $('#scrollable_block').scroll(function(){
            $('.apply-remove').css({'border':'1px solid black'});
            $('.apply-remove').css({'display':'inline-block'});
        });
    });
</script>


