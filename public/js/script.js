//alert("loadeds");
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
		alert("clicked..");
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

	$('input.flat').iCheck({
		checkboxClass: 'icheckbox_flat-green',
		radioClass: 'iradio_flat-green'
	});

});
let r;
function validateTab1(formId){
	
		r= $("#addform_1").validate({
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
			debug: false
		});
		console.log(r);
	
	//return r;
}

$("input[name='transaction_type']").click(function(event){
	checked = $(this).is(":checked");
	if(checked == true){

		value = $(this).val();
		value = parseInt(value);
		alert("here... "+value);
		transaction_type_action(value);
	}
});

$("input[name='possession_type']").click(function(event){
	checked = $(this).is(":checked");
	if(checked == true){
		value = $(this).val();
		 value = parseInt(value);
	   possession_type_action(value);
	}
});

function transaction_type_action(value,reset){
  if(value == 1){
	$("#possession_year_div").addClass("hide");
	$("#age_div").addClass("hide");
	$("#possession_type_div").removeClass("hide");
	if(reset===undefined || reset==0)
	$("input[name='possession_type']").removeAttr("checked");
  }else if(value==2){
	$("#possession_year_div").addClass("hide");
	$("#possession_type_div").addClass("hide");
	$("#age_div").removeClass("hide");
	if(reset===undefined || reset==0)
	$("#age").val("");
  }
}

function possession_type_action(value,reset){
	  if(value==1){
		  $("#possession_year_div").removeClass("hide");
		  if(reset===undefined || reset==0)
		  document.getElementById("possession_year").options[0].selected = "selected";
	  }else{
		  $("#possession_year_div").addClass("hide");
	  }
}

function move_wizard(step){
	if(step!==undefined && step!==""){

	}
}

function fill_city(cityId){
  stateSelected = $("#state").val();
  stateSelected = parseInt(stateSelected);
  $.ajax({
	 url : "../ajax/cities/"+stateSelected,
	 method : "POST",
	 data : {"_token": "{{ csrf_token() }}"},
	 success :  function(response,status){
		if(response!==undefined){
			
			response = JSON.parse(response);
			console.log("response : "+response);
			$("#city").find("option").not(':eq(0)').remove();
			$(response).each(function(key,cityObj){
				console.log("city : "+cityObj.city_name );
				optionTag = document.createElement("option");
				optionTag.value = cityObj.city_id;
				optionTag.innerHTML = cityObj.city_name;
				if(cityId!=="" && cityId>0){
					optionTag.selected = "selected";
				}
				$("#city").append(optionTag);
			});
		}
	 }
  });
}
var showOn;
function toggle_features(show_as){
	$("div.toggle_features").hide();
	divs =  $("div.toggle_features");
	console.log("show_as : "+show_as)
	if(show_as!==undefined && show_as!==""){
	  show_as = show_as.toLowerCase();
	  $(divs).each(function(key, elem){
		  showOn = $(elem).attr("show-on");
		  console.log("show on : "+showOn);
		  if(showOn!==undefined){
			  splitShowOn = showOn.split(",");
			  $(splitShowOn).each(function(ind,value){
				  if(value == show_as){
					  $(elem).show();
				  }
			  });
		  }
	  });
	}
}

$("#state").change(function(){
	fill_city(0);
});

$("#show_as").change(function(){
	selectedVal = $(this).val();
	toggle_features(selectedVal);
});

$(".button-selector button").click(function(){
	isSelected = $(this).hasClass("selected");
	if(isSelected == false){
		closestOuter = $(this).closest("div.button-selector");
		allButtons = $(closestOuter).find("button");
		$(allButtons).removeClass("selected");
		bindTo = $(this).attr("bind-to");
		$(this).addClass("selected");
		$("#"+bindTo).val($(this).val());
	}
});


validateTab1("addform_1");
function validateForm(obj, context){
  if(context.fromStep ==1){
	  //alert($("#addform_1").valid());
	  //$("#addform_1").;
	  $("#addform_1").submit();
	  if($("#addform_1").valid()){
		  if($("#addform_1 > #id").val()){
			  return true;
		  }else{
		  	$("#submit1").trigger("click");
		  }
	  }
	  return true;
  }
}


