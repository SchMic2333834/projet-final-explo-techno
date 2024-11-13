<?php
namespace App\Controllers;

use CodeIgniter\Database\Query;

class TerminalController extends BaseController{
    public function command(){
        $session = session();
        $history = [];
        if($session->get("history") != null){
            $history = $session->get("history");
        }
        $con = db_connect();
        $command = "";
        if(isset($_POST["command"])){
            $command = $_POST["command"];
        }
        array_push($history, $command);
        try {
            $sql = $con->query($command); // Execute the query directly
        
            if ($sql == false) {
                array_push($history, "Error: " . $con->error());
            }
            else {
                // Check if the query returns a result set
                $result = $sql->getResultArray();
                if ($result == false) {
                    // If there are no results, show affected rows
                    $history[] = $con->affectedRows() . " rows were modified.";
                } else {
                    // If there are results, store them
                    $history = array_merge($history, $result);
                }
            }
        } catch (\Exception $e) {
            // Catch errors and store the error message
            $history[] = "Error: " . $e->getMessage();
        }
        session()->set("history", $history);
        return redirect()->back();
    }
}