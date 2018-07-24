        </div>    
    </div>    
    <script src="assets/vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="assets/vendors/select2/dist/js/select2.min.js"></script>
    <script src="assets/js/custom.min.js"></script>
    <script>
			$(document).ready( function () {
			var count = 0;
			var wid = 0;
			$('input,textarea').filter('[required]:visible').each(function(){
				count++;
				wid = $(this).css('width').replace('px','');
				console.log(wid);
				//wid = Number(wid) - Number(20);
				//$(this).css('width',wid);	
				$(this).after('<span id='+count+' style="position:absolute;color:red;display:inline-block;font-size:12px">&nbsp;*</span>');
				console.log( $('#'+count).css('width') );
				$('#'+count).addClass('form-inline');
			});

			// $('#bootstrap-ids-sfcs').DataTable();
			// $('#tablecol').DataTable();
			// $('#table1').DataTable();
			// $('#tableone').DataTable();
		} );
</script>
<script>
	var swal12 = "swal";
	$('.float').keypress(function(e){
		if(e.keyCode == 13)
			return;

		var p = String.fromCharCode(e.which);
		var c = /^[0-9. ]+$/;
		var v = $(this).val().toString();

		if(p =='.'){
			if($(this).val().indexOf('.') > -1 ){
				e.preventDefault();
			}
		}
		if(v.length == 0){
			if(p =='.')
				e.preventDefault();	
		}	

		if( !(p.match(c)) && p!=null ){
			console.log('error');
			e.preventDefault();
			if($(this).hasClass(swal12)){
				sweetAlert('','please enter valid input','warning');
			}
			//$(this).val('');
			//v = v.value.replace(/[^0-9\.]/g,'');
			//qty.value = qty.value.substring(0,qty.value.length-1);
			return false;
		}
	});
	$('.float').on('change',function(e){
		
		var p = String.fromCharCode(e.which);
		var c = /^[0-9. ]+$/;
		var v = $(this).val();

		if(p =='.'){
			if($(this).val().indexOf('.') > -1 ){
				e.preventDefault();
			}
		}
		if(v == null){
			if(p =='.')
				e.preventDefault();	
		}	
		if( !(v.match(c)) && v!=null ){
			console.log('error');
			if($(this).hasClass(swal12)){
				sweetAlert('','please enter valid input','warning');
			}
			$(this).val('');
			return false;
		}
	});

	$('.integer').keypress(function(e){
		if(e.keyCode == 13)
			return;
		var p = String.fromCharCode(e.which);
		var c = /^[0-9]+$/;
		var v = $(this).val();

		if( !(p.match(c)) && p!=null ){
			console.log('error');
			if($(this).hasClass(swal12)){
				sweetAlert('','please enter valid input','warning');
			}
			e.preventDefault();
			return false;
		}
	});
	$('.integer').on('change',function(e){
		
		var p = String.fromCharCode(e.which);
		var c = /^[0-9]+$/;
		var v = $(this).val();

		if( !(v.match(c)) && v!=null ){
			console.log('error');
			if($(this).hasClass(swal12)){
				sweetAlert('','please enter valid input','warning');
			}
			$(this).val('');
			return false;
		}
	});

	$('.character').keypress(function(e){
		if(e.keyCode == 13)
			return;
		var p = String.fromCharCode(e.which);
		var c = /^[a-zA-Z. ]+$/;
		var v = $(this).val();

		if( !(p.match(c)) && p!=null ){
			console.log('error');
			if($(this).hasClass(swal12)){
				sweetAlert('','please enter valid input','warning');
			}
			e.preventDefault();
			return false;
		}
	});
	$('.character').on('change',function(e){
		
		var p = String.fromCharCode(e.which);
		var c = /^[a-zA-Z. ]+$/;
		var v = $(this).val();

		if( !(v.match(c)) && v!=null ){
			console.log('error');
			if($(this).hasClass(swal12)){
				sweetAlert('','please enter valid input','warning');
			}
			$(this).val('');
			return false;
		}
	});

	$('.alpha').keypress(function(e){
		if(e.keyCode == 13)
			return;
		var p = String.fromCharCode(e.which);
		var c = /^[a-zA-Z0-9. ]+$/;
		var v = $(this).val();

		if( !(p.match(c)) && p!=null ){
			console.log('error');
			if($(this).hasClass(swal12)){
				sweetAlert('','please enter valid input','warning');
			}
			e.preventDefault();
			return false;
		}
	});

	$('.alpha').on('change',function(e){
		
		var p = String.fromCharCode(e.which);
		var c = /^[0-9a-zA-Z. ]+$/;
		var v = $(this).val();

		if( !(v.match(c)) && v!=null ){
			console.log('error');
			if($(this).hasClass(swal12)){
				sweetAlert('','please enter valid input','warning');
			}
			$(this).val('');
			return false;
		}
	});
	function  hide_table_for_no_data(){

		var count = $('.table_hide table tr').length;
		var count1 = $('.table_hide .table tr').length;
		
		$('table').each(function(){
			console.log($(this).find('tr').length);
			if($(this).find('tr').length <= 1){
				$('.alert').hide();
				$(this).hide();
				var alert = '<div class="alert alert-danger"><span>No Data Found.</span></div>';
				$(this).after(alert);
			}
		});

		// $('.table').each(function(){
		// 	console.log($(this).length);
		// 	if($(this).length <= 1){
		// 		$('.alert').hide();
		// 		$(this).hide();
		// 		var alert = '<div class="alert alert-danger"><span><strong>No Data Found.</strong></span></div>';
		// 		$(this).after(alert);
		// 	}
		// })
		// console.log('table rows count: '+count);
		// if(count <= 1 || count1 <=1){
		// 	$('.table_hide').html('');
		// 	$('.table').after(alert);
		// }
		
	}

	// hide_table_for_no_data();
	// $('.confirm-submit-form').each(function(){
	// 	console.log($(this).attr('id'));
	// 	$($(this).attr('id')).on('click', function(){
	// 		submit_form($(this));
	// 	})
	// })
	$('.confirm-submit').on('click',function(event, redirect=true){
		if(redirect != false){
			event.preventDefault();
			console.log(redirect);
			submit_form($(this));
		}
		// return;
	});
	function submit_form(submit_btn){
		sweetAlert({
			title: "Are you sure?",
			text: "Do you want to process the request!",
			icon: "warning",
			buttons: true,
			dangerMode: true,
		}).then(function(isConfirm){
			if (isConfirm) {
				console.log(submit_btn.attr('id'));
				console.log($('#'+submit_btn.attr('id')).attr('href'));
				if($('#'+submit_btn.attr('id')).attr('href')){
					window.location.href = $('#'+submit_btn.attr('id')).attr('href');
				}else{
					$('#'+submit_btn.attr('id')).trigger('click',false);
				}
			} else {
				sweetAlert("Request Cancelled");
				return;
			}
		});
		return;
	}
</script>
</body>
</html>

<style>
.form-control {
    display:initial !important;
}
</style>
