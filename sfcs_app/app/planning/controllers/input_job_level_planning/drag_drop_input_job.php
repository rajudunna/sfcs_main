<?php
//$username_list=explode('\\',$_SERVER['REMOTE_USER']);
//$username=strtolower($username_list[1]);
// $username="sfcsproject1";
$has_perm=haspermission($_GET['r']);

// $super_user=array("roshanm","muralim","kirang","bainet","rameshk","baiict","gayanl","baisysadmin","chathurangad","buddhikam","saroasa","chathurikap","sfcsproject2","thanushaj","kemijaht","sfcsproject1","ber_databasesvc","saranilaga","thusiyas","thineshas","sudathra");

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
		
	/* VARIABLES YOU COULD MODIFY */
	var boxSizeArray = [14,14,14,14,14,14,14,14,14,14,14,14,14,14,14,14,14,14,14,14,14,14,14,14,14,14,14,14,14,14,14,14,14,14,14,14,14,14,14,14,14,14,14,14,14,14,14,14,14,14,14,14,14,14,14,14,14,14,14,14,14,14,14,14,14,14,14,14,14,14,14,14,14,14,14,14,14,14,14,14,14,14,14,14,14,14,14,14,14,14,14,14,14,14,14,14,14,14,14,14,14,14,14,14,14,14,14,14,14,14,14,14,14,14,14,14,14,14,14,14];	// Array indicating how many items there is rooom for in the right column ULs
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
		timerDrag();
		return false;
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
		var uls = dragDropTopContainer.getElementsByTagName('UL');
		for(var no=0;no<uls.length;no++){	// LOoping through all <ul>
			var lis = uls[no].getElementsByTagName('LI');
			for(var no2=0;no2<lis.length;no2++){
				if(saveString.length>0)saveString = saveString + ";";
				saveString = saveString + uls[no].id + '|' + lis[no2].id;
				//alert(saveString);
			}	
		}		
		
		//document.getElementById('saveContent').innerHTML = '<h1>Ready to save these nodes:</h1> ' + saveString.replace(/;/g,';<br>') + '<p>Format: ID of ul |(pipe) ID of li;(semicolon)</p><p>You can put these values into a hidden form fields, post it to the server and explode the submitted value there</p>';
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
//include("../".getFullURL($_GET['r'],'dbconf.php','R')); 
//include("../".getFullURL($_GET['r'],"functions.php",'R')); 
// include('dbconf.php');
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions.php',4,'R'));
// include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'functions.php',1,'R'));
$style=$_GET['style'];
$schedule=$_GET['schedule'];
$color=$_GET['color'];
$cutno=$_GET['cutno'];
$module_ref_no=$_GET["module"];











	$newfiltertable="temp_pool_db.plan_doc_summ_input_v2_".$username;
	$sql="DROP TABLE IF EXISTS $newfiltertable";
	//echo $sql."<br/>";
	//mysql_query($sql,$link) or exit("Sql Error17".mysql_error()
	
	//$schedule_list=$schedule;
	
	$sql2="select * from $bai_pro3.bai_orders_db where order_joins=\"J$schedule\"";
	$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error8".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_num_check2=mysqli_num_rows($sql_result2);
	if($sql_num_check2 > 0)
	{
		$sql3="select distinct order_del_no as del from $bai_pro3.bai_orders_db where order_joins=\"J$schedule\"";
	}
	else
	{
		$sql3="select distinct order_del_no as del from $bai_pro3.bai_orders_db where order_del_no=\"$schedule\"";
	}
	
	$sql_result3=mysqli_query($link, $sql3) or exit("Sql Error8".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_num_check3=mysqli_num_rows($sql_result3);
	while($sql_row3=mysqli_fetch_array($sql_result3))
	{
		$schedule_no[]=$sql_row3["del"];
	}
	
	$schedule_list=implode(",",$schedule_no);
	
	//This is to handle schedule club deliveries
	$sql="DROP TABLE IF EXISTS $newfiltertable";
	//echo $sql."<br/>";
	mysqli_query($link, $sql) or exit("Sql Error17".mysqli_error($GLOBALS["___mysqli_ston"]));



	if($cutno!='All')
	{
		$sql="CREATE TABLE $newfiltertable ENGINE = MYISAM select type_of_sewing,order_style_no,input_job_no_random,group_concat(distinct input_job_no) as input_job_no,doc_no,group_concat(distinct char(color_code)) as color_code,group_concat(distinct acutno) as acutno,act_cut_status,input_job_input_status(input_job_no_random) as act_cut_issue_status,cat_ref,SUM(carton_act_qty) AS carton_qty from plan_doc_summ_input where order_del_no in ($schedule_list) and acutno=$cutno and input_job_no_random not in (select input_job_no_random_ref from plan_dashboard_input) and input_job_input_status(input_job_no_random)='' group by input_job_no order by input_job_no*1";
	}
	else
	{
		$sql="CREATE TABLE $newfiltertable ENGINE = MYISAM select type_of_sewing,order_style_no,input_job_no_random,group_concat(distinct input_job_no) as input_job_no,doc_no,group_concat(distinct char(color_code)) as color_code,group_concat(distinct acutno) as acutno,act_cut_status,input_job_input_status(input_job_no_random) as act_cut_issue_status,cat_ref,SUM(carton_act_qty) AS carton_qty from plan_doc_summ_input where order_del_no in ($schedule_list) and input_job_no_random not in (select input_job_no_random_ref from plan_dashboard_input) and input_job_input_status(input_job_no_random)='' group by input_job_no order by input_job_no*1";
	}
	// echo $sql."<br/>";
	mysqli_query($link, $sql) or exit("Sql Error16".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	$sql="select * from $newfiltertable";
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error8".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_num_check=mysqli_num_rows($sql_result);
	//docketno-colorcode cutno-cut_status
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$display_prefix1 = get_sewing_job_prefix("prefix","$brandix_bts.tbl_sewing_job_prefix","$bai_pro3.packing_summary_input",$schedule,$color,$sql_row['input_job_no'],$link);
		// $input_job_no = 'J'.leading_zeros($sql_row['input_job_no'], 3);
		$code.=$sql_row['input_job_no_random']."-".$display_prefix1."-".$sql_row['act_cut_issue_status']."-".$sql_row["carton_qty"]."-".$sql_row["doc_no"]."-A".$sql_row["acutno"]."-".$module."-".$sql_row['type_of_sewing']."*";
		//echo "Doc=".$doc_no."<br>";
		$style=$sql_row['order_style_no'];
	}



// echo "Style :".$style."</br>";
// echo "schedule :".$schedule."</br>";
// echo "code :".$code."</br>";
// echo "module_ref_no :".$module_ref_no."</br>";

$code_db=array();
$code_db=explode("*",$code);
// var_dump($code_db);
// echo "Code Size:".sizeof($code_db)."</br>";
// exit;
?>		
<br/>
<div class="col-md-12">
<div class="panel panel-primary">
<div class="panel-heading">
<?php echo "Style:$style | Schedule: $schedule | color: $color"; ?>
</div>
<div class="panel-body">
<h4><span class="label label-info">Note: Yellow Color indicates Excess/Sample Job</span></h4>
<!-- </form> -->
<br>
<div id="dhtmlgoodies_dragDropContainer">
	<!-- <div id="topBar">
		<img src='images/heading3.gif'>
	</div> -->
	<div id="dhtmlgoodies_listOfItems">
		<div style="position: fixed;width: 150px;height:300px;overflow:  scroll;">
			<p>Jobs</p>		
		<ul id="allItems">
		
		<?php
			//exmaple : <li id="node101101">Student A</li>
			for($i=0;$i<sizeof($code_db)-1;$i++)
			{
				$code_db_new=array();
				$code_db_new=explode("-",$code_db[$i]);
				// var_dump($code_db_new);
				if($code_db_new[2]=="DONE")
				{
					$check= "#0c10e1";
					$font_color = 'white';
				}
				else
				{
					$check="#0c10e1"; // red
					$font_color = 'white';
				}

				if ($code_db_new[7] == 2)
				{
					$check = 'yellow'; // yellow for excess/sample cut
					$font_color = 'black';
				}

				echo "<li id=\"".$code_db_new[0]."|".$code_db_new[4]."\" style=\"background-color:$check; border-color:#b8daff; color:#f6f6f6;\">
							<strong><font color='$font_color'>".$code_db_new[1]."-".$code_db_new[5]."-".$code_db_new[3]."</font></strong>
						</li>";
			}
		?>
			
		</ul>
		</div>

		
<form action="http://localhost//index.php?r=L3NmY3NfYXBwL2FwcC9wbGFubmluZy9jb250cm9sbGVycy9pbnB1dF9qb2JfbGV2ZWxfcGxhbm5pbmcvZHJhZ19kcm9w        X3Byb2Nlc3NfaW5wdXQucGhw" method="post" name="myForm" onclick="saveDragDropNodes()" style="position: fixed;margin-top: 320px;margin-left: 35px;">
<input type="hidden" name="listOfItems" value="">
<input class="btn btn-success btn-sm pull-right" type="button" name="saveButton" id="saveButton" onclick="do_disable()" value="Save">
</form>

	</div>	
	

	<div id="dhtmlgoodies_mainContainer" style="padding-left: 200px;">
		<!-- ONE <UL> for each "room" -->
		<?php
		
		/*Example: <div>
			<p>Team a</p>
			<ul id="box1">
				<li id="node16">Student P</li>
			</ul>
		</div> */
		
		//echo sizeof($mods);
		$temp_table_name="temp_pool_db.plan_doc_summ_input_".$username;

		$sql="DROP TABLE IF EXISTS $temp_table_name";
		// echo $sql."<br/>";
		mysqli_query($link, $sql) or exit("Sql Error17".mysqli_error($GLOBALS["___mysqli_ston"]));
		
			$sql="CREATE  TABLE $temp_table_name ENGINE = MYISAM SELECT act_cut_status,doc_no,order_style_no,order_del_no,order_col_des,carton_act_qty as total,input_job_no as acutno,group_concat(distinct char(color_code)) as color_code,input_job_no,input_job_no_random_ref,input_module from $bai_pro3.plan_dash_doc_summ_input where (input_trims_status!=4 or input_trims_status IS NULL or input_panel_status!=2 or input_panel_status IS NULL) GROUP BY input_job_no_random_ref order by input_priority";
			mysqli_query($link, $sql) or exit("$sql Sql Error16".mysqli_error($GLOBALS["___mysqli_ston"]));
		
			
		$sections_ref=array();
		$sqlx1="select * from $bai_pro3.sections_db where sec_id>0";
		// echo "<br> SQLx1 :".$sqlx1."</br>";
		$sql_resultx1=mysqli_query($link, $sqlx1) or exit("Sql Error3".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_rowx1=mysqli_fetch_array($sql_resultx1))
		{
			$section_mods1=$sql_rowx1['sec_mods'];
			$mods1=explode(",",$section_mods1);
			for($x1=0;$x1<sizeof($mods1);$x1++)
			{
				//if($mods1[$x1]==$module_ref_no)
				{
					$sections_ref[]=$sql_rowx1['sec_id'];
				}
			}
		}		
			
		$sqlx="select * from $bai_pro3.sections_db where sec_id in (".implode(",",$sections_ref).")";
		// echo "<br> SQLx :".$sqlx."</br>";
		$sql_resultx=mysqli_query($link, $sqlx) or exit("Sql Error31".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_rowx=mysqli_fetch_array($sql_resultx))
		{
			$section=$sql_rowx['sec_id'];
			$section_head=$sql_rowx['sec_head'];
			$section_mods=$sql_rowx['sec_mods'];
			
			// echo "<div style=\"width:140px;height:500px;\" align=\"center\" class=\"table table-responsive\"><h4>SEC - $section</h4>";
			echo "<div style=\"width:170px;\" align=\"center\"><h4>SEC - $section</h4>";
		
			$mods=array();
			$mods=explode(",",$section_mods);
			//$mods[]=$module_ref_no;
			if(!(in_array($authorized,$has_perm)))
			{
				//New Implementation to Restrict Power User level Planning 20111211
				$mods=array();
				$sqlxy="select group_concat(module_id) as module_id from $bai_pro3.plan_modules where section_id=$section and power_user=\"$username\"";
				//echo $sqlxy;
				$sql_resultxy=mysqli_query($link, $sqlxy) or exit("Sql Error4".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_rowxy=mysqli_fetch_array($sql_resultxy))
				{
					$mods=explode(",",$sql_rowxy['module_id']);	
				}
				
				if($mods[0]==NULL)
				{
					$mods=NULL;
				}
				//New Implementation to Restrict Power User level Planning 20111211
			}
			
						
			for($x=0;$x<sizeof($mods);$x++)
			{
		
				echo '
					<p>'.$mods[$x].'</p>
					<ul id="'.$mods[$x].'" style="width:150px">';
						//<li id="node16">Student P</li>
						
						$module=$mods[$x];
						
						//$sql1="SELECT act_cut_status,doc_no,order_style_no,order_del_no,order_col_des,carton_act_qty as total,input_job_no as acutno,group_concat(distinct char(color_code)) as color_code,input_job_no,input_job_no_random_ref from plan_dash_doc_summ_input where input_module='$module' AND (input_trims_status!=4 or input_trims_status IS NULL or input_panel_status!=2 or input_panel_status IS NULL) GROUP BY input_job_no_random_ref order by input_priority";
						
						
						$sql1="SELECT * from $temp_table_name where input_module='$module'";
						//echo "</br>SQl1 : ".$sql1."</br>"
						/*$sql1="SELECT act_cut_status,act_cut_issue_status,doc_no,order_style_no,order_del_no,order_col_des,carton_act_qty as total,input_job_no as acutno,group_concat(distinct char(color_code)) as color_code,input_job_no,input_job_no_random_ref from plan_dash_doc_summ_input where input_module=$module and act_cut_issue_status<>\"DONE\" GROUP BY input_job_no_random_ref order by input_priority";*/
						//echo $sql1;
						//echo "<input type=\"text\" value=\"".$module."\">";
						$sql_result1=mysqli_query($link, $sql1) or exit("$sql1 Sql Error5".mysqli_error($GLOBALS["___mysqli_ston"]));
						$sql_num_check=mysqli_num_rows($sql_result1);
						while($sql_row1=mysqli_fetch_array($sql_result1))
						{
							$type_of_sewing=$sql_row1['type_of_sewing'];
							$doc_no_ref=$sql_row1['doc_no'];
							$doc_no=$sql_row1["input_job_no_random_ref"];						
							$style1=$sql_row1['order_style_no'];
							$schedule1=$sql_row1['order_del_no'];
							$color1=$sql_row1['order_col_des'];
							$total_qty1=$sql_row1['total'];
							$cut_no1=$sql_row1['acutno'];
							$color_code1=$sql_row1['color_code'];	

							$sql_style_id="SELECT DISTINCT style_id as sid FROM $bai_pro3.BAI_ORDERS_DB WHERE order_STYLE_NO=\"$style1\" and order_del_no=\"$schedule1\" LIMIT 1";
							$sql_result_id=mysqli_query($link, $sql_style_id) or exit("Sql Error5".mysqli_error($GLOBALS["___mysqli_ston"]));
							while($sql_row_id=mysqli_fetch_array($sql_result_id))
							{
								$style_id_new=$sql_row_id["sid"];
							}
								
							// add by Chathuranga	
							
							
							$display_prefix1 = get_sewing_job_prefix("prefix","$brandix_bts.tbl_sewing_job_prefix","$bai_pro3.packing_summary_input",$schedule1,$color1,$cut_no1,$link);
							$bg_color1 = get_sewing_job_prefix("bg_color","$brandix_bts.tbl_sewing_job_prefix","$bai_pro3.packing_summary_input",$schedule1,$color1,$cut_no1,$link);

							$title=str_pad("Style:".$style1,80)."\n".str_pad("Schedule:".$schedule1,80)."\n".str_pad("Job No:".$display_prefix1,80)."\n".str_pad("Qty:".$total_qty1,90);
							if($style1!=NULL)
							{
								if($style==$style1  and $schedule==$schedule1)
								{
									echo '<li id="'.$doc_no.'"  style="background-color:'.$bg_color1.';" title="'.$title.'"><strong><font color="red">'.$display_prefix1."(".$style_id_new.')</font></strong></li>';
								}
								else
								{
									echo '<li id="'.$doc_no.'"  style="background-color:'.$bg_color1.';" title="'.$title.'"><strong><font color="red">'.$display_prefix1."(".$style_id_new.')</font></strong></li>';
								}
							}	
							
						}
						if($code_db_new[6]==$module)
						{
							for($i=0;$i<sizeof($code_db)-1;$i++)
							{
								$code_db_new=array();
								$code_db_new=explode("-",$code_db[$i]);
								
								if($code_db_new[2]=="DONE")
								{
									$check="#cce5ff";
								}
								else
								{
									$check="#cce5ff"; // red
								}
								
								//echo "<li id=\"".$code_db_new[0]."|".$code_db_new[4]."\" style=\"background-color:$check;  color:white;\"><strong>".$code_db_new[1]."-".$code_db_new[5]."-".$code_db_new[3]."</strong></li>";
							}
						}
						
						//echo $sql1."<br>";
						
					echo '</ul>';
				
				
			}
			echo "</div>";
		}
		/*Ravi commited */
		// FOR COMPLETED CUTS
		// echo "<div id=\"new\" style=\"float:left;	margin-right:10px;	margin-bottom:10px;	margin-top:0px;	border:1px solid #999;width: 120px;	width/* */:/**/120px;	
		// width: /**/120px;\" align=\"center\">
		// <p style=\"margin:0px; padding:0px;		font-weight:bold;	background-color:#3170A8;	color:#FFF;	margin-bottom:5px;\">Completed</p>
		// <table class='table table-bordered'>";
			
		// /**/
		// $sql1="SELECT input_job_no as acutno from $bai_pro3.plan_doc_summ_input where order_del_no='$schedule' and input_job_input_status(input_job_no_random)=\"DONE\" order by input_job_no * 1";
		
		// $sql_result1=mysqli_query($link, $sql1) or exit("Sql Error7".mysqli_error($GLOBALS["___mysqli_ston"]));
		// while($sql_row1=mysqli_fetch_array($sql_result1))
		// {
			// echo '<tr id=\"new1\" style="background-color:green;  color:white;"><strong>J'.leading_zeros($sql_row1['acutno'],3).'</strong></tr><br>';
		// } 
		// echo '</table>';
		// echo "</div>";
		/*Ravi commited end*/
		$sql="DROP TABLE IF EXISTS $temp_table_name";
		//echo $sql."<br/>";
		mysqli_query($link, $sql) or exit("Sql Error17".mysqli_error($GLOBALS["___mysqli_ston"]));

		?>
	</div>

	</div>
<!-- <form action="<?= getFullURLLevel($_GET['r'],'drag_drop_process_input.php',0,'N'); ?>" method="post" name="myForm" onclick="saveDragDropNodes()">
	<input type="hidden" name="listOfItems" value=""> -->
	<input class='btn btn-success btn-sm pull-right' type="button" class="saveButton" name="saveButton" id='saveButton' onclick='do_disable()' value="Save">
</form>
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


