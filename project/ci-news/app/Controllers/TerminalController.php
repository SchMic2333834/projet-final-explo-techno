<?php
namespace App\Controllers;

use CodeIgniter\Database\Query;

class TerminalController extends BaseController{
    
    private $history = [];

    public function command(){
        $session = session();
        
        $command = "";
        if(isset($_POST["command"])) {
            $command = $_POST["command"];
            array_push($this->history, $command);

            $con = db_connect();

            $reponse = $con->prepare(static function ($con, $command) {
                $sql = $con->query($command);

                return (new Query($con))->setQuery($sql);
            });

            if($reponse->hasError()){
                array_push($this->history, $reponse->getErrorMessage());
            }
            else{
                $reponse->execute();
            }

            if($reponse->_getResult() == null){
                array_push($this->history, $con->affectedRows() . " lignes ont été modifiées.");
            }
            else{
                $this->history = $reponse->_getResult();
            }

            session()->set("history", $this->history);
        }
        return view('admin');
    }
}