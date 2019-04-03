    //调用富文本编辑
    $(document).ready(function() {
      var $summernote = $('#summernote').summernote({
        height: 300,
        minHeight: null,
        maxHeight: null,
        focus: true,
        lang: 'zh-CN', //必须先加入summernote-zh-CN.js才能使用
        placeholder: "1、在此输入文字；2、插入图片可保存到服务器；3、通过键盘清除键可删除服务器的图片；4、可添加emojis",
        //调用图片上传
        callbacks: {
            onImageUpload: function (files) {
                sendFile($summernote, files[0]);
            },
          }
    });
    //ajax上传图片
    function sendFile($summernote, file) {
        var formData = new FormData();
        formData.append("file", file);
        $.ajax({
            url: "style/summernote/server.php",
            data: formData,
            type: 'POST',
            //如果提交data是FormData类型，那么下面三句一定需要加上
            cache: false,  
            contentType: false,
            processData: false,
			success: function (data) {
              $('#summernote').summernote('insertImage', data);  //直接插入路径就行，filename可选
              console.log(data);
            },
            error:function(){
              alert("上传图片失败！");
            }
        });
    }
	// Firefox和Chrome早期版本中带有前缀
    var MutationObserver = window.MutationObserver || window.WebKitMutationObserver || window.MozMutationObserver;

    //下面代码必须在var $summernote = $('#summernote').summernote()构造完才有class = note-editable，否则直接使用会报错
    //
    // 选择目标节点
    var target = document.querySelector('.note-editable'); 
    // 创建观察者对象
    var observer = new MutationObserver(function(mutations){ //观察对象的回调函数

      console.log(mutations);

      mutations.forEach(function(mutation) //forEach：遍历所有MutationRecord
      {  
        console.log(mutation);
        console.log(mutation.type);  //MutationRecord.type
        console.log(mutation.oldValue);  // 注意mutation.type是childList,则不能使用oldValue来获取值
        if(mutation.addedNodes[0]!=null){ 
          console.log(mutation.addedNodes);
           console.log(mutation.addedNodes[0]);
           console.log(mutation.addedNodes[0].src);
          if(mutation.addedNodes[0].tagName ==  "IMG")
            console.log("成功添加一张img");
       }

         if(mutation.removedNodes[0]!=null)
        {

           console.log(mutation.removedNodes);

           if(mutation.removedNodes[0].tagName ==  "IMG")
           {

              var href = location.href; //当前路径
              console.log(href);

              href = href.substring(0,href.lastIndexOf("/")+1);
              console.log(href);

              var imgSrc =mutation.removedNodes[0].src;
              imgSrc = imgSrc.replace(href,''); //一种分离相对路径很笨的办法

              $.ajax({
                 type: "POST",
                 url: "style/summernote/delete.php",  //同目录下的php文件
                 data:{imgSrc:imgSrc},
                 success: function(msg){ alert(msg); } //请求成功后的回调函数
               });
            }
        }

      });  

    });

    // 配置观察选项:
    var config = { attributes: true, childList: true, characterData: true ,subtree:true};

    // 传入目标节点和观察选项
    observer.observe(target, config);
});


    $("#submit").click(function () {
        var content = $('#summernote').summernote('code');
         $.ajax({
            url: "style/summernote/submit.php",
            data: {content:content},
            type: 'POST',
            success: function (data) {
              alert('写入txt文件成功！');
              //alert(data);
            },

            error:function(){
              alert("提交失败！");
            }
        });
})