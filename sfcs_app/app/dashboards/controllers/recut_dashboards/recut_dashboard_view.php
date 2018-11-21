<?php
    include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config_ajax.php');
?>
<div class='row'>
    <div class='panel panel-primary'>
        <div class='panel-heading'>
            <b>RECUT DASHBOARD - View</b>
        </div>
        <div class='panel-body'>
           <table class = 'col-sm-12 table-bordered table-striped table-condensed'><thead><th>S.No</th><th>Style</th><th>Schedule</th><th>Color</th><th>Rejected quantity</th><th>Recut Allowed Quantity</th><th>Replaced Quantity</th><th>Eligibility to allow recut</th><th>View</th><th>Recut</th><th>Replace</th>
            </thead>
            <?php  
            $s_no = 1;
            $blocks_query  = "SELECT id,style,schedule,color,rejected_qty,recut_qty,remaining_qty,replaced_qty FROM $bai_pro3.rejections_log WHERE remaining_qty <> 0 and rejected_qty > 0";
            // echo $blocks_query;
            $blocks_result = mysqli_query($link,$blocks_query) or exit('Rejections Log Data Retreival Error');        
            while($row = mysqli_fetch_array($blocks_result))
            {  

                echo "<tr><td>$s_no</td>";
                $id = $row['id'];
                echo "<td>".$row['style']."</td>";
                echo "<td>".$row['schedule']."</td>";
                echo "<td>".$row['color']."</td>";
                echo "<td>".$row['rejected_qty']."</td>";
                echo "<td>".$row['recut_qty']."</td>";
                echo "<td>".$row['replaced_qty']."</td>";
                echo "<td>".$row['remaining_qty']."</td>";
                echo "<td><button type='button'class='btn btn-primary' onclick='viewrecutdetails(".$id.")'>View</button></td>";
                echo "<td><button type='button'class='btn btn-danger'>Recut</button></td>"; 
                echo "<td><button type='button'class='btn btn-success'>Replace</button></td>"; 
                echo "</tr>";
                $s_no++;
            }
            ?>
             </table>
        </div>
    </div>
</div>
<style>
    .container{
        border : 1px solid #e5e5e5;
        border-radius : 3px;
        min-height : 500px;
    }
    .block{
        color  : #000;
        background : #fff;
        padding : 22px;
        font-size : 16px; 
    }
    .inner-block{
        height : 120px;
        border : 1px solid #3c3c3c;
        border-radius : 5px;
        padding : 15px;
    }
    .label{
        color : #2D2D2D;
        font-size : 15px;
    }
    d{
        font-size : 15px;
    }
    .blue{
        background : #0D8F79;
    }

    @-webkit-keyframes blinker {
        from { opacity: 1.0; }
        to { opacity: 0.0; }
    }
    .blink{
        text-decoration: blink;
        -webkit-animation-name: blinker;
        -webkit-animation-duration: 0.5s;
        -webkit-animation-iteration-count:infinite;
        -webkit-animation-timing-function:ease-in-out;
        -webkit-animation-direction: alternate;
    }
    .modal{
        width : auto;
    }
    .modal-body{
	    max-height: calc(100vh - 200px);
	    overflow-y: auto;
	}
	.modal{
	 	opacity : 0.1;
	}
	.modal-header{
		background : #0D8DE2;
		color : #fff;
	}
    .modal-lg{
        width : 1200px;
    }
    .modal-content{
        height : 650px;
    }
    .modal-body{
        height : 600px;
    }
    .block a{
        color : #fff;
        padding : 15px;
        height : 100px;
        font-weight : bold;
    }
    a:hover{
        cursor : pointer;
        text-decoration : none;
    }
    v{
        color : #fff;
        text-align : left; 
        display : block;
        font-size : 12px;
    }
    c{
        color : #FFFF55;
        text-align : left;   
    }

    //Tool tip break
    .tooltip{
        width : 150px;
    }
    .tooltip-inner {
        max-width: 300px;
        white-space: nowrap;
        margin:0;
        padding:5px;
    }
</style>


<script>
function viewrecutdetails(id)
{
    var function_text = "<?php echo getFullURL($_GET['r'],'functions_recut.php','R'); ?>";
    $.ajax({

			type: "POST",
			url: function_text+"?recut_id="+id,
			dataType: "json",
			success: function (response) 
			{
                alert(response);
            }

    });
}
</script>