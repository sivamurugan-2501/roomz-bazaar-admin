$(document).ready(function(){

	var section = $('#section').val();
	if(section == 1){
		$('#step-1').hide();
		$('#step-2').show();
	}

	if(section == 2){
		$('#step-1').hide();
		$('#step-2').hide();
		$('#step-3').show();
	}

	if(section == 3){
		$('#step-1').hide();
		$('#step-2').hide();
		$('#step-3').hide();
		$('#step-4').show();
	}

	$('#submit1').click(function(){
		validateTab1();
	});
	$('#submit2').click(function(){

		$("#form_2").validate({
			rules:{
				per_square_feet:'required',
				total_square_feet:'required',
				carpet_area:'required',
				usable_area:'required',
				total_rate:'required',
				
				negotiable:
				{
					required:true
				},
			},
			
		});
	});

	$('#submit3').click(function(){

		$("#form_3").validate({
			rules:{
				advance_deposit:'required',
				rent_per_month:'required',
				maintenance:'required'
			},
			
		});
	});

	$('#submit4').click(function(){

		$("#form_4").validate({
			rules:{
				parking:'required',
				gym:'required',
				furnishes:'required',
				garden:'required',
				other:'required'
			}
			
		});
	});
	$('.buttonPrevious').click(function(){
		var x = document.referrer;
		document.location.href= x;
	});


	

});
function validateTab1(){
	$("#addform_1").validate({
		rules:{
			name: 'required',
			property_type:
			{
				required:true
			},
			show_as:
			{
				required:true
			},
			state:'required',
			city: 'required',
			landmark:'required',
			age:'required',
			total_floors:'required',
			floor_no:'required',
		},
		
	});
}