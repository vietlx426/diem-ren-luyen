/* --------- User - Group - Permission --------- */
$("input[name='searchstudentby']:radio").on("change", function() { 
    // alert('hola'); 
    var checkedValue = $("input[name='searchstudentby']:checked").val();
    switch (checkedValue)
    {
      case '1':
        HiddenAllWithOutID('divSearchFalcuty');
        break;

      case '2':
        HiddenAllWithOutID('divSearchMajor');
        break;
        
      case '3':
        HiddenAllWithOutID('divSearchScholastic');
        break;

    case '4':
        HiddenAllWithOutID('divSearchClass');
        break;

      case '5':
        HiddenAllWithOutID('divSearchIDStudent');
        break;

      case '6':
        HiddenAllWithOutID('divSearchEmail');
        break;

      default:
        break;
    }
});


$('.btn-search-student').click(function(e){
    if(!hasErrorStudent())
    {
        searchGetDataStudent();
    }
});

function hasErrorStudent() {
  var checkedValue = $("input[name='searchstudentby']:checked").val();

    switch (checkedValue)
    {
      case '1':
        return hasErrorSearchFalcutyStudent();
        break;

      case '2':
        return hasErrorSearchMajorStudent();
        break;

      case '3':
        return hasErrorSearchScholasticStudent();
        break;
        
      case '4':
        return hasErrorSearchClassStudent();
        break;

      case '5':
        return hasErrorSearchIDStudentStudent();
        break;

      case '6':
        return hasErrorSearchEmailStudent();
        break;

      default:
    }
}

function hasErrorSearchFalcutyStudent() {
    if($('#selKhoa').val() < '1')
    {
        $('#divSearchFalcuty').addClass('has-error');
        $('#SearchFalcuty-help').html('Chọn khoa');
        return true;
    }
    else
    {
        $('#divSearchFalcuty').removeClass('has-error');
        $('#SearchFalcuty-help').html('');
        return false;
    }
}

function hasErrorSearchMajorStudent() {
    if($('#selMajor').val() < '1')
    {
        $('#divSearchMajor').addClass('has-error');
        $('#SearchMajor-help').html('Chọn ngành');
        return true;
    }
    else
    {
        $('#divSearchMajor').removeClass('has-error');
        $('#SearchMajor-help').html('');
        return false;
    }
}

function hasErrorSearchScholasticStudent() {
    if($('#selScholastic').val() < '1')
    {
        $('#divSearchScholastic').addClass('has-error');
        $('#SearchScholastic-help').html('Chọn khóa');
        return true;
    }
    else
    {
        $('#divSearchScholastic').removeClass('has-error');
        $('#SearchScholastic-help').html('');
        return false;
    }
}

function hasErrorSearchClassStudent() {
    if(isEmpty($('#inpClassName').val()))
    {
        $('#divSearchClass').addClass('has-error');
        $('#SearchClass-help').html('Nhập tên lớp');
        return true;
    }
    else
    {
        $('#divSearchClass').removeClass('has-error');
        $('#SearchClass-help').html('');
        return false;
    }
}

function hasErrorSearchIDStudentStudent() {
    if(isEmpty($('#inpIDStudent').val()))
    {
        $('#divSearchIDStudent').addClass('has-error');
        $('#SearchIDStudent-help').html('Nhập mã số sinh viên');
        return true;
    }
    else
    {
        $('#divSearchIDStudent').removeClass('has-error');
        $('#SearchIDStudent-help').html('');
        return false;
    }
}

function hasErrorSearchEmailStudent() {
    if(isEmpty($('#inpEmail').val()))
    {
        $('#divSearchEmail').addClass('has-error');
        $('#SearchEmail-help').html('Nhập email');
        return true;
    }
    else
    {
        $('#divSearchEmail').removeClass('has-error');
        $('#SearchEmail-help').html('');
        return false;
    }
}

function searchGetDataStudent() {
  try{
    var checkedValue = $("input[name='searchstudentby']:checked").val();
    // openloadingeffect();
    loadereffectshow();
    
    switch (checkedValue)
    {
      case '1':
        getDataByFalcutyStudent();
        break;

      case '2':
        getDataByMajorStudent();
        break;

      case '3':
        getDataByScholasticStudent();
        break;
        
      case '4':
        getDataByClassStudent();
        break;

      case '5':
        getDataByMSSVStudent();
        break;

      case '6':
        getDataByEmailStudent();
        break;

      default:
    }

  }catch(e){

  }

  
}

