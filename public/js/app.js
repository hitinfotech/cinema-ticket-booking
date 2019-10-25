$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$("#booking-window input[type='checkbox']").change(function(){
	var status = $(this).prop('checked');
	var seat_id = $(this).val();

	if(status){
		$('#booking-form input[name="seat_id"]').val(seat_id);
		$('#booking-form input[name="name"]').val('');
		$('#booking-form input[name="email"]').val('');
		$(".booking-warning").html('');
		$('#booking-form input[name="mobile"]').val('');

		$("#model-form").modal({
			backdrop: 'static',
    		keyboard: false
		});
	} else{
		$('#bookingc-form input[name="seat_id"]').val(seat_id);

		$("#model-cancel").modal({
			backdrop: 'static',
    		keyboard: false
		});
	}
})

$(".close-cmodal").click(function(){
	var seat_id = $('#bookingc-form input[name="seat_id"]').val();
	if(seat_id){
		$("#booking-window input[type='checkbox'][value='"+ seat_id +"']").prop("checked",true);
	}
	$("#model-cancel").modal('hide');
})

$(".close-modal").click(function(){
	var seat_id = $('#booking-form input[name="seat_id"]').val();
	if(seat_id){
		$("#booking-window input[type='checkbox'][value='"+ seat_id +"']").prop("checked",false);
	}
	$("#model-form").modal('hide');
})

$(".book-now").click(function(){
	$this = $(this);
	$.ajax({
		url: $('base').attr("href") + '/submit-booking',
		type:'POST',
		dataType:'json',
		data:$("#booking-form").serialize(),
		beforeSend:function(){$this.addClass("btn-loading");},
		complete:function(){$this.removeClass("btn-loading");},
		success:function(json){
			$container = $("#booking-form");
			$container.find(".has-error").removeClass("has-error");
			$container.find("span.text-danger").remove();
			$(".booking-warning").html('');

			if(json['warning']){
				$(".booking-warning").html('<div class="alert alert-danger">'+ json['warning'] +'</div>');
			}

			if(json['success']){
				$('#booking-form input[name="seat_id"]').val('');
				$(".booking-warning").html('<div class="alert alert-success">'+ json['success'] +' <br> <small>Window closed in 3 sec</small></div>');
				setTimeout(function(){ $("#model-form").modal('hide'); }, 3000);
			}

			if(json['errors']){
			    $.each(json['errors'], function(i,j){
			        $ele = $container.find('[name="'+ i +'"]');
			        if($ele){
			            $ele.parents(".form-group").addClass("has-error");
			            $ele.after("<span class='text-danger'>"+ j +"</span>");
			        }
			    })
			}
		},
	})
})

$(".book-cancel").click(function(){
	$this = $(this);
	$.ajax({
		url: $('base').attr("href") + '/cancel-booking',
		type:'POST',
		dataType:'json',
		data:$("#bookingc-form").serialize(),
		beforeSend:function(){$this.addClass("btn-loading");},
		complete:function(){$this.removeClass("btn-loading");},
		success:function(json){
			if(json['success']){
				$('#bookingc-form input[name="seat_id"]').val('');
				$(".bookingc-warning").html('<div class="alert alert-success">'+ json['success'] +' <br> <small>Window closed in 3 sec</small></div>');
				setTimeout(function(){ $("#model-cancel").modal('hide'); }, 3000);
			}

			if(json['warning']){
				$(".bookingc-warning").html('<div class="alert alert-danger">'+ json['warning'] +' <br> <small>Window closed in 3 sec</small></div>');
			}
		},
	})
})