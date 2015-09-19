<?php
 	require_once("Rest.inc.php");
	
	class API extends REST {
	
		public $data = "";
		
		const DB_SERVER = "127.0.0.1";
		const DB_USER = "root";
		const DB_PASSWORD = "root";
		const DB = "teste";

		private $db = NULL;
		private $mysqli = NULL;
		
		public function __construct(){
			
			parent::__construct();				
			$this->dbConnect();					
			
		}
		
		private function dbConnect(){
			
			$this->mysqli = new mysqli(self::DB_SERVER, self::DB_USER, self::DB_PASSWORD, self::DB);
			
		}
		
		public function processApi(){
			
			$func = strtolower(trim(str_replace("/","",$_REQUEST['x'])));
			
			if((int)method_exists($this,$func) > 0)
				$this->$func();
			else
				$this->response('',404);
		}
				
		private function login(){
			
			if($this->get_request_method() != "POST"){
				$this->response('',406);
			}
			
			$email = $this->_request['email'];		
			$password = $this->_request['pwd'];
			
			if(!empty($email) and !empty($password)){
				if(filter_var($email, FILTER_VALIDATE_EMAIL)){
				
					$sql = "SELECT uid, name, email FROM users WHERE email = '$email' AND password = '".md5($password)."' LIMIT 1";
					
					$stmt = $this->mysqli->query($sql) or die($this->mysqli->error.__LINE__);

					if($stmt->num_rows > 0) {
						$result = $stmt->fetch_assoc();	
						
						$this->response($this->json($result), 200);
					}
					$this->response('', 204);
				}
			}
			
			$error = array('status' => "Failed", "msg" => "Email ou Senha inválidos.");
			$this->response($this->json($error), 400);
		}
		
		// Listagem de tarefas
		private function tarefas(){	
		
			if($this->get_request_method() != "GET"){
				$this->response('',406);
			}
			$sql = 'SELECT id, tarefa, descricao, prioridade FROM tarefas ORDER BY prioridade';
			
			$stmt = $this->mysqli->query($sql) or die($this->mysqli->error.__LINE__);

			if($stmt->num_rows > 0){
				$result = array();
				while($row = $stmt->fetch_assoc()){
					$result[] = $row;
				}
				$this->response($this->json($result), 200); 
			}
			$this->response('',204);
		}
		
		// Retorna uma tarefa
		private function tarefa(){
		
			if($this->get_request_method() != "GET"){
				$this->response('',406);
			}
			
			$id = (int)$this->_request['id'];
			
			if($id > 0){	
				$sql = 'SELECT id, tarefa, descricao, prioridade FROM tarefas WHERE id='.$id;
				
				$stmt = $this->mysqli->query($sql) or die($this->mysqli->error.__LINE__);
				
				if($stmt->num_rows > 0) {
					$result = $stmt->fetch_assoc();	
					$this->response($this->json($result), 200); 
				}
			}
			$this->response('',204);
		}
		
		// Insert de tarefa
		private function insertTarefa(){
		
			if($this->get_request_method() != "POST"){
				$this->response('',406);
			}

			$tarefa = json_decode(file_get_contents("php://input"),true);
			
			$column_names = array('tarefa', 'descricao', 'prioridade');
			
			$sql = "INSERT INTO tarefas(tarefa, descricao, prioridade) VALUES(\"".$tarefa['tarefa']."\", \"".$tarefa['descricao']."\", ".$tarefa['prioridade'].")";
			
			if(!empty($tarefa)){
				$stmt = $this->mysqli->query($sql) or die($this->mysqli->error.__LINE__);
				$success = array('status' => "Success", "msg" => "Tarefa gravada com sucesso.", "data" => $tarefa);
				$this->response($this->json($success),200);
			} else {
				$this->response('',204);	
			}
		}
		
		// Update de tarefa
		private function updateTarefa(){
			
			if($this->get_request_method() != "POST"){
				$this->response('',406);
			}
			
			$request = json_decode(file_get_contents("php://input"),true);
			
			$tarefa = $request['tarefa'];
			$id = $request['id'];
			
			$sql = "UPDATE tarefas SET tarefa = \"".$tarefa['tarefa']."\", descricao = \"".$tarefa['descricao']."\", prioridade = \"".$tarefa['prioridade']."\"  WHERE id=".$id;
			
			if(!empty($tarefa)){
				$stmt = $this->mysqli->query($sql) or die($this->mysqli->error.__LINE__);
				$success = array('status' => "Success", "msg" => "Tarefa ".$id." Updated Realizado.", "data" => $tarefa);
				$this->response($this->json($success),200);
			} else {
				$this->response('',204);
			}
		}
		
		private function deleteTarefa(){
			
			if($this->get_request_method() != "DELETE"){
				$this->response('',406);
			}
			
			$id = (int)$this->_request['id'];
			
			if($id > 0){				
			
				$sql = 'DELETE FROM tarefas WHERE id ='.$id;
				
				$stmt = $this->mysqli->query($sql) or die($this->mysqli->error.__LINE__);
				$success = array('status' => "Success", "msg" => "Registro excluido com sucesso.");
				$this->response($this->json($success),200);
				
			}else
				$this->response('',204);
		}
		
		private function json($data){
			if(is_array($data)){
				return json_encode($data);
			}
		}
	}
	
	$api = new API;
	$api->processApi();

