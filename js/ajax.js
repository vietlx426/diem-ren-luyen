function getToken() {
	return $('meta[name="csrf-token"]').attr('content');
}

function getHeaders() {
	return headers = {
            'X-CSRF-TOKEN': getToken()
        }
}

function callAjax(uRL, method, data) {
  var resultAjax;
  
  $.ajaxSetup({
        headers: getHeaders()
    });

  switch (method.toUpperCase()) {
    case 'GET':
      var request = $.ajax({
        url: uRL,
        method: method,
        async: false
      });
       
      request.done(function( msg ) {
        resultAjax = msg;
      });
       
      request.fail(function( jqXHR, textStatus ) {
        resultAjax = false;
      });
      return resultAjax;

      break;

    case 'POST':
      var request = $.ajax({
        url: uRL,
        method: method,
        data : data,
        async: false
      });
       
      request.done(function( msg ) {
        resultAjax = msg;
      });
       
      request.fail(function( jqXHR, textStatus ) {
        resultAjax = false;
      });
      return resultAjax;

      break;

    case 'PUT':
      var request = $.ajax({
        url: uRL,
        method: method,
        data : data,
        async: false
      });
       
      request.done(function( msg ) {
        resultAjax = msg;
      });
       
      request.fail(function( jqXHR, textStatus ) {
        resultAjax = false;
      });

      return resultAjax;

      break;

    case 'HEAD':
      alert("case HEAD");
      break;

    case 'DELETE':
      var request = $.ajax({
        url: uRL,
        method: method,
        async: false
      });
       
      request.done(function( msg ) {
        resultAjax = msg;
      });
       
      request.fail(function( jqXHR, textStatus ) {
        resultAjax = false;
      });
      
      return resultAjax;

      break;

    default:
        alert("case default");
  }
}

function callAjaxStore(url, data) {
    $.ajaxSetup({
        headers: getHeaders()
    });
    
    $.ajax({
        url: url,
        type: "post",
        data: data,
    })
    .done(function(result) {
        if(result.status)
        {
            alert(result.message);
            location.reload();
        }
        else
        {
            alert("Lỗi");
            showNotificationInformationFromAjax(result.message);
        }
    })
    .fail(function(jqXHR, textStatus) {
      alert(textStatus);
    });
}

function callAjaxUpdate(url, data) {
    $.ajaxSetup({
        headers: getHeaders()
    });
    $.ajax({
        url: url,
        type: "post",
        data: data,
    })
    .done(function(result) {
        if(result.status)
        {
            alert(result.message);
            location.reload();
        }
        else
        {
            showNotificationInformationFromAjax(result.message);
        }
    })
    .fail(function(jqXHR, textStatus) {
      alert(textStatus);
    });
}

function callAjaxDestroy(url) {
    $.ajaxSetup({
        headers: getHeaders()
    });
    $.ajax({
        url: url,
        type: "get",
    })
    .done(function(result) {
        if(result.status)
        {
            alert(result.message);
            location.reload();
        }
        else
        {
          alert(result.message);
          showNotificationInformationFromAjax(result.message);
        }
    })
    .fail(function(jqXHR, textStatus) {
      alert(textStatus);
    });
}

function loadereffectshow() {
  $('#site-loader').addClass('show');
}

function loadereffecthide() {
  $( "#site-loader" ).fadeOut( "slow", function() {
      $('#site-loader').removeClass('show');
  });
}