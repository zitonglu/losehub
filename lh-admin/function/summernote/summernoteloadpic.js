//调用富文本编辑
$(document).ready(function() {
 var $summernote = $('#summernote').summernote({
  height: 350,
  minHeight: null,
  maxHeight: null,
  focus: true,
  lang: 'zh-CN', 
  placeholder: "欢迎使用LoseHub CMS",
    //调用图片上传
    callbacks: {
      onImageUpload: function (files) {
        sendFile(files);
      },
    }
  });
  //ajax上传图片
  function sendFile(file) {
    var formData = new FormData();
    formData.append("file", file[0]);
    $.ajax({
      url: "function/summernote/summernote-loadIMG.php",
      data: formData,
      type: 'POST',
      cache: false,  
      contentType: false,
      processData: false,
      success: function (dataUrl) {
        $('#summernote').summernote('insertImage',dataUrl);
        console.log(dataUrl);
      },
      error:function(){
        alert("上传图片失败！");
      }
    });
  }
  // $.ajax({
  //   url: "summernote/submit.php",
  //   data: {content:content},
  //   type: 'POST',
  //   success: function (data) {
  //     alert('写入txt文件成功！');
  //             //alert(data);
  //   },error:function(){
  //     alert("提交失败！");
  //   }
  // });
})