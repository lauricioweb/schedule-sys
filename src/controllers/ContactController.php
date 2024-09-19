<?php
class ContactController extends controllers {
private $my;

public function __construct(){
  $this->my = new MyService();
}

//obtendo contato especifico;
public function get($ctt_id){ 
  $res = $this->my->query
    ("select * from tbcontatos where ctt_id = :ctt_id", ["ctt_id" => $ctt_id]  );
return $res;
}

//obtendo todos os contatos;
public function getAll(){

$res = $this->my->query("select * from tbcontatos 
WHERE ctt_status = 1
ORDER BY ctt_id DESC");

return $res;
}

//criando contato
public function create($data){
 $id = $this->my->insert("tbcontatos",$data);
 return $id;
}

//deletando contato
public function delete($ctt_id){
 $this->my->update("tbcontatos",["ctt_status"=>0],["ctt_id"=>$ctt_id]);
 return true;
}

//editando contato
public function update(int $ctt_id, $data){
  $res = $this->my->update("tbcontatos",$data, [
    "ctt_id" => $ctt_id
    ]);
  return $res;
}

}

?>