var sitename = 'http://www.sushifuji.ru/';

$(document).ready(function(){

    // функция плюс минус для кол-ва товара
    function inc_dec(element, id)
    {
        var z = parseInt(id.text());
        z += element;

        if (z > 0)
        {
            id.text(z);
        }

        return false;
    }

    $(".decrement").click(function() {
        var k = $(this).parent().children(".num");
        return inc_dec(-1, k);
    });

    $(".increment").click(function() {
        var k = $(this).parent().children(".num");
        return inc_dec(1, k);
    });

    // показываем или нет кнопку оформл.заказа
    // если есть в корзине хотя бы один товар, то показываем кнопки заказа
    if ($('#all_goods').val() >= 1) $("#zakaz").show();

    // считаем сумму заказа
    function summa_zakaza(){
        // считаем сумму заказа
        var sum = 0;
        var num = Array();
        $(".g_num").each(function (i) {
            num[i] = parseInt($(this).text());
        });
        $(".g_sum span").each(function (i) {
            sum += parseInt($(this).text())*num[i];
        });

        $('.korzina_itog').fadeOut("fast", function(){
            $(this).html(sum);
        }).fadeIn("fast");
    }

    var a_g_start = false;

    // функция добавления товара в корзину
    function add_product(id, num, element)
    {
        if (!a_g_start)
        {
            var text = $('.basket').html();
            //$('#korzina_goods').html('<div id=\'load_img\'>&nbsp;</div>');
            //$('#korzina_goods').fadeIn("slow");

            $.ajax({
                url: '/functions/add_product.php?id='+id+'&num='+num,
                type: 'GET',
                cache: false,
                success: function(response) {
                    a_g_start = true; // запускаем выполнение

                    $('.basket').delay(500).fadeOut("fast", function(){

                        // добавляем cookie для товара в корзине
                        var add_cookie = "";
                        var add_id_cookie = id;
                        var add_num_cookie = num;
                        var productsId = Array();
                        var productsArray = Array();
                        var check = false;
                        var change_num = 0;

                        if($.cookie("basket") != null) add_cookie = decodeURI($.cookie("basket"));

                        productsArray = add_cookie.split(",");
                        add_cookie = "";
                        for(var i=0; i<productsArray.length-1; i++) {
                            productsId = productsArray[i].split(":");
                            if(productsId[0] == add_id_cookie)  // ищем, не покупали ли мы этот товар ранее
                            {
                                check = true;
                                productsId[1] = parseInt(productsId[1]) + parseInt(add_num_cookie);
                                change_num = productsId[1];
                            }
                            add_cookie += productsId[0]+":"+productsId[1]+",";
                        }
                        if(!check) {
                            add_cookie+= add_id_cookie + ':' + add_num_cookie + ',';
                        }

                        $.cookie("basket", add_cookie, {path: "/"}); //установить куки с временем жизни 1 день


                        // принимаем товар (ответ от скрипта)
                        var all_goods = $('#all_goods').val();

                        // вставляем текст
                        $(this).html(text);

                        if (all_goods == 0) {
                            text = response;
                            // вставляем текст
                            $(this).html(text);
                        }
                        else {
                            // если товар уже в корзине есть, то увеличиваем его количество
                            if(check) {
                                var c_n = 0;
                                $(".del_product_id").each(function (i) {
                                    if (id == $(this).val()) c_n = i;
                                });
                                $("span#num").each(function (i) {
                                    if (i==c_n) $(this).text(change_num);
                                });
                            }
                            else {
                                text = response + text;
                                // вставляем текст
                                $(this).html(text);
                            }
                        }

                        all_goods++;
                        $('#all_goods').val(all_goods);

                        // если добавили один товар, то показываем кнопки заказа
                        if (all_goods == 1) $("#zakaz").show("fast", function(){
                        });

                        // выводим сумму заказа
                        return summa_zakaza();

                    });

                    // выводим сообщ. о добавл.товара в корзину
                    $(element).parents(".good_item").children(".status_buy").html( function(){
                        $(this).fadeOut("fast", function(){
                            $(this).html("Положили в корзину");
                        });
                        $(this).fadeIn("slow", function(){});
                        return eqCenter(); // выравниваем высоту div столбцов
                    });

                    $('.basket').fadeIn("slow", function(){
                        // закончили выполнение аякс
                        a_g_start = false;
                    }).delay(700);

                },
                error:  function(xhr, str){
                    $('#add_error').html('Возникла ошибка: ' + xhr.responseCode);
                },
                complete:  function(){
                }
            });
        }

        return false;
    }


    // функция плюс минус для кол-ва товара в корзине
    function p_m_bag(e, g_id)
    {
        var c_n = 0;
        $(".bag_good_id").each(function (i) {
            if (g_id == $(this).val()) c_n = i;
        });

        $(".g_num").each(function (i) {

            if (i==c_n) {
                var change_num = parseInt($(this).text());
                change_num += e;

                if (change_num > 0)
                {
                    // добавляем cookie для товара в корзине
                    var add_cookie = "";
                    var add_id_cookie = g_id;
                    var goodsId = Array();
                    var goodsArray = Array();
                    var check = false;

                    if($.cookie("basket") != null) add_cookie = decodeURI($.cookie("basket"));

                    goodsArray = add_cookie.split(",");
                    add_cookie = "";
                    for(var i=0; i<goodsArray.length-1; i++) {
                        goodsId = goodsArray[i].split(":");
                        if(goodsId[0] == add_id_cookie)  // ищем, не покупали ли мы этот товар ранее
                        {
                            check = true;
                            goodsId[1] = change_num;
                        }
                        add_cookie += goodsId[0]+":"+goodsId[1]+",";
                    }


                    // если нашли товар с этим id, то записываем в куки и увелич. кол-во
                    if (check)
                    {
                        $.cookie("basket", add_cookie, {path: "/"}); //установить куки с временем жизни 1 день
                        $(this).text(change_num);
                        // выводим сумму заказа
                        return summa_zakaza();
                    }
                }
            }
        });

        return false;
    }

    // функция удаления товара из корзины
    function del_g_bag(g_id, reset)
    {
        // если не запущена аякс функция добавления товара
        if (!a_g_start)
        {
            var c_n = 0;
            var g_block = 0; // блок товара
            $(".bag_good_id").each(function (i) {
                if (g_id == $(this).val()) c_n = i;
            });

            $(".id_good").each(function (i) {
                if (g_id == $(this).val()) g_block = i;
            });

            $(".good_in_bag").each(function (k) {

                if (k==c_n) {
                    // добавляем cookie для товара в корзине
                    var add_cookie = "";
                    var add_id_cookie = g_id;
                    var goodsId = Array();
                    var goodsArray = Array();
                    var check = false;
                    var check_id = false;

                    if($.cookie("basket") != null) add_cookie = decodeURI($.cookie("basket"));

                    goodsArray = add_cookie.split(",");
                    add_cookie = "";
                    for(var i=0; i<goodsArray.length-1; i++) {
                        goodsId = goodsArray[i].split(":");
                        if(goodsId[0] == add_id_cookie)  // ищем, не покупали ли мы этот товар ранее
                        {
                            check = true;
                            check_id = true;
                        }
                        if(!check) add_cookie += goodsId[0]+":"+goodsId[1]+",";
                        check = false;
                    }

                    // в блоках с товарами пишем статус удаления
                    $(".status_buy").each(function (j) {
                        if(j == g_block)
                        {
                            $(this).fadeOut("fast", function(){
                                $(this).html("<span style=\"color: #bc0000;\">Удалили из корзины</span>");
                            });
                            $(this).fadeIn("slow", function(){});
                        }
                    });

                    // если нашли товар с этим id, то удаляем его
                    if (check_id)
                    {
                        $.cookie("basket", add_cookie, {path: "/"}); //установить куки с временем жизни 1 день
                        //сначала скрываем элемент

                        $(this).fadeOut("fast", function(){
                            // удаляем элемент
                            $(this).remove();

                            // если корзина пустая
                            if ($('.g_num').text() == "")
                            {
                                $('.zakaz').hide();
                                $('.basket').html("<p class=\"empty_bag\">Ваша корзина пуста</p>");
                                $('#all_goods').val(0);
                            }

                            if (!reset)
                            // выводим сумму заказа
                                return summa_zakaza();

                        });
                    }
                }
            });

        }

        return false;
    }

    // добавляем товар в корзину из каталога
    $(".add a").on("click", function(){
        var id = $(this).parent().children(".product_id").val();
        var num = $(this).parents(".numerator").children(".num").text();
        return add_product(id, num, this);
    });

    // плюс минус кол-во товара в корзине
    $(".plus_bag").on("click", function() {
        var g_id = $(this).parents(".p_m_price").children(".bag_good_id").val();
        return p_m_bag(1, g_id);
    });
    $(".minus_bag").on("click", function() {
        var g_id = $(this).parents(".p_m_price").children(".bag_good_id").val();
        return p_m_bag(-1, g_id);
    });

    // удаляем товар из корзины
    $(".d_bag").on("click", function(){
        var g_id = $(this).parents(".good_in_bag").children(".p_m_price").children(".bag_good_id").val();
        var reset = false; // откл. полная очистка корзины
        return del_g_bag(g_id, reset);
    });


    /* Для оформления заказа*/

    if ($("#zakaz_page").length > 0)
    {

        function check_client()
        {
            $(".new_client").toggle(function(){});
            $(".old_client").toggle(function(){});
        }

        $(".radio_zakaz").change(function () {
            return check_client();
        });

        $("#old_client").each(function(){
            if ($(this).attr("checked") == "checked") return check_client();
        });


        function select_delivery()
        {
            $(".self-delivery").toggle(function(){
                return eqCenter(); // выравниваем высоту div столбцов
            });
            $(".delivery").toggle(function(){
                return eqCenter(); // выравниваем высоту div столбцов
            });
            $(".address").toggle(function(){
                if ($("#get_zakaz").val() == "self-delivery")
                    $("#address").val('');
            });
        }

        $("#get_zakaz").each(function () {
            if ($(this).val() == "delivery")
                return select_delivery();
        });

        $("#get_zakaz").change(function () {
            return select_delivery();
        });

        $(".calendar_tbl a").each(function(){
            if ($(this).attr('title') == $("#date").val())
            {
                $(".link_checked").removeClass();
                $(".link_checked").addClass("link_cal");
                $(this).removeClass();
                $(this).addClass("link_checked");
                return false;
            }
        });

        $(".calendar_tbl a").click(function(){
            $(".link_checked").removeClass();
            $(".link_checked").addClass("link_cal");
            $(this).removeClass();
            $(this).addClass("link_checked");
            $("#date").val($(this).attr('title'));
            return false;
        });

        $("#phone_old").keyup(function() {
            var tmp="";
            tmp = $(this).val().replace(/[^+0-9]/g, '');
            if (tmp != $(this).val())
            {
                $(this).val(tmp);
            }
        });

        $("#phone").keyup(function() {
            var tmp="";
            tmp = $(this).val().replace(/[^+0-9]/g, '');
            if (tmp != $(this).val())
            {
                $(this).val(tmp);
            }

            $("#err_phone").hide(function(){return eqCenter();});
            // текст ошибки, при заполнении телефона
            $("#err_phone").text("Неверно указан номер телефона");

            tmp = $(this).val().replace(/[^0-9]/g, '');
            if (tmp.length == 11)
            {
                $("#err_phone").hide(function(){return eqCenter();});
            }
            if (tmp.length > 11)
            {
                $("#err_phone").show(function(){return eqCenter();});
            }
        });

        $("#phone").change(function() {
            var tmp = $(this).val().replace(/[^0-9]/g, '');
            if (tmp.length == 0)
            {
                $("#err_phone").text("Не указан номер телефона");
            }
            if (tmp.length < 11)
            {
                $("#err_phone").show(function(){return eqCenter();});
            }
            if (tmp.length == 11)
            {
                $("#err_phone").hide(function(){return eqCenter();});
            }
        });

        $("#email").keyup(function() {
            var tmp="";
            tmp = $(this).val().replace(/[^-a-zA-Z0-9@_\.]/g, '');
            if (tmp != $(this).val())
            {
                $(this).val(tmp);
            }
            $("#err_email").hide(function(){return eqCenter();});
        });

        function isEmail (email, strict)
        {
            if ( !strict ) email = email.replace(/^\s+|\s+$/g, '');
            return (/^([a-z0-9_\-]+\.)*[a-z0-9_\-]+@([a-z0-9][a-z0-9\-]*[a-z0-9]\.)+[a-z]{2,4}$/i).test(email);
        }

        $("#email").change(function() {
            $("#err_email").text("Неверно указана электропочта");
            if ($(this).val().length > 0)
            {
                if (isEmail($(this).val()))
                {
                    $("#err_email").hide(function(){return eqCenter();});
                }
                else
                {
                    $("#err_email").show(function(){return eqCenter();});
                }
            }
        });

        function check_zakaz()
        {
            var err = 0;
            if ($("#phone").val().replace(/[^0-9]/g, '').length!=11) err++;
            if ($("#email").val().length > 0) if (!isEmail($("#email").val())) err++;
            if ($("#get_zakaz").val() == "delivery") if ($("#address").val().length < 5) err++;
            if ($("#time").val().length < 2) err++;

            if (err == 0)
            {
                $("#continue_z").attr("disabled", "");
            }
            else
            {
                $("#continue_z").attr("disabled", "disabled");
            }
        }

        $("#form_zakaz").each(function() {
            return check_zakaz();
        });

        $("#form_zakaz").keyup(function() {
            return check_zakaz();
        });

        $("#form_zakaz").change(function() {
            return check_zakaz();
        });


        $("#z_sum_sale").each(function() {
            var sum = $("#z_sum").text();
            var sign = $("#z_sign").text();

            // делаем скидку 5%
            var sum_sale = sum*0.95;
            var txt = sum_sale + " " + sign;
            $(this).text(txt);
            $("#post_sum").val(sum);
            $("#post_sum_sale").val(sum_sale);
            $("#post_sign").val(sign);
        });

        // конец if оформления заказа
    }

});