$(document).ready(function() {
	var s = document.location;
	$("#divNavBar a").each(function() {
		if (this.href == s.toString().split("#")[0]) {
			$(this).parent().addClass("active");
			return false;
		}
	});
});

// 数字增减
(function ($) {
	$('#p-order span:last-of-type #plus').on('click', function() {
		$('#p-order input').val( parseInt($('#p-order input').val(), 10) + 1);
	});
	$('#p-order span:last-of-type #minus').on('click', function() {
		$('#p-order input').val( parseInt($('#p-order input').val(), 10) - 1);
	});
})(jQuery);

//定时显示、关闭
setTimeout(function(){
    $('.return').show(); //将return标签显示出来。
    setTimeout(function(){
        $('.return').hide(); //将return标签隐藏。
    }, 1200);
}, 1200);

// //警告框
// $('#myAlert').alert('close');

// 返回顶部时影藏
// $(function(){
//     $(window).scroll(function() {
//         var scrollY = $(document).scrollTop();
//         if (scrollY <= 0){
//         	$('#backTop').addClass('hiddened');
//         } 
//         else {
//             $('#backTop').removeClass('hiddened');
//         }
//      });
// });
// // 返回顶部
// $("#returnTop").click(function () {
//     var speed = 500;
//     $('body,html').animate({scrollTop:0}, speed);
//     return false;
// });