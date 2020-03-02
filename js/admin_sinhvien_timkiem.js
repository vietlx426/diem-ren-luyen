$('#mssv').keyup(function(e){
    /* Ignore tab key */
    var code = e.keyCode || e.which;
    if (code == '9') return;
    /* Useful DOM data and selectors */
    if(code == '13')
    {
        SearchStudent();
    }
});

$('.search_student_id').click(function (e) {
    SearchStudent();
})

function SearchStudent() {
    if(isEmpty($('#mssv').val()))
    {
        alert ("Nhập mã số sinh viên");
        $('#mssv').focus();
    }
    else
    {
        // var url = $('.search_student_id').attr('url');

        // var mssv = $('#mssv').val().trim()

        var url_full = $('.search_student_id').attr('url') + '/' + $('#mssv').val().trim();

        callAjaxSearchStudent(url_full);
    }
}

function isEmpty(str) {
    // str = str.trim();
    if(str == null || str == '')
    {
        return true;
    }
    else
    {
        return false;
    }
}

function getToken() {
	return $('meta[name="csrf-token"]').attr('content');
}

function getHeaders() {
	return headers = {
            'X-CSRF-TOKEN': getToken()
        }
}

function callAjaxSearchStudent(url) {
    $.ajaxSetup({
        headers: getHeaders()
    });
    
    $.ajax({
        url: url,
        type: "get",
        data: '',
    })
    .done(function(result) {
        if(result.status)
        {
            $('#tbody').html('');

            $.each(result.Data, function (index, value) {

                var tr = '<tr>' +
                            '<td class="text-center-middle">'+ value['mssv'] + '</td>' +
                            '<td class="text-justify-middle">' + value['hochulot'] + ' ' + value['ten'] + '</td>' +
                            '<td class="text-center-middle">' + value['tenlop'] + '</td>' +
                            '<td class="text-justify-middle">' + value['tennganh'] + '</td>' +
                            '<td  class="text-justify-middle">' + value['tenkhoa'] + '</td>';
                if(isEmpty(value['sinhvien_id']))
                {
                    tr += '<td class="text-center-middle">' +
                                '<a target="_blank" href="' + $('#div_url_studentprofile').val() + '/' + value['id'] + '" class="btn btn-danger" title="Chưa khai lý lịch. Click vào để cập nhật hình">' +
                                    '<i class="fa fa-info-circle"></i>' +
                                '</a>' +
                            '</td>';
                }
                else
                {
                    tr += '<td class="text-center-middle">' +
                                '<a target="_blank" href="' + $('#div_url_studentprofile').val() + '/' + value['id'] + '" class="btn btn-success" title="Đã khai lý lịch. Click vào để cập nhật hình">' +
                                    '<i class="fa fa-info-circle"></i>' +
                                '</a>' +
                            '</td>';
                }

                tr += '</tr>';
                $('#tbody').append(tr);
            })
        }
        else
        {
            $('#tbody').html('');
            alert(result.message);
        }
    })
    .fail(function(jqXHR, textStatus) {
      alert(textStatus);
    });
}
