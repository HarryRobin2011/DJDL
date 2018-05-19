
//处理底部跳转

$('.home-menus .changeCenter').click(function(){
	console.log(window.location.href.split('?')[1])
//	console.log(window.location.href)
	window.location.href = "./records.html?"+window.location.href.split('?')[1];
})

$('.home-menus .log').click(function(){
    window.location.href = "./chickenMarket.html?"+window.location.href.split('?')[1];
	// $.ajax({
	// 	url: host + "/User/GetFarmControl",
	// 	type: "post",
	// 	data: { token: userInfo.token },
	// 	dataType: "json",
	// 	async: false,
	// 	success: function(data) {
	// 		console.log(data);
	// 		if(data.errcode != 10000) {
	// 			alertMsg(data.msg);
	// 		} else {
	// 			if(data.result[0].lock==false){
     //             window.location.href = "./chickenMarket.html?"+window.location.href.split('?')[1];
	// 			}else{
	// 				alertMsg("您的账号已被管控，请联系管理员解除管控");
	// 			}
	// 		}
	// 	}
	// });
});

$('.home-menus .PY').click(function(){
//	console.log(window.location.href.split('?')[1])
//	console.log(window.location.href)
	window.location.href = "./chickensLog.html?"+window.location.href.split('?')[1];
})