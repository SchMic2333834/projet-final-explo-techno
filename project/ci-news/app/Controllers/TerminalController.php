<?php
namespace App\Controllers;

use CodeIgniter\Database\Query;

class TerminalController extends BaseController{
    
    private $history = [];

    public function command(){
        $session = session();
        $con = db_connect();
        $command = "";
        if(isset($_POST["command"])){
            $command = $_POST["command"];
        }
        try {
            $sql = $con->query($command); // Execute the query directly
        
            if ($sql) {
                // Check if the query returns a result set
                $result = $sql->getResultArray();
                if (empty($result)) {
                    // If there are no results, show affected rows
                    $this->history[] = $con->affectedRows() . " rows were modified.";
                } else {
                    // If there are results, store them
                    $this->history = array_merge($this->history, $result);
                }
            }
        } catch (\Exception $e) {
            // Catch errors and store the error message
            $this->history[] = "Error: " . $e->getMessage();
        }
        session()->set("history", $this->history);
        return redirect()->back();
    }
}