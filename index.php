<?php

//����������� ����������������� �����
require_once 'config.php';

//��������� ����� ������ ����� ������������
Page::$template = 'templates/template.php';


Router::route('menu/', function(){
    Page::$title = '���� - ����� ����';
    Page::$leftmenu = leftMenu();
    Page::$content = '����';
    Page::$basket = basket();

});


//��������� c ������������ ����������
Router::route('category/(\d+)/page/(\d+)/', function($categoryId,$page){
    Page::$title = generateTitle($categoryId).' - ����� ����';
    Page::$contentTitle = generateTitle($categoryId);
    Page::$leftmenu = leftMenu();
    Page::$content = categoryItems($categoryId,9,$page);
    Page::$basket = basket();

});

//���������
Router::route('category/(\d+)/', function($categoryId){

    Page::$title = generateTitle($categoryId).' - ����� ����';
    Page::$contentTitle = generateTitle($categoryId);
    Page::$leftmenu = leftMenu();
    Page::$content = categoryItems($categoryId,9,1);
    Page::$basket = basket();
});


//�������� ���������
Router::route('contacts', function(){
    Page::$title = '��������';
    Page::$content = '�������� ���������';
    Page::$leftmenu = leftMenu();
});

//������� ��������
Router::route('', function(){
    Page::$title = '������� ��������';
    Page::$content = '������ � ���� ���������� �� ����� ��������� ������ ��� ����� � ��� � 1899 ����. �� �������� 25 �.�. � ���������� � ��� ����� �������� ���������� ����� �� 1 �.�. ��� ��� ������ �����, �� �������� ������ ������ ���� ���������� ������ � �������� ������� ������. � �� ����� ����� ������ ��������� ��� ���� �������������� ������������ ��������� � �������. ����������� �������, ��� ��� ��������� �� ������� � �������� ������� ��� �������� �����. ������� ��� ����� ���� ���������� �������. ��-������, ������ �� ����� ������� ���� (�������) �, ������������� �� �������, ����� ������� ���� ������ � ���� �������. ��-������, ������ ������ ���� ���������� ��������� ��� ��������� ������� ���������� ������. � �������, ������ ������� � ������ ����������� ����������� - ���� ������ �������� ����� �� ������, ��������, ��������� ��� ��������� ������� �������� ����, ���������� ��� �������� ��� ����� �������� �������� �����. ��� ����������, �� ������� �������� �������� ��� ������������ ��������� � ��������� �������� ������, ����������� ��� ���������� ���������, ���� ������ ������������ ������� ��� ������������� ���������. ������ ������������� ����� ������� ������ ����� � ���� ������ ����� ������� ������������ - ������, ��������� ������� �������� ���� � ���� �� ������ ��������� ����������� �� ��� ��� ������� �����. � ����� ������, �������� ��, ������ �� ������ ����������� � �������? �����������, ������ - � ���� �������� ������ ������������ �������.
';
    Page::$leftmenu = leftMenu();
});

//��������� ������
Router::execute();

//���������� �������� �� ������� $template
Page::generate();


//�������
function basket(){
if(isset($_COOKIE['basket'])){
    $html = '';
    $allgoods = 0;
    $products = $_COOKIE['basket'];
    $split = explode(',',$products);
    foreach($split as $key=>$item){
        if(!empty($item)){
            $allgoods++;

            $splitChild = explode(':',$item);
            $html .= '<div class="item">
<div class="item_title">������ ���� � ������</div>
<div class="numerator"><a href="#"><img src="/templates/images/mines.png" width="11" height="11" /></a>&nbsp; <span id="num">'.$splitChild[1].'</span> ��. &nbsp;
<a href="#"><img src="/templates/images/plus.png" width="11" height="11" /></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="price">1580</span> ���.</div><a href="#">
<img class="del" src="/templates/images/del.png" width="23px" height="23px"  /></a>
<input type="hidden" class="del_product_id" value="'.$splitChild[0].'">
</div>


';
        }
    }
    $html .= '<input type="hidden" id="all_goods" value="'.($allgoods - 1).'">';
    return $html;
}



}

//������� ��������� title
function generateTitle($id){
    $html = '';
    $titleSecond = SQL::query("SELECT name_type,parent_id FROM product_type WHERE type_id = $id");
    $parentId = $titleSecond[0]['parent_id'];
    $titleFirst = SQL::query("SELECT name_type FROM product_type WHERE type_id = $parentId");
   // print_array($titleSecond);
    $titleCaseLower = mb_convert_case($titleSecond[0]['name_type'], MB_CASE_LOWER, "WINDOWS-1251");
    if($parentId == 0){
        $html .= $titleSecond[0]['name_type'];
    }else{
        $html .= $titleFirst[0]['name_type'].' '.$titleCaseLower;
    }
    return $html;
}

//����� ��������� + ���������
function categoryItems($category, $perPage, $page = 1){
     $i = 1; // ���-�� ������ � ������
     //������� ������ �������� �� �����
     $page = abs((int)$page);

    //������ ������� �� ��������� � ������� ���������� ������
    $productsCount = SQL::first("SELECT count(*) cnt FROM products WHERE product_type_id = $category AND visible = '1'");

    $allRows = $productsCount['cnt'];

    //������� ����� ����� �������
    $total = (int)(($allRows - 1) / $perPage) + 1;
    if($page<=0) $page = 1;
    if($page > $total) $page = $total;
    $start = $page * $perPage - $perPage;

    $products = SQL::query("SELECT * FROM products WHERE product_type_id = $category AND visible = '1' ORDER BY product_id LIMIT $start,$perPage");

    $html = '';

    $html .= '<table  cellspacing="0" cellpadding="0">';
    foreach($products as $product) {

    if($i%4 == 0 || $i == 1){
        $html .= '<tr valign="top">';

    }
    $html .= '<td align="left">';
    $html .= '<div class="product">
    <div style="margin:0 auto; width:180px;">
    <div class="price_bg"><span>'.$product['price'].'�.</span></div>
    <img src="'.$product['image'].'" width="167" height="105" />
    <div class="product_tit">'.$product['name'].'</div>
    <div class="description">'.$product['description'].'</div>
    <div id="num_'.$product['product_id'].'" style="margin:auto 0 0 0 ">
    <div class="numerator">&nbsp;<span class="decrement"><img src="/templates/images/mines.png" width="11" height="11" />&nbsp;</span> <span class="num">1</span> ��. &nbsp;<span class="increment"><img src="/templates/images/plus.png" width="11" height="11" /></span><span class="add"><a href="#'.$product['product_id'].'">� �������</a>
    <input type="hidden" class="product_id" value="'.$product['product_id'].'">
    </span></div>
    </div>
   </div>
    </div>';
        $html .= '</td>';
        if($productsCount)
        if($i%3 == 0){
            $html .= '</tr>';
            $i = 0;
        }
        $i++;
    }


    $html .= '</table>';

    if($total > 1){
        $html .= '<br /> <div class="pagination"> <div style="position:relative; top:12px;">';

        $prevPage = ($page != 1) ? "<a href='/category/$category/page/".($page -1)."/'><span><img src='/templates/images/arr_l.png' width='10' height='14' /><strong>�����</strong> </span></a>" : "";

        $nextPage = ($page != $total) ? "<a href='/category/$category/page/".($page + 1)."/'><span><strong>������</strong> <img src='/templates/images/arr_r.png' width='10' height='14' /></span></a>" : "";

        $pageLeft2 = ($page - 2 > 0) ? "<a href='/category/$category/page/".($page - 2)."/'><strong>".($page - 2)."</strong></a>" : "";
        $pageLeft1 = ($page - 1 > 0) ? "<a href='/category/$category/page/".($page - 1)."/'><strong>".($page - 1)."</strong></a>" : "";

        $pageRight2 = ($page + 2 <=$total) ? "<a href='/category/$category/page/".($page + 2)."/'><strong>".($page + 2)."</strong></a>" : "";
        $pageRight1 = ($page + 1 <=$total) ? "<a href='/category/$category/page/".($page + 1)."/'><strong>".($page + 1)."</strong></a>" : "";
        $pageactive = '<strong style="color:#b30e27">'.$page.'</strong>';

        $html .= $prevPage.' '.$pageLeft2.' '.$pageLeft1.' '.$pageactive.' '.$pageRight1.' '.$pageRight2.' '.$nextPage;

    }
    return $html;

}

//������� ��������� ����
function leftMenu(){
$html = '';
$category = array();

$menu = SQL::query("SELECT * FROM product_type ORDER BY parent_id,name_type");
    foreach($menu as $item) {
        if(!$item['parent_id']){
            $category[$item['type_id']][] = $item['name_type'];
        }
        else{
            $category[$item['parent_id']]['sub'][$item['type_id']] = $item['name_type'];
        }
    }

   // $html = print_array($category); //�����
    $html .= '<ul class="left_menu">';

    foreach($category as $key=>$item) {

        if(count($item) > 1){
            $html .= "<li><img src=\"/templates/images/li1.png\" width=\"39\" height=\"40\" alt=\"����\" /><span>$item[0]</span>";

            $html .= '<ul>';
            foreach($item['sub'] as $key => $item){

                $html .= '<li> <a href="/category/'.$key.'/">'.$item.'</a> </li>';
            }
            $html .= '</ul>';
        } else {
            $html .= "<li><img src=\"/templates/images/li1.png\" width=\"39\" height=\"40\" alt=\"����\" /><span><a href=\"/category/$key/\">$item[0]</a></span>";
        }
    }
    $html .= '</ul>';
    return $html;
}

?>