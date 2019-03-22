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
	$('.spinner .input-group span:last-of-type #plus').on('click', function() {
		$('.spinner input').val( parseInt($('.spinner input').val(), 10) + 1);
	});
	$('.spinner .input-group span:last-of-type #minus').on('click', function() {
		$('.spinner input').val( parseInt($('.spinner input').val(), 10) - 1);
	});
})(jQuery);
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