



$(".bangdiemrenluyen_xacnhan").click(function(e){
  var t =[];
  //alert(x.join(','));
  $("input[type='radio']:checked").each(function(){
    t.push(this.value);
  });

  $("input[type='checkbox']:checked").each(function(){
    t.push(this.value);
  });

  $("input[type='number']").each(function(){
    var id = $(this).attr("id");
    var value = id+"-"+this.value;
    t.push(value);
  });
  var data = {
        Array: t
    };
  callAjaxStore($(this).attr('href'), data);
});





$(document).ready(function() {
  $('.JStableOuter table').scroll(function(e) { 
   
    $('.JStableOuter thead').css("left", -$(".JStableOuter tbody").scrollLeft()); 
    $('.JStableOuter thead th:nth-child(1)').css("left", $(".JStableOuter table").scrollLeft() -0 ); 
    $('.JStableOuter tbody td:nth-child(1)').css("left", $(".JStableOuter table").scrollLeft()); 

    $('.JStableOuter thead').css("top", -$(".JStableOuter tbody").scrollTop());
    $('.JStableOuter thead tr th').css("top", $(".JStableOuter table").scrollTop()); 

  });
});
 


$('#combobox_khoa').change(function(e){
      openloadingeffect();
        getDataByKhoa();
});

function getDataByKhoa() {
  urlRoute = urlRoutebykhoa + "/" + $('#combobox_khoa').val();

  $.ajaxSetup({
        headers: getHeaders()
    });

  $.ajax({
      url: urlRoute,
      type: "get",
  })

  .done(function(data) {
    viewDataInTableLop(data);
  })

  .fail(function() {
    alert( "error" );
  });

}





function viewDataInTableLop(data) {
  $('#tbbodybangdiemlop').html('');
  var STT = '0';
  $.each(data, function( key, value ) {
    var urlbylop = urlRoutebyLop+"/"+value['id'];
    STT++;
    var newRow = '<tr>';
    newRow +="<th>"+STT+"</th>";
    newRow +="<td><a href=\""+urlbylop+"\" style=\"text-decoration: none;\">"+value['malop']+"</a></td>";
    newRow +="<td><a href=\""+urlbylop+"\" style=\"text-decoration: none;\">"+value['tenlop']+"</a></td>";
    newRow +="<td>"+value['tennganh']+"</td>";
    newRow +="<td>"+value['tenbac']+"</td>";
    newRow +="<td>"+value['tenhe']+"</td>";
    newRow +="<td>"+value['nambatdau']+"-"+value['namketthuc']+"</td>";
    newRow +="</tr>";
    $('#tbbodybangdiemlop').append(newRow);
  });

  if(STT == '0')
  {
    $('#tbbodybangdiemlop').html('<tr><td colspan="7" class="text-center"><h4> Không tìm thấy lớp nào trong khoa này! </h4></td></tr>');
  }
  closeloadingeffect();
  }