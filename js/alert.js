// $('.alert').hide();
$('.modal').on('shown.bs.modal', function () {
   hideNotificationInformation();
});

$('.modal').on('hide.bs.modal', function () {
   hideNotificationInformation();
});

$(".closedivalert").click(function(e){
    hiddendivalert();
    e.preventDefault();
});

// $(".hidd").click(function(e){
//     hiddendivalert();
//     e.preventDefault();
// });

// function hiddendivalert() {
//     $('.divalert').hide();
// }

// function hiddendivalertwithclass(classname) {
//     $('.' + classname).hide();
// }

function showdivalert() {
    $('.alert').show();
    showTopModal();
}

function showdivalertUpdate() {
    $('.alert').show();
    showTopModalUpdate();
}

// function showdivalertwithclass(classname) {
//     $('.' + classname).show();
// }

function addmessagetostrongdivalert(messages) {
    $('.alert strong').html(messages);
}

// function addmessagetostrongdivalertwithclass(classname, messages) {
// 	alert("csd"+classname);
//     $('.'+ classname + ' strong').html(messages);
// }

// function showandaddmessagetodivalert(messages) {
//     addmessagetostrongdivalert(messages);
//     showdivalert();
// }

function hiddendivalert() {
    $('.alert').hide();
    $('.divalert').addClass('hidden');
    $('#divalert').attr('hidden', 'true');
}



function showNotificationInformation(alert_class, message) {
    var obj = $('.alert-information');
    obj.removeClass();
    obj.addClass(alert_class);
    obj.addClass('alert-information');
    obj.addClass('alert');

    // $('.' + divid).addClass(alert_class);
    // $('#' + divid).addClass('alert-information');
    $('.message').html(message);
    // obj.append('<strong>' + message + '</strong>');
    // obj.append('<strong>' + message + '</strong>');
        // '<div class="alert alert-dismissible fade show divalert" role="alert">' +
        //     '<button type="button" class="close closedivalert" aria-label="Close">' +
        //         '<span aria-hidden="true">&times;</span>' +
        //     '</button>' +
        //     '<strong>' + message + '</strong>' +
        // '</div>');

    // $(".closedivalert").click(function(e){
    //     hiddendivalert();
    //     e.preventDefault();
    // });

    // $(".hidd").click(function(e){
    //     hiddendivalert();
    //     e.preventDefault();
    // });

    showdivalert();
}

function showNotificationInformationUpdate(alert_class, message) {
    var obj = $('.alert-information');
    obj.removeClass();
    obj.addClass(alert_class);
    obj.addClass('alert-information');
    obj.addClass('alert');

    $('.message').html(message);
    
    showdivalertUpdate();
}

function showNotificationInformationFromAjax(message) {
    var obj = $('.alert-information');
    obj.removeClass();
    obj.addClass('alert-warning');
    obj.addClass('alert-information');
    obj.addClass('alert');
    $('.message').html(message);
    showdivalert();

    // // $('#' + divid).removeClass();
    // $('.alert-info').addClass('alert-warning');
    // $('.alert-info').html(
    //     '<div class="alert alert-dismissible fade show divalert" role="alert">' +
    //         '<button type="button" class="close closedivalert" aria-label="Close">' +
    //             '<span aria-hidden="true">&times;</span>' +
    //         '</button>' +
    //         '<strong>' + message + '</strong>' +
    //     '</div>');

    // $(".closedivalert").click(function(e){
    //     hiddendivalert();
    //     e.preventDefault();
    // });

    // $(".hidd").click(function(e){
    //     hiddendivalert();
    //     e.preventDefault();
    // });
}


function showTopModal() {
    $('.divalert').removeClass('hidden');
    $('#divalert').removeAttr('hidden');
    $('.modal').animate({ scrollTop: 0 }, 'slow');
}

function showTopModalUpdate() {
    $('.divalert').removeClass('hidden');
    $('#divalertupdate').removeAttr('hidden');
    $('.modal').animate({ scrollTop: 0 }, 'slow');
}

function hideNotificationInformation() {
	hiddendivalert();
}