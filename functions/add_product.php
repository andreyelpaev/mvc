<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Andrey
 * Date: 05.08.13
 * Time: 21:50
 * To change this template use File | Settings | File Templates.
 */
isset($_GET['id']) ? $id = $_GET['id'] : $id = null;
isset($_GET['num']) ? $num = $_GET['num']: $num = null;

echo '
<div class="item">
<div class="item_title">Острый ролл с окунем</div>
<div class="numerator"><a href="#"><img src="/templates/images/mines.png" width="11" height="11" /></a>&nbsp; <span id="num">'.$num.'</span> шт. &nbsp;
<a href="#"><img src="/templates/images/plus.png" width="11" height="11" /></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="price">1580</span> руб.</div><a href="#">
<img class="del" src="/templates/images/del.png" width="23px" height="23px"  /></a>
<input type="hidden" class="del_product_id" value="'.$id.'">
</div>



<!-- <div class="good_in_bag good_zakaz">
						<div class="g_name name_zakaz">Суши с креветкой</div>
						<div class="del_g_bag"><a class="d_bag" href="#">&nbsp;</a></div>
						<div class="clearfix"></div>
						<div class="g_img"><a class="photo_zoom_bag" href="http://www.sushifuji.ru/goods_img/1000/large/Sushi_s_krevetkoy_22941.jpg" title="Суши с креветкой"><img src="http://www.sushifuji.ru/goods_img/1000/small/Sushi_s_krevetkoy_22941.jpg" border="0"></a></div>
						<div class="p_m_price">
								<div class="g_num_pm">
									<a class="minus_bag" href="#">&nbsp;</a>
									<span id="num">'.$num.'</span><span> шт.</span>
									<a class="plus_bag" href="#">&nbsp;</a>
									<div class="clearfix"></div>
								</div>
								<div class="g_sum"><span>50</span> руб.</div>
								<input type="hidden" class="bag_good_id" value="'.$id.'">
						</div>
						<div class="clearfix"></div>
					</div> -->
';

?>