CKEDITOR.replace('txttentieuchi');
CKEDITOR.replace('Ten_TieuChi_CapNhat');

$(".remove_tieuchi").click(function (e) {
    e.preventDefault();
    if(confirm("Bạn có muốn xóa tiêu chí này?"))
        callAjaxDestroy($(this).attr('href'));
});