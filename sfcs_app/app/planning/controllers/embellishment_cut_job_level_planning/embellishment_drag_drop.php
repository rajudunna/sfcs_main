<?php

	include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
	include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions.php',4,'R'));
	$has_perm=haspermission($_GET['r']);
	$module_limit=14;

	// Added This Code From Refrence drag_drop_old.php
	include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',4,'R'));
	$view_access=user_acl("SFCS_0131",$username,1,$group_id_sfcs);
	$super_user=user_acl("SFCS_0131",$username,50,$group_id_sfcs);

	// Added This Code From Refrence drag_drop_old.php
	function title_des($link,$doc_no)
	{
		$ret_str="<table><tr><th>Size</th><th>Qty</th></tr>";
		//New Extra Shipment Order Quantities
		$sql1="select p_xs,p_s,p_m,p_l,p_xl,p_xxl,p_xxxl,p_s06,p_s08,p_s10,p_s12,p_s14,p_s16,p_s18,p_s20,p_s22,p_s24,p_s26,p_s28,p_s30,p_plies from plandoc_stat_log where doc_no=$doc_no";
		$sql_result1=mysqli_query($link,$sql1) or exit("Sql Error11".mysql_error());
		while($sql_row1=mysqli_fetch_array($sql_result1))
		{
			$ret_str.=($sql_row1['p_xs']>0?'<tr><td>XS</td><td>'.($sql_row1['p_xs']*$sql_row1['p_plies']).'</td></tr>':'');
			$ret_str.=($sql_row1['p_s']>0?'<tr><td>S</td><td>'.($sql_row1['p_s']*$sql_row1['p_plies']).'</td></tr>':'');
			$ret_str.=($sql_row1['p_m']>0?'<tr><td>M</td><td>'.($sql_row1['p_m']*$sql_row1['p_plies']).'</td></tr>':'');
			$ret_str.=($sql_row1['p_l']>0?'<tr><td>L</td><td>'.($sql_row1['p_l']*$sql_row1['p_plies']).'</td></tr>':'');
			$ret_str.=($sql_row1['p_xl']>0?'<tr><td>XL</td><td>'.($sql_row1['p_xl']*$sql_row1['p_plies']).'</td></tr>':'');
			$ret_str.=($sql_row1['p_xxl']>0?'<tr><td>XXL</td><td>'.($sql_row1['p_xxl']*$sql_row1['p_plies']).'</td></tr>':'');
			$ret_str.=($sql_row1['p_xxxl']>0?'<tr><td>XXXL</td><td>'.($sql_row1['p_xxxl']*$sql_row1['p_plies']).'</td></tr>':'');
			$ret_str.=($sql_row1['p_"s01"']>0?'<tr><td>"s01"</td><td>'.($sql_row1['p_"s01"']*$sql_row1['p_plies']).'</td></tr>':'');
			$ret_str.=($sql_row1['p_"s02"']>0?'<tr><td>"s02"</td><td>'.($sql_row1['p_"s02"']*$sql_row1['p_plies']).'</td></tr>':'');
			$ret_str.=($sql_row1['p_"s03"']>0?'<tr><td>"s03"</td><td>'.($sql_row1['p_"s03"']*$sql_row1['p_plies']).'</td></tr>':'');
			$ret_str.=($sql_row1['p_"s04"']>0?'<tr><td>"s04"</td><td>'.($sql_row1['p_"s04"']*$sql_row1['p_plies']).'</td></tr>':'');
			$ret_str.=($sql_row1['p_"s05"']>0?'<tr><td>"s05"</td><td>'.($sql_row1['p_"s05"']*$sql_row1['p_plies']).'</td></tr>':'');
			$ret_str.=($sql_row1['p_"s06"']>0?'<tr><td>"s06"</td><td>'.($sql_row1['p_"s06"']*$sql_row1['p_plies']).'</td></tr>':'');
			$ret_str.=($sql_row1['p_"s07"']>0?'<tr><td>"s07"</td><td>'.($sql_row1['p_"s07"']*$sql_row1['p_plies']).'</td></tr>':'');
			$ret_str.=($sql_row1['p_"s08"']>0?'<tr><td>"s08"</td><td>'.($sql_row1['p_"s08"']*$sql_row1['p_plies']).'</td></tr>':'');
			$ret_str.=($sql_row1['p_"s09"']>0?'<tr><td>"s09"</td><td>'.($sql_row1['p_"s09"']*$sql_row1['p_plies']).'</td></tr>':'');
			$ret_str.=($sql_row1['p_"s10"']>0?'<tr><td>"s10"</td><td>'.($sql_row1['p_"s10"']*$sql_row1['p_plies']).'</td></tr>':'');
			$ret_str.=($sql_row1['p_"s11"']>0?'<tr><td>"s11"</td><td>'.($sql_row1['p_"s11"']*$sql_row1['p_plies']).'</td></tr>':'');
			$ret_str.=($sql_row1['p_"s12"']>0?'<tr><td>"s12"</td><td>'.($sql_row1['p_"s12"']*$sql_row1['p_plies']).'</td></tr>':'');
			$ret_str.=($sql_row1['p_"s13"']>0?'<tr><td>"s13"</td><td>'.($sql_row1['p_"s13"']*$sql_row1['p_plies']).'</td></tr>':'');
			$ret_str.=($sql_row1['p_"s14"']>0?'<tr><td>"s14"</td><td>'.($sql_row1['p_"s14"']*$sql_row1['p_plies']).'</td></tr>':'');
			$ret_str.=($sql_row1['p_"s15"']>0?'<tr><td>"s15"</td><td>'.($sql_row1['p_"s15"']*$sql_row1['p_plies']).'</td></tr>':'');
			$ret_str.=($sql_row1['p_"s16"']>0?'<tr><td>"s16"</td><td>'.($sql_row1['p_"s16"']*$sql_row1['p_plies']).'</td></tr>':'');
			$ret_str.=($sql_row1['p_"s17"']>0?'<tr><td>"s17"</td><td>'.($sql_row1['p_"s17"']*$sql_row1['p_plies']).'</td></tr>':'');
			$ret_str.=($sql_row1['p_"s18"']>0?'<tr><td>"s18"</td><td>'.($sql_row1['p_"s18"']*$sql_row1['p_plies']).'</td></tr>':'');
			$ret_str.=($sql_row1['p_"s19"']>0?'<tr><td>"s19"</td><td>'.($sql_row1['p_"s19"']*$sql_row1['p_plies']).'</td></tr>':'');
			$ret_str.=($sql_row1['p_"s20"']>0?'<tr><td>"s20"</td><td>'.($sql_row1['p_"s20"']*$sql_row1['p_plies']).'</td></tr>':'');
			$ret_str.=($sql_row1['p_"s21"']>0?'<tr><td>"s21"</td><td>'.($sql_row1['p_"s21"']*$sql_row1['p_plies']).'</td></tr>':'');
			$ret_str.=($sql_row1['p_"s22"']>0?'<tr><td>"s22"</td><td>'.($sql_row1['p_"s22"']*$sql_row1['p_plies']).'</td></tr>':'');
			$ret_str.=($sql_row1['p_"s23"']>0?'<tr><td>"s23"</td><td>'.($sql_row1['p_"s23"']*$sql_row1['p_plies']).'</td></tr>':'');
			$ret_str.=($sql_row1['p_"s24"']>0?'<tr><td>"s24"</td><td>'.($sql_row1['p_"s24"']*$sql_row1['p_plies']).'</td></tr>':'');
			$ret_str.=($sql_row1['p_"s25"']>0?'<tr><td>"s25"</td><td>'.($sql_row1['p_"s25"']*$sql_row1['p_plies']).'</td></tr>':'');
			$ret_str.=($sql_row1['p_"s26"']>0?'<tr><td>"s26"</td><td>'.($sql_row1['p_"s26"']*$sql_row1['p_plies']).'</td></tr>':'');
			$ret_str.=($sql_row1['p_"s27"']>0?'<tr><td>"s27"</td><td>'.($sql_row1['p_"s27"']*$sql_row1['p_plies']).'</td></tr>':'');
			$ret_str.=($sql_row1['p_"s28"']>0?'<tr><td>"s28"</td><td>'.($sql_row1['p_"s28"']*$sql_row1['p_plies']).'</td></tr>':'');
			$ret_str.=($sql_row1['p_"s29"']>0?'<tr><td>"s29"</td><td>'.($sql_row1['p_"s29"']*$sql_row1['p_plies']).'</td></tr>':'');
			$ret_str.=($sql_row1['p_"s30"']>0?'<tr><td>"s30"</td><td>'.($sql_row1['p_"s30"']*$sql_row1['p_plies']).'</td></tr>':'');
			$ret_str.=($sql_row1['p_"s31"']>0?'<tr><td>"s31"</td><td>'.($sql_row1['p_"s31"']*$sql_row1['p_plies']).'</td></tr>':'');
			$ret_str.=($sql_row1['p_"s32"']>0?'<tr><td>"s32"</td><td>'.($sql_row1['p_"s32"']*$sql_row1['p_plies']).'</td></tr>':'');
			$ret_str.=($sql_row1['p_"s33"']>0?'<tr><td>"s33"</td><td>'.($sql_row1['p_"s33"']*$sql_row1['p_plies']).'</td></tr>':'');
			$ret_str.=($sql_row1['p_"s34"']>0?'<tr><td>"s34"</td><td>'.($sql_row1['p_"s34"']*$sql_row1['p_plies']).'</td></tr>':'');
			$ret_str.=($sql_row1['p_"s35"']>0?'<tr><td>"s35"</td><td>'.($sql_row1['p_"s35"']*$sql_row1['p_plies']).'</td></tr>':'');
			$ret_str.=($sql_row1['p_"s36"']>0?'<tr><td>"s36"</td><td>'.($sql_row1['p_"s36"']*$sql_row1['p_plies']).'</td></tr>':'');
			$ret_str.=($sql_row1['p_"s37"']>0?'<tr><td>"s37"</td><td>'.($sql_row1['p_"s37"']*$sql_row1['p_plies']).'</td></tr>':'');
			$ret_str.=($sql_row1['p_"s38"']>0?'<tr><td>"s38"</td><td>'.($sql_row1['p_"s38"']*$sql_row1['p_plies']).'</td></tr>':'');
			$ret_str.=($sql_row1['p_"s39"']>0?'<tr><td>"s39"</td><td>'.($sql_row1['p_"s39"']*$sql_row1['p_plies']).'</td></tr>':'');
			$ret_str.=($sql_row1['p_"s40"']>0?'<tr><td>"s40"</td><td>'.($sql_row1['p_"s40"']*$sql_row1['p_plies']).'</td></tr>':'');
			$ret_str.=($sql_row1['p_"s41"']>0?'<tr><td>"s41"</td><td>'.($sql_row1['p_"s41"']*$sql_row1['p_plies']).'</td></tr>':'');
			$ret_str.=($sql_row1['p_"s42"']>0?'<tr><td>"s42"</td><td>'.($sql_row1['p_"s42"']*$sql_row1['p_plies']).'</td></tr>':'');
			$ret_str.=($sql_row1['p_"s43"']>0?'<tr><td>"s43"</td><td>'.($sql_row1['p_"s43"']*$sql_row1['p_plies']).'</td></tr>':'');
			$ret_str.=($sql_row1['p_"s44"']>0?'<tr><td>"s44"</td><td>'.($sql_row1['p_"s44"']*$sql_row1['p_plies']).'</td></tr>':'');
			$ret_str.=($sql_row1['p_"s45"']>0?'<tr><td>"s45"</td><td>'.($sql_row1['p_"s45"']*$sql_row1['p_plies']).'</td></tr>':'');
			$ret_str.=($sql_row1['p_"s46"']>0?'<tr><td>"s46"</td><td>'.($sql_row1['p_"s46"']*$sql_row1['p_plies']).'</td></tr>':'');
			$ret_str.=($sql_row1['p_"s47"']>0?'<tr><td>"s47"</td><td>'.($sql_row1['p_"s47"']*$sql_row1['p_plies']).'</td></tr>':'');
			$ret_str.=($sql_row1['p_"s48"']>0?'<tr><td>"s48"</td><td>'.($sql_row1['p_"s48"']*$sql_row1['p_plies']).'</td></tr>':'');
			$ret_str.=($sql_row1['p_"s49"']>0?'<tr><td>"s49"</td><td>'.($sql_row1['p_"s49"']*$sql_row1['p_plies']).'</td></tr>':'');
			$ret_str.=($sql_row1['p_"s50"']>0?'<tr><td>"s50"</td><td>'.($sql_row1['p_"s50"']*$sql_row1['p_plies']).'</td></tr>':'');


		}
		
		$ret_str.="</table>";
		
		return $ret_str;
	}

?>

<!-- <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd"> -->

<html>

	<head>

		<META HTTP-EQUIV="refresh" content="900">
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
			
			var boxSizeArray = [];
			for(var i=0; i<120; i++){
				boxSizeArray.push('<?= $module_limit; ?>');
			}
			
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
					console.log('not eligble to drag');
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
				var uls = dragDropTopContainer.getElementsByTagName('UL');
				for(var no=0;no<uls.length;no++){	// LOoping through all <ul>
					var lis = uls[no].getElementsByTagName('LI');
					for(var no2=0;no2<lis.length;no2++){
						if(saveString.length>0)saveString = saveString + ";";
						saveString = saveString + uls[no].id + '|' + lis[no2].id;
						//alert(saveString);
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

			// Added This Code From Refrence drag_drop_old.php 
			include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'functions.php',0,'R')); 
			include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'embellishment_drag_drop_data.php',0,'R'));

			$style=$style_ref;
			$schedule=$schedule_ref;
			$color=$color_ref;
			$code=$code_ref;
			$cat_ref=$cat_ref_ref;

			$code_db=array();
			$code_db=explode("*",$code);
		?>

		<br/>

		<div class="col-md-12">

			<div class="panel panel-primary">

				<div class="panel-heading">

					<?php 
						// $url2 = getFullURLLevel($_GET['r'],'jobs_movement_track.php',0,'N');
						echo "<b>Style:</b> $style | <b>Schedule:</b> $schedule | <b>Color:</b> $color"; 
						// echo "<a class='btn btn-warning pull-right' style='padding: 1px 16px' href='$url2' onclick=\"return popitup2('$url2')\" target='_blank'>Sewing Jobs Movement Track</a>";
					?>

				</div>

				<div class="panel-body">

					<!-- <div>
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
					</div> -->
				
					<br>

					<div id="dhtmlgoodies_dragDropContainer">

						<div id="dhtmlgoodies_listOfItems">

							<div style="position: fixed;width: 150px;height:300px;overflow:scroll;margin-top: 30px;text-align:center">
								<p>Jobs</p>		
								<ul id="allItems">

									<!-- Data1 -->

									<?php

										

										for($i=0;$i<sizeof($code_db)-1;$i++)
										{
											$code_db_new=array();
											$code_db_new=explode("-",$code_db[$i]);
											
											if($code_db_new[2]=="DONE")
											{
												$check="blue";
											}
											else
											{
												$check="blue"; // red
											}
											
											$title=title_des($link,$code_db_new[0]);
											// <li data-color="green" style="background-color:green; color:white;">
											echo "<li id=\"".$code_db_new[0]."\" style=\" background-color:$check; color:white;\"  data-color='blue' title=\"$title\" class=\"normalTip\"><strong>".$code_db_new[1]."</strong></li>";
										}
									?>
								
								</ul>
							</div>

							<form action="<?= getFullURLLevel($_GET['r'],'embellishment_drag_drop_process.php',0,'N'); ?>" method="post" name="myForm" onclick="saveDragDropNodes()" style="position: fixed;margin-left: 47px;">
								<input type="hidden" name="listOfItems" value="">
								<input type="hidden" name="sche" id="sche" value="<?php echo $schedule; ?>">
								<input class="btn btn-success btn-sm pull-right" type="button" name="saveButton" id="saveButton" onclick="do_disable()" value="Save">
							</form>

						

						</div>	

						<div id="dhtmlgoodies_mainContainer" style="padding-left: 200px;">
							
							<!-- Data2 -->

							<?php
								
								
								
								$remove_docs=array();
								// $sqlx="select doc_no from $bai_pro3.plan_dash_doc_summ where act_cut_issue_status=\"DONE\"";
								$sqlx="select doc_no from $bai_pro3.plan_dash_doc_summ_embl where act_cut_status=\"DONE\""; //KK223422

								//echo $sqlx;
								// mysqli_query($link,$sqlx) or exit("Sql Error".mysql_error());
								$sql_resultx=mysqli_query($link,$sqlx) or exit("Sql Error2".mysqli_error());
								while($sql_rowx=mysqli_fetch_array($sql_resultx))
								{
								$remove_docs[]=$sql_rowx['doc_no'];
								}
								
								if(sizeof($remove_docs)>0)
								{
								
								$sqlx="delete from $bai_pro3.embellishment_plan_dashboard where doc_no in (".implode(",",$remove_docs).")";
								// mysqli_query($link,$sqlx) or exit("Sql Error4".mysqli_error());
								}
								
								//remove docs
								
								$sqlx="select * from $bai_pro3.sections_db where sec_id>0";
								// mysqli_query($link,$sqlx) or exit("Sql Error".mysql_error());
								$sql_resultx=mysqli_query($link,$sqlx) or exit("Sql Error5".mysql_error());
								while($sql_rowx=mysqli_fetch_array($sql_resultx))
								{
									$section=$sql_rowx['sec_id'];
									$section_head=$sql_rowx['sec_head'];
									$section_mods=$sql_rowx['sec_mods'];
								
									echo "<div style=\"width:170px;\" align=\"center\"><h4>E00$section</h4>";
								
										$mods=array();
										$mods=explode(",",$section_mods);
										
										if(!(in_array(strtolower($username),$super_user)) or !(in_array(strtolower($username),$super_user)))
										{
											//New Implementation to Restrict Power User level Planning 20111211
											$mods=array();
											$sqlxy="select group_concat(emb_table_id) as emb_table_id from $bai_pro3.tbl_emb_table where section_id=$section and power_user=\"$username\"";
											//echo $sqlxy;
											$sql_resultxy=mysqli_query($link,$sqlxy) or exit("Sql Error6".mysql_error());
											while($sql_rowxy=mysqli_fetch_array($sql_resultxy))
											{
												$mods=explode(",",$sql_rowxy['emb_table_id']);	
											}
											
											if($mods[0]==NULL)
											{
												$mods=NULL;
											}
											//New Implementation to Restrict Power User level Planning 20111211
										}
										
										// echo "<script>lis_limit('".sizeof($mods)."','".json_encode($mods)."')</script>";
										for($x=0;$x<sizeof($mods);$x++)
										{
									
											echo '<p>'.$mods[$x].'</p><ul id="'.$mods[$x].'" style="width:150px">';
													//<li id="node16">Student P</li>
													
													$module=$mods[$x];
													$sql1="SELECT act_cut_status,act_cut_issue_status,rm_date,cut_inp_temp,doc_no,order_style_no,order_del_no,order_col_des,total,acutno,color_code from $bai_pro3.plan_dash_doc_summ_embl where module=$module order by priority"; //KK223422

													// echo $sql1;
													// die();
													// mysql_query($sql1,$link) or exit("Sql Error".mysql_error());
													$sql_result1=mysqli_query($link,$sql1) or exit("Sql Error7".mysql_error());
													$sql_num_check=mysqli_num_rows($sql_result1);
													while($sql_row1=mysqli_fetch_array($sql_result1))
													{
														$cut_new=$sql_row1['act_cut_status'];
														$cut_input_new=$sql_row1['act_cut_issue_status'];
														$rm_new=strtolower(chop($sql_row1['rm_date']));
														$rm_update_new=strtolower(chop($sql_row1['rm_date']));
														$input_temp=strtolower(chop($sql_row1['cut_inp_temp']));
														$doc_no=$sql_row1['doc_no'];
														
														$style1=$sql_row1['order_style_no'];
														$schedule1=$sql_row1['order_del_no'];
														$color1=$sql_row1['order_col_des'];
														$total_qty1=$sql_row1['total'];
														$cut_no1=$sql_row1['acutno'];
														$color_code1=$sql_row1['color_code'];
														
														if($cut_new=="DONE"){ $cut_new="T";	} else { $cut_new="F"; }
														if($rm_update_new==""){ $rm_update_new="F"; } else { $rm_update_new="T"; }
														if($rm_new=="0000-00-00 00:00:00" or $rm_new=="") { $rm_new="F"; } else { $rm_new="T";	}
														if($input_temp==1) { $input_temp="T";	} else { $input_temp="F"; }
														if($cut_input_new=="DONE") { $cut_input_new="T";	} else { $cut_input_new="F"; }
														
														$check_string=$cut_new.$rm_update_new.$rm_new.$input_temp.$cut_input_new;
														
														switch ($check_string)
														{
															case "TTTTF":
															{
																$id="yellow";
																break;
															}
															case "TTTFF":
															{
																$id="green";
																break;
															}
															case "TTFFF":
															{
																//$id="orange";
																$id="red";
																break;
															}
															case "TFFFF":
															{
																$id="blue";
																break;
															}
															case "FTTFF":
															{
																$id="pink";
																break;
															}
															case "FTFFF":
															{
																$id="red";
																break;
															}
															case "FFFFF":
															{
																$id="red";
																break;
															}
															default:
															{
																$id="white";
																break;
															}
														}
														
														$sql="select color_code,acutno,order_style_no,order_del_no,order_col_des from $bai_pro3.plan_doc_summ where doc_no=$doc_no";
														// echo $sql."<br>";
														// mysql_query($sql,$link) or exit("Sql Error".mysql_error());
														$sql_result=mysqli_query($link,$sql) or exit("Sql Error8".mysql_error());
														$sql_num_check=mysqli_num_rows($sql_result);
														
														//docketno-colorcode cutno-cut_status
														while($sql_row=mysqli_fetch_array($sql_result))
														{
															$color_code=$sql_row['color_code'];
															$act_cut_no=$sql_row['acutno'];
															
															$style_new=$sql_row['order_style_no'];
															$schedule_new=$sql_row['order_del_no'];
															$color_new=$sql_row['order_col_des'];
														}
														
														$id="#33AADD"; //default existing color
																										
														if($style==$style_new and $color==$color_new and $schedule==$schedule_new)
														{
															$id="red";
														}
														
																				
														//If its current selected schedule and Cut also completed.
														if($id=="red" and $cut_new=="T")
														{
															$id="#FF2288";
														}
														else
														{
															//If cut only completed.
															if($cut_new=="T")
															{
																$id="black";
															}
														}
														
														
														$title=str_pad("Style:".$style1,80).str_pad("Schedule:".$schedule1,80).str_pad("Color:".$color1,80).str_pad("Job No:".chr($color_code1).leading_zeros($acutno1,3),80).str_pad("Qty:".$total_qty1,90);
														
														echo '<li id="'.$doc_no.'" data-color="'.$id.'" style="background-color:'.$id.';  color:white;" title="'.$title.'"><strong>'.chr($color_code).leading_zeros($act_cut_no,3).'</strong></li>';
														//echo '<li id="'.$doc_no.'" style="background-color:'.$id.';  color:white;"><strong>'.$check_string.'</strong></li>';	
													
													}
													
												echo '</ul>';
											
										}
									echo "</div>";
								}
								
								// FOR COMPLETED CUTS
								// echo "<div id=\"new\" style=\"float:left;	margin-right:10px;	margin-bottom:10px;	margin-top:0px;	border:1px solid #999;width: 120px;	width/* */:/**/120px;	
								// 	width: /**/120px;\" align=\"center\">
								// 	<p style=\"margin:0px; padding:0px;	padding-left:12px;	font-weight:bold;	background-color:#317082;	color:#FFF;	margin-bottom:5px;\">Complted</p>
								// 	<table>";

								// 		$sql="select color_code from plan_doc_summ where cat_ref=$cat_ref";
										
								// 		$sql_result=mysqli_query($link,$sql) or exit("Sql Error1".mysql_error());
								// 		while($sql_row=mysqli_fetch_array($sql_result))
								// 		{
								// 			$color_code=$sql_row['color_code'];}
									
								// 			$sql1="SELECT acutno from $bai_pro3.plandoc_stat_log where order_tid like \"%$style$schedule$color%\" and cat_ref=$cat_ref and act_cut_status=\"DONE\" and a_plies=p_plies order by doc_no"; //KK223422
								// 			//echo $sql1;
								// 			// mysql_query($sql1,$link) or exit("Sql Error".mysql_error());
								// 			$sql_result1=mysqli_query($link,$sql1) or exit("Sql Error2".mysql_error());
								// 			while($sql_row1=mysqli_fetch_array($sql_result1))
								// 			{
								// 				echo '<tr id=\"new1\"><li data-color="green" style="background-color:green; color:white;"><strong>'.chr($color_code).leading_zeros($sql_row1['acutno'],3).'</strong></li></tr>';
								// 				// echo '<li id="'.$doc_no.'" data-color="'.$id.'" style="background-color:'.$id.';  color:white;" title="'.$title.'"><strong>'.chr($color_code).leading_zeros($act_cut_no,3).'</strong></li>';
								// 			}
								// 	echo '</table>';
								// echo "</div>";
								
							?>
						
						</div>

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

<script src="../../common/js/jquery-1.3.2.js"></script>
