<?php

@$ctt_id = $_GET['ctt_id'];

if(!$ctt_id) exit;

@$contact = new ContactController(); 
@$res = $contact->get($ctt_id);


?>