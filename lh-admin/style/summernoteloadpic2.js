 $('#summernote').summernote({
 	callbacks: { 
 	onImageUpload: function (files) {
            sendFile(files);
        }
    }
});
/** * 发送图片文件给服务器端 */
function sendFile(files) {
    let imageData = new FormData();
    imageData.append("imageData", files[0]);
    $.ajax({
        url: '', // 图片上传url
        type: 'POST',
        data: imageData,
        cache: false,
        contentType: false,
        processData: false,
        dataType: 'json',     // 以json的形式接收返回的数据
        // 图片上传成功
        success: function ($result) {
            let imgNode = document.createElement("img");
            imgNode.src = $result.img;
            summer.summernote('insertNode', imgNode);
        },
        // 图片上传失败
        error: function () {
            console.log('图片上传失败');
        }
    });
}