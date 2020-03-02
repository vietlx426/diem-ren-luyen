$('#khoaphong').change(function(e){
	var idKhoa = $('#khoaphong').val();
	var url = url_route_admin_get_bomonbykhoa + "/" + idKhoa;
	var data = callAjax(url, "GET");
	$('#bomonto').html("");
	var opt = '<option value="">--- Bộ môn/Tổ ---</option>';
	$.each(data, function(key, value){
		opt += '<option value="' + value.id + '">' + value.tenbomon + '</option>';
	})
	$('#bomonto').html(opt);
});