function getDataByFalcutyStudent() {
 
  urlRoute = urlRoutestudentbykhoa + "/" + $('#selKhoa').val();

  $.ajaxSetup({
        headers: getHeaders()
    });

  $.ajax({
      url: urlRoute,
      type: "get",
  })

  .done(function(data) {
    viewDataInTableStudent(data);
  })

  .fail(function() {
    alert( "error" );
  });

}

function getDataByMajorStudent() {
 
  urlRoute = urlRoutestudentbynganh + "/" + $('#selMajor').val();

  $.ajaxSetup({
        headers: getHeaders()
    });

  $.ajax({
      url: urlRoute,
      type: "get",
  })

  .done(function(data) {
    viewDataInTableStudent(data);
  })

  .fail(function() {
    alert( "error" );
  });

}

function getDataByScholasticStudent() {
 
  urlRoute = urlRoutestudentbykhoahoc + "/" + $('#selScholastic').val();

  $.ajaxSetup({
        headers: getHeaders()
    });

  $.ajax({
      url: urlRoute,
      type: "get",
  })

  .done(function(data) {
    viewDataInTableStudent(data);
  })

  .fail(function() {
    alert( "error" );
  });

}

function getDataByClassStudent() {
 
  urlRoute = urlRoutestudentbylop + "/" + $('#inpClassName').val();

  $.ajaxSetup({
        headers: getHeaders()
    });

  $.ajax({
      url: urlRoute,
      type: "get",
  })

  .done(function(data) {
    viewDataInTableStudent(data);
  })

  .fail(function() {
    alert( "error" );
  });

}

function getDataByMSSVStudent() {
 
  urlRoute = urlRoutestudentbymssv + "/" + $('#inpIDStudent').val();

  $.ajaxSetup({
        headers: getHeaders()
    });

  $.ajax({
      url: urlRoute,
      type: "get",
  })

  .done(function(data) {
    viewDataInTableStudent(data);
  })

  .fail(function() {
    alert( "error" );
  });

}

function getDataByEmailStudent() {
 
  urlRoute = urlRoutestudentbyemail + "/" + $('#inpEmail').val();

  $.ajaxSetup({
        headers: getHeaders()
    });

  $.ajax({
      url: urlRoute,
      type: "get",
  })

  .done(function(data) {
    viewDataInTableStudent(data);
  })

  .fail(function() {
    alert( "error" );
  });

}

function viewDataInTableStudent(data) {

  // var datatable = $('#tbluser').DataTable();
  // datatable.clear();
  $('#tbodystudent').html('');
  var STT = '0';
  $.each(data, function( key, value ) {
    var newRow = '<tr>';
    newRow += '<td>' + (++STT) + '</td>'
    newRow += '<td>' + value['mssv'] + '</td>'
    newRow += '<td>' + value['hochulot'] + ' ' + value['ten']  + '</td>'
    // newRow += '<td>' + value['email_agu'] + '</td>'
    newRow += '<td>' + value['tenlop'] + '</td>'
    newRow += '<td>' + value['tennganh'] + '</td>'
    newRow += '<td>' + value['tenkhoa'] + '</td>'
   
    // newRow += '<td class="text-center-middle">' +
    //             '<a target="_blank" href="' + urlRouteusergroupedit + "/" + value['id'] + '" class="btn btn-warning" title="Xem chi tiết & Sửa"><i class="fa fa-edit"></i></a>' + 
    //           '</td>';
        
    // if(parseInt(value['tongluongton']) < 10)
    // {
    //   newRow += '<td class="text-center"><span class="badge bg-red">' + value['tongluongton'] + '</span></td>';
    // }
    // else
    // {
    //   if(parseInt(value['tongluongton']) < 50)
    //   {
    //     newRow += '<td class="text-center"><span class="badge bg-yellow">' + value['tongluongton'] + '</span></td>';
    //   }
    //   else
    //   {
    //     newRow += '<td class="text-center"><span class="badge bg-green">' + value['tongluongton'] + '</span></td>';
    //   }
    // }

    newRow += '</tr>';

    $('#tbodystudent').append(newRow);
  });

  if(STT == '0')
  {
    $('#tbodystudent').html('<tr><td colspan="7" class="text-center"><h4> Không tìm thấy thông tin trong hệ thống! </h4></td></tr>');
  }

  // closeloadingeffect();
  loadereffecthide();
  

  // $('#tbluser').DataTable();
}


/* --------- End User - Group - Permission --------- */