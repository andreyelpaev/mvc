<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
<title><?php echo Page::$title; ?></title>
<link href="/templates/style.css" rel="stylesheet" type="text/css" />
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script type="text/javascript" src="/templates/js/scripts.js"></script>
<script type="text/javascript" src="/templates/js/jquery.cookie.js"></script>
<script type="text/javascript" src="/templates/js/basket.js"></script>
</head>

<body>
<div class="list" > <!--Лист-->
<div class="header"><!--Шапка-->

<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td><div class="logo"><img src="/templates/images/logo.png" alt="Супер суши" width="280" height="90" /></div></td>
<td rowspan="3" valign="top">
<div style="margin:2px 0 5px 15px; font-style:italic;">Сеть доставки суши и пиццы "Супер суши" : г. Уфа </div>
<div class="slider"><img src="/templates/images/slider_img.png" width="843" height="342" /></div></td>
</tr>
<tr>
<td valign="top">
<div class="phone">(347) 275-18-58</br>8-927-34-00-333</div>


<div style="background-image:url(/templates/images/vash.png); width:100px; height:14px; margin:10px auto 10px auto;"></div>
    <div class="basket">

    <?php echo Page::$basket; ?>
    </div>


</td>
</tr>
<tr>
  <td valign="top"><div class="korz"><img src="/templates/images/korz.png" width="84" height="40" /><span class="sum">&nbsp;&nbsp;Всего: <span class="sale">0</span> <span style="font-style:italic;">руб.</span>
</span>
</div>

<div class="ofzak"><a href="#">Оформить заказ</a></div>

</div>

</td>
</tr>

</table>

</div><!-- закрыл Шапка-->
<div class="top_menu"><!-- Гор. меню -->

<nav class="navigation">
  <ul class="nav-list">
    <li class="i1"><a href="/"></a></li>
    <li class="i2"><a href="/menu/"></a></li>
    <li class="i3"><a href="/deleviry/"></a></li>
    <li class="i4"><a href="/payment/"></a></li>
    <li class="i5"><a href="/reviews/"></a></li>
    <li class="i6"><a href="/news/"></a></li>
    <li class="i7"><a href="/contacts/"></a></li>
  </ul>
</nav>

</div> 
<p><!-- закрыл Гор. меню--></p>
<table class="content" width="1164" border="0" cellspacing="0" cellpadding="0">
  <tr >
    <td width="263" class="content_title" align="center"><span>Меню</span></td>
    <td width="24"></td>
    <td width="877" class="content_title" align="center"><span><?php echo Page::$contentTitle; ?></span></td>
  </tr>
  <tr>
    <td colspan="2" valign="top">

    <!-- Левое меню -->
        <?php echo Page::$leftmenu; ?>
    <!--Конец левого меню -->
    </td>
    <td valign="top">
    <?php echo Page::$content; ?>
    </td>
  </tr>
</table>
<div class="beep"></div>
<div class="footer">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="33%" valign="top">
    <br />
    <div style="border-bottom:#ddd1ac 1px solid; width:249px; margin-left:49px; height:29px;" class="footer_tit">Мы работаем для Вас</div>
    <div style="border-bottom:#ddd1ac 1px solid; width:249px; margin-left:49px; line-height:23px; font-weight:bold; font-size:14px;">Понедельник<br />
      Вторник<span style="margin-left:55px;">с 11:00 до 24:00</span><br />
      Среда<br />
      Четверг<br />
      </div>
      <div style="border-bottom:#ddd1ac 1px solid; width:249px; margin-left:49px; line-height:23px; font-weight:bold; font-size:14px;">
      Пятница <br />
      Суббота <span style="margin-left:55px;">с 11:00 до 01:00</span><br />
      Воскресенье</div></td>
    <td width="35%" align="center" class="cont"><div class="footer_tit">Контакты</div><br />
      Телефон заказов: (347) 275-18-58 <br />
      Телефон заказов: 8-927-34-00-333<br /><br />
      Прием заказов заканчивается за 30 минут до закрытия ресторана.</td>
    <td width="32%" align="center" valign="top"><br /><div class="footer_tit">Мы принимаем</div><br />
      <img src="/templates/images/visa.png" alt="Мы принимаем" width="230" height="33" />
<div style="margin-top:10px;" class="footer_tit"><br />Поделиться с друзьями</div>
    <br />
    <div>
    <script type="text/javascript">(function() {
          if (window.pluso)if (typeof window.pluso.start == "function") return;
          var d = document, s = d.createElement('script'), g = 'getElementsByTagName';
          s.type = 'text/javascript'; s.charset='UTF-8'; s.async = true;
          s.src = ('https:' == window.location.protocol ? 'https' : 'http')  + '://share.pluso.ru/pluso-like.js';
          var h=d[g]('head')[0] || d[g]('body')[0];
          h.appendChild(s);
          })();</script>
        <div class="pluso" data-options="big,square,line,horizontal,nocounter,theme=04" data-services="vkontakte,odnoklassniki,facebook,moimir" data-background="transparent"></div>
        </div>
    </td>
  </tr>
</table>

</div>
</div><!-- закрыл Лист-->
<div class="copy">© 2012-2013 «www.s-sushi.ru». Все права защищены.</div>
</body>
</html>
