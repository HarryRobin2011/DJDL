/**
 * Created by jiaruo on 17/2/25.
 */
//处理页面显示业务
var userInfo = JSON.parse(sessionStorage.getItem('userInfo'));

if(!userInfo.nickname) userInfo.nickname = "注册会员";
$('.item-content .name').text(userInfo.nickname);
//$('.q-num .red').text(userInfo.money);
// $('.q-num .red').text(userInfo.currency);
if(!userInfo.currency) userInfo.currency = 0;
$('.item-content .round:eq(0)').text(userInfo.currency);

// if(!userInfo.animal_count) userInfo.animal_count = 0;
// $('.item-content .round:eq(1)').text(22);
$('.item-content .round:eq(1)').text(userInfo.all_animal);
$('.item-content .round:eq(2)').text(userInfo.proportion);
$('.item-content .round:eq(3)').text(userInfo.yuanbao);