/*
 * Input File
 */

 // Clear event
$('.image-preview-clear').click(function(){
  $('.image-preview').attr("data-content","").popover('hide');
  $('.image-preview-filename').val("");
  $('.image-preview-clear').hide();
  $('.image-preview-input input:file').val("");
  $(".image-preview-input-title").text("Browse"); 
}); 

// Create the preview image
$(".image-preview-input input:file").change(function (){
  var file = this.files[0];
  var reader = new FileReader();

  // Set preview image into the popover data-content
  reader.onload = function (e) {
      $(".image-preview-input-title").text("Change");
      $(".image-preview-clear").show();
      $(".image-preview-filename").val(file.name);            
      // img.attr('src', e.target.result);
      // $(".image-preview").attr("data-content",$(img)[0].outerHTML).popover("show");
  }        
  reader.readAsDataURL(file);
});

// Create the preview image
$(".file-preview-input input:file").change(function (){
  var file = this.files[0];
  var reader = new FileReader();

  // Set preview image into the popover data-content
  reader.onload = function (e) {
      $(".file-preview-input-title").text("Change");
      $(".file-preview-clear").show();
      $(".file-preview-filename").val(file.name);            
      // img.attr('src', e.target.result);
      // $(".image-preview").attr("data-content",$(img)[0].outerHTML).popover("show");
  }        
  reader.readAsDataURL(file);
});

/*
 * End Input File
 */