<?php
// Report all errors
error_reporting(E_ALL);
include '../impl/REST.php';

/**
 * REST API Calling
 * @author avnish
 *
 */
class API extends REST{

		const DB_SERVER = "localhost";
		const DB_USER = "root";
		const DB_PASSWORD = "root";
		const DB = "rest";

		public function __construct(){
			parent::__construct();				// Init parent contructor
			$this->dbConnect();					// Initiate Database connection
		}

		/*
		 *  Database connection 
		*/
		private function dbConnect(){
			$this->db = mysql_connect(self::DB_SERVER,self::DB_USER,self::DB_PASSWORD);
			if($this->db)
				mysql_select_db(self::DB,$this->db);
		}
		/**
		 * This method is authentigate the user and password from header 
		 * @param unknown $header
		 * @return multitype:string boolean
		 */
		private function userAuthentigation($header){
			$statusArr= array('status' => 'Failed','msg'=>'Initial Value');
			if(null==$header && empty($header)){
				$statusArr['status']=false;
				$statusArr['msg']='Not able to get the user creadentials';
				return $statusArr;
			}
			$userAuth="Basic ".base64_encode("ashish:ashish");
			//echo "Encode".base64_encode($userAuth)."Getting header from client".$header;
			if($userAuth==$header){
				$statusArr['status']='Success';
				$statusArr['msg']='Validation True';
			}else{
				$statusArr['status']='Failed';
				$statusArr['msg']='Wrong user name or password';
			}
			return $statusArr;
		}

		/**
		 * Public method for access api.
		 * This method dynmically call the method based on the query string
		 *
		 */
		public function processApi(){
			$getAllHeaderArr=getallheaders();
			$authStr=$getAllHeaderArr['Authorization'];
			$statusArr=$this->userAuthentigation($authStr);
			if($statusArr['status']=='Failed'){
				$error = array('status' => "Failed", "msg" => $statusArr['msg']);
				$this->response($this->json($error), 200);
			}
			$body=file_get_contents('php://input');
			$func = strtolower(trim(str_replace("/","",$_REQUEST['rquest'])));
			if((int)method_exists($this,$func) > 0)
				$this->$func($body);
			else
				$this->response('',404);	
		}


		/**
		 *	Encode array into JSON
		*/
		private function json($data){
			if(is_array($data)){
				return json_encode($data);
			}
		}
		/**
		 * This is test web servise method
		 * @param unknown $body
		 */
		private function helloRest($body){

			if(!empty($body)){

			}else{
			$arrayName = array('Author' =>"Ashis" ,'Message' =>"Test Hello Word in PHP REST" );
			$this->response($this->json($arrayName), 200);
		}
		}

		private function insertBooks($body){
			if(!empty($body)){
				$bodyRequest=json_decode($body);
				$query='';
				$que='';
				foreach ($bodyRequest as $key => $value) {
						$query.="$key = '$value' ,";
					
				}
				$que = rtrim($query,',');
				$sqlQuery="insert into books set $que;";
				//echo $sqlQuery;die();
				if(mysql_query($sqlQuery)){
					$error = array('status' => "Success", "msg" => "Successfully insert in to the book table");
					$this->response($this->json($error), 200);
				}else{
					$error = array('status' => "Failed", "msg" => "Not able to insert in to the book table");
					$this->response($this->json($error), 400);
				}
			}
		}

		
}

$api = new API;
$api->processApi();

?>