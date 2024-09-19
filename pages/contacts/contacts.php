<?php
$contact = new ContactController();
$res = $contact->getAll();

// fazendo paginação;

//total de paginas
$items_per_page = 10;
$total_items = count($res);
$total_pages = ceil( $total_items / $items_per_page);

//obtendo pagina atual
$current_page = isset($_GET["page"]) ? (int)$_GET["page"] : 1;
if($current_page < 1){
  $current_page = 1;
}elseif($current_page > $total_pages){
   $current_page = $total_pages;
}

//items na paginak
$items_in_page = ($current_page - 1) * $items_per_page;
$current_items = array_slice($res, $items_in_page, $items_per_page);

?>