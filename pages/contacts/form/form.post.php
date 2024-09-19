<?php

@$data = $_POST;
@$ctt_id = $data['ctt_id'];

@$ctt_id_delete = $_GET['ctt_id'];

 if($ctt_id_delete){
     $contact = new ContactController();
     $res = $contact->delete($ctt_id_delete);
     back();
    } 


 if($ctt_id){
  //update
$contact = new ContactController();
  $res = $contact->update($ctt_id, $data);
  header("Location: /contacts");


}else{
$contact = new ContactController();
$res = $contact->create($data);
if(!$res)exit;
header("Location: /contacts");

} 

?>