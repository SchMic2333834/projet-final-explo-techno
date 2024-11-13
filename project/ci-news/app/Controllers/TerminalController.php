<?php
namespace App\Controllers;

use CodeIgniter\Database\Exceptions\DatabaseException;
use CodeIgniter\Database\Query;

class TerminalController extends BaseController{
    public function command(){
        $session = session();
        $history = [];
        if($session->get("history") != null){
            $history = $session->get("history");
        }
        $con = db_connect();
        $command = "null";
        if(isset($_POST["command"])){
            if($_POST["command"] == ""){
                $command = "null";
            }
            else{
                $command = $_POST["command"];
            }
        }
        array_push($history, $command);
        try {
            $sql = $con->query($command); // Execute the query directly
        
            if ($sql == false) {
                array_push($history, "Error: " . $con->error());
            }
            elseif($sql){
                $history[] = $con->affectedRows() . " rows were modified.";
            }
            else {
                // Check if the query returns a result set
                $result = $sql->getResultArray();
                // If there are results, store them
                $history = array_merge($history, $result);
            }
        } catch (\mysqli_sql_exception | DatabaseException $e) {
            // Catch errors and store the error message
            $history[] = "Error: " . $e->getMessage();
        } catch (\Exception $e) {
            $history[] = "Error: " . $e->getMessage();
        }
        session()->set("history", $history);
        return redirect()->back();
    }
}