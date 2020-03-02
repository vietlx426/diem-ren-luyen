$(document).ready(function() {
    $('#fakeUploadLogo').addClass('hidden');
    var brand = document.getElementById('picprofile');
    brand.className = 'attachment_upload';
    brand.onchange = function() {
        document.getElementById('fakeUploadLogo').value = this.value.substring(12);
    };

    function readURL(input) {
        if (input.files && input.files[0]) {
            if (isValidFileType($('#picprofile').val(), 'image')) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('.img-preview').attr('src', e.target.result);
                };
                reader.readAsDataURL(input.files[0]);
            }
            else
            {
                alert('File vừa chọn không đúng định dạng.\nVui lòng chọn những file hình ảnh (là những file có phần mở rộng .jpg .png . gif . bmp)');
            }
        }
    }
    $("#picprofile").change(function() {
        readURL(this);
    });

    var extensionLists = {}; //Create an object for all extension lists
    extensionLists.video = ['m4v', 'avi','mpg','mp4', 'webm'];  
    extensionLists.image = ['jpg', 'gif', 'bmp', 'png'];

    // One validation function for all file types    
    function isValidFileType(fName, fType) {
        return extensionLists[fType].indexOf(fName.split('.').pop().toLowerCase()) > -1;
    }

    // Set flat checked for picture selected
    $('.btn-check-lylich-pic').click(function(e){
        $('.btn-check-lylich-pic').removeClass('btn-primary');
        $('.btn-check-lylich-pic').addClass('btn-default');
        $('.btn-check-lylich-pic').html('<i class="fa fa-square-o"></i>');
        $(this).html('<i class="fa fa-check-square-o"></i>');
        $(this).removeClass('btn-default');
        $(this).addClass('btn-primary');
        $('#picpath').val($(this).attr('value'));
    });

    $('.btn-save-hinhthe-copy').click(function(e){
        if(isEmpty($('#picpath').val()))
            alert("Vui lòng chọn hình ảnh trước khi lưu");
        else
        {
            loadereffectshow();
            var data = {'picpath': $('#picpath').val(), 'idsinhvien': idSinhVien};
            var resultAjax = callAjax(urlRoute_adminpostpicforstudentcardcopy, "POST", data);
            alert(resultAjax.message);
            if(resultAjax.result)
            {
                loadereffectshow();
                location.reload();
            }
            else
                loadereffecthide();
        }
        console.log("btn-save-hinhthe-copy");
    });

});


