<?php 
class TesteController extends Controllers{
  private $my;

public function __construct()
{
  $this->my = new MyService();
}

public function get($cli_id){
  $res = @$this->my->query("SELECT * FROM tbcontatos");
  return $res;
}
}

?>