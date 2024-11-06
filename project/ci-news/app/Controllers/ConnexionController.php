<?php

namespace App\Controllers;

use CodeIgniter\Database\Query;

class InscriptionController extends BaseController {
    function verifierInfo(){
        if(isset($_POST["email"]) && isset($_POST["mdp"])) {
            $mdp = $_POST["mdp"];
            $email = $_POST["email"];

            $data = null;
                $con = db_connect();

        
                $reponse = $con->prepare(static function ($con) {
                    $sql = $con->query("SELECT email FROM `tblutilisateurs` WHERE email = ?");

                    return (new Query($con))->setQuery($sql);
                });

                $test = $reponse->execute($email)->getResult('array');

                if (isset($test[0])){
                    $test = $test[0]['email'];
                }

                if($email == $test){
                    return redirect()->to("pages/inscription")->with('message', "Email déjà utilisé.");
                }
                else{
                    $fullNom = $prenom . " " . $nom;
                    $salt = bin2hex(random_bytes(16));
                    $hash = \Config\Services::HashPassword($mdp, $salt);

                    $reponse = $con->prepare(static function ($con) {
                        $sql = "INSERT INTO `tblutilisateurs` VALUES (DEFAULT, ?, ?, ?, ?, ?)";
                
                        return (new Query($con))->setQuery($sql);
                    });
                        
                    $reponse->execute($fullNom, $hash, $salt, $email, 1);
                }
                $reponse->close();
                $con->close();
            }
            else{
            return redirect()->to("pages/inscription")->with('message', "Veuillez remplir tous les champs");
        } 
        return redirect()->back();
        }
        
    }
