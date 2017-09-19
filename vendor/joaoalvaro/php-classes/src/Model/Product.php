<?php	


namespace Softmake\Model;

use \Softmake\DB\Sql;
use \Softmake\Model;
use \Softmake\Mailer;

class Product extends Model{

	public static function listAll(){

		$sql = new Sql();
		return $sql->select("SELECT * FROM tb_products ORDER BY desprodutc");
	}

	public function save(){
		$sql = new Sql();
		$results = $sql->select("CALL sp_produtcs_save(:idproduct, :desprodutc, :vlprice, :vlwidht, :vlheight, :vllenght, :desurl)",
			 array(
			":idproduct"=>$this->getidproduct(),
			":desprodutc"=>$this->getdesproduct(),
			":vlprice"=>$this->getvlprice(),
			":vlwidht"=>$this->getvlprice(),
			":vlheight"=>$this->getvlheight(),
			":vllenght"=>$this->getvllenght(),
			":desurl"=>$this->getdesurl()
		));
		
		$this->setData($results[0]);

	}

	public function get($idproduct){

		$sql = new Sql();

		$results = $sql->select("SELECT * FROM tb_products WHERE idproduct = :idproduct", [
			':idproduct'=>$idproduct
		]);

		$this->setData($results[0]);
	}

	public function delete(){

		$sql = new Sql();

		$sql->query("DELETE FROM tb_products WHERE idproduct = :idproduct", [
			':idproduct'=>$this->getidproduct()
		]);

	}

}

?>