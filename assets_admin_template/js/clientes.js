$(document).on("ready", main);

function main(){
	var base_url = "<?php echo base_url();?>";
	$("select").change(function(){
		var selected = $(this).val(); 
		$.ajax({
			url:base_url+"/clientes/cantidad",
			type: "POST",
			data: {cantidad:selected},
			success:function(){
				window.location.href = base_url+"/clientes";
			}
		});
	});
}