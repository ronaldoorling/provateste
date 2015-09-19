<?php
/* Questão 3
* Alterar a classe de conexão para que os seus parametros sejam utilizados diretamente na classe de conexão
* 
*/
namespace ProvaTeste;

use DatabaseConnection;

class MyUserClass extends DatabaseConnection
{
    public function getUserList()
    {
        $dbconn = new DatabaseConnection();
        
		$sql = 'SELECT name FROM user ORDER BY name';
		
		$results = $dbconn->query();

        return $results;
    }
}