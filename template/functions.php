<?php
//include('dbconf.php');
//GLOBAL $happ;

  function hasChild($parent_id)
  {
	GLOBAL $menu_table_name;
	GLOBAL $link_ui;
    $sql = "SELECT COUNT(*) as count FROM $menu_table_name WHERE parent_id = '" . $parent_id . "' and link_status=1 order by left(link_description,1)";
    $qry = mysqli_query($link_ui, $sql) or exit($sql."<br/>Error 1".mysqli_error($GLOBALS["___mysqli_ston"]));
	//$qry = mysqli_query($GLOBALS["___mysqli_ston"], $sql);
    $rs = mysqli_fetch_array($qry);
    return $rs['count'];
  }
  
  function CategoryTree($list,$parent,$append,$happ)
  {
   	GLOBAL $menu_table_name;
	GLOBAL $link_ui;
	//$username_list=explode('\\',$_SERVER['REMOTE_USER']);
	//$username=strtolower($username_list[1]);
	//$auth_members=array();
	//$auth_members=explode(",",$parent['auth_members']);
	$special_users=array("kirang","kirang","kirang","kirang","kirang");
	//$special_users1=array("kiran");
		
   	if($parent['link_type']==1)
	{
		//if(in_array($username,$auth_members) or in_array("all",$auth_members))
		//{
			
			
				$linkq2q= explode('?',$parent['link_location']);
				$full_path_url = $linkq2q[0];
				$get_vars_data = (isset($linkq2q[1]) && $linkq2q[1]!='') ? '&'.$linkq2q[1] : '';
				//var_dump($happ);die();
			if(in_array($parent['menu_pid'],$happ)){
				if(base64_encode($full_path_url) == $_GET['r'] || (isset($_SESSION['link']) && $_SESSION['link'] == base64_encode($full_path_url))){
				$list = '<li class=\'current-page\'><a href="?r='.base64_encode($full_path_url).$get_vars_data.'"  alt="'.$parent['link_description'].'">'.$parent['link_description'].'</a>
				<div id="cmd'.$parent['link_cmd'].'" style="display:none;">'.$parent['link_location'].'</div></li>';
					$_SESSION['link'] = base64_encode($full_path_url);
					
				}else{
					$list = '<li><a href="?r='.base64_encode($full_path_url).$get_vars_data.'"  alt="'.$parent['link_description'].'">'.$parent['link_description'].'</a>
				<div id="cmd'.$parent['link_cmd'].'" style="display:none;">'.$parent['link_location'].'</div>
				</li>';
				}
			}else{
				$list = " ";
			}
				
				// $list = '<li><a  href="'.$parent['link_location'].'" target="main" alt="'.$parent['link_description'].'">'.$parent['link_description'].'</a>
				// <div id="cmd'.$parent['link_cmd'].'" style="display:none;">'.$parent['link_location'].'</div>
				// </li>';
			
			
		/*	if(!in_array($username,$special_users))
			{
				$list = '<li><a onmouseover="window.status='."'".$parent['help_tip']."'".'; return true;" href="javascript:void(0);" onclick="document.getElementById('."'".'main'."'".').src='."'" .$parent['list_desc']."'".';" onmouseover="window.status='."'".$parent['help_tip']."'".'; return true;" onmouseout="window.status='."'".'BAINet'."'".'; return true;">'.$parent['list_title'].'</a>
                <div id="cmd'.$parent['command'].'" style="display:none;">'.$parent['list_desc'].'</div>                
                </li>';
			}
			
		}
		else
		{
			if(in_array($username,$special_users1))
			{
				$list = '<li>'.$parent['list_title'].'|'.$parent['auth_members'].'</li>';
			}
			else
			{
				$list = '<li>'.$parent['list_title'].'</li>';
			}
		}*/
	}
	else
	{
	/*	if(in_array($username,$special_users1))
		{
			$list = '<li><strong>'.$parent['list_title'].'|'.$parent['auth_members'].'</strong>
            <div id="cmd'.$parent['command'].'" style="display:none;">'.$parent['list_desc'].'</div>
            ';	
		}
		else
		{*/
			$list = '<li><a>'.$parent['link_description'].' <span class="fa fa-chevron-down"></a>
            <div id="cmd'.$parent['link_cmd'].'" style="display:none;">'.$parent['link_location'].'</div>
            ';	
		//}
	}
        
    if (hasChild($parent['menu_pid'])) // check if the id has a child
    {
      $append++;
	 // $list .= "<ul class='child child".$append."'>";
	 $lip = 'a';
	  $list .= "<ul class='nav child_menu'>";
      $sql = "SELECT * FROM $menu_table_name WHERE parent_id = '".$parent['menu_pid']."'  and link_status=1 and link_visibility=1 order by link_tool_tip*1,left(link_description,1)";
      $qry = mysqli_query($link_ui, $sql);
      $child = mysqli_fetch_array($qry);
      do{
		$cpn = CategoryTree($list,$child,$append,$happ);
		$list.= $cpn;
		if($cpn!="")
			$lip.= $cpn;
	  }while($child = mysqli_fetch_array($qry));
	  //echo str_replace(' ','',$lip);
	  if(!strpos($lip,'<li')){
		  //echo "<pre>".$lip."</pre><br/>";
		$list.="<li><a class='label label-danger'><i class='fas fa-window-close'></i> No Access</a></li>";
	  }
      $list .= "</ul>";
    }
	if($parent['link_type']==1)
	{
		$list .='</li>';
	}
	
    return $list;
  }
  function CategoryList($x)
  {
    $list = "";
    
    GLOBAL $menu_table_name;
	GLOBAL $link_ui;
	// $database="central_administration_sfcs";
    // $user= 'baiall';
    // $password='baiall';
    // $host= '192.168.0.110';
    // $link = mysqli_connect($host,$user,$password,$database,"3323");
    $sql = "SELECT * FROM tbl_menu_list WHERE (parent_id = 0 OR parent_id IS NULL) and link_status=1 and fk_group_id=".$x." order by link_description";
    $qry = mysqli_query($link_ui, $sql) or exit($sql."<br/>Error 1".mysqli_error($GLOBALS["___mysqli_ston"]));
	//$qry = mysqli_query($GLOBALS["___mysqli_ston"], $sql);
    $parent = mysqli_fetch_array($qry);
	$mainlist = "<li id=\"tree\"><a>";
	$happ = hasmenupermission();
    do
	{
      $mainlist .= CategoryTree($list,$parent,$append = 0,$happ);
    }while($parent = mysqli_fetch_array($qry));
    $list .= "</a></li>";
    return $mainlist;
  }
?>