<?php

namespace App\Controllers;

use CodeIgniter\Database\Query;
use CodeIgniter\I18n\Time;

class InscriptionController extends BaseController {
    /*function creerCompte($email, $mdp, $nom){
        include "../Shared/hash.php";

        $salt = bin2hex(random_bytes(16));
        $con = db_connect();

        $reponse = $con->prepare(static function ($con) {
            $sql = "INSERT INTO tblUtilisateur VALUES (DEFAULT, ?, ?, ?, ?, ?)";
    
            return (new Query($con))->setQuery($sql);
        });
            
        $reponse->execute([$nom, HashPassword($mdp, $salt), $salt, $email, 1]);
        $reponse->close();
        $con->close();
    }

    function enregistrerInfos($email, $mdp, $prenom, $nom){
        $con = db_connect();

        
        $reponse = $con->prepare(static function ($con) {
            $sql = $con->query("SELECT email FROM tblUtilisateur WHERE email = ?");

            return (new Query($con))->setQuery($sql);
        });

        $reponse->execute([$email]);

        if($email == $reponse->_getResult()){
            header("Location: ../inscription.php?message=Email déjà utilisé.");
        }
        else{
            $fullNom = $prenom . " " . $nom;
            creerCompte($email, $mdp, $fullNom);
        }
        $reponse->close();
        $con->close();
    }*/

    function verifierInfo(){
        if(isset($_POST["email"]) && isset($_POST["mdp"]) && isset($_POST["mdpConfirm"]) && isset($_POST["prenom"]) && isset($_POST["nom"])) {
            $mdp2 = $_POST["mdpConfirm"];
            $mdp = $_POST["mdp"];
            $email = $_POST["email"];
            $prenom = $_POST["prenom"];
            $nom = $_POST["nom"];

            $data = null;
    
            if($mdp == $mdp2){
                $con = db_connect();

        
                $reponse = $con->prepare(static function ($con) {
                    $sql = $con->query("SELECT email FROM `tblutilisateurs` WHERE email = ?");

                    return (new Query($con))->setQuery($sql);
                });

                $test = $reponse->execute($email)->getResult('array');

                if(isset($test[0])){
                    $test = $test[0]['email'];
                }

                if($email == $test){
                    return redirect()->to("inscription")->with('message', "Email déjà utilisé.");
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
                    $userId = $con->insertID();

                $tentativesData = [
                    'id' => $userId,
                    'derniere_tentative' => Time::now(),
                    'tentatives' => 0,
                    'bloque' => 0,
                ];
                $con->table('tblTentatives')->insert($tentativesData);
            }
                $reponse->close();
                $con->close();
            }
            else{
                return redirect()->to("/inscription")->with('message', "Les mots de passe entrés ne concordent pas.");
            }
        }
        elseif(isset($_POST["email"]) && isset($_POST["mdp"]) && !isset($_POST["mdpConfirm"])){
            return redirect()->to("inscription")->with('message', "Veuillez confirmer votre mot de passe..");
        }
        else{
            return redirect()->to("inscription")->with('message', "Veuillez remplir tous les champs");
        } 
        return redirect()->to("accueil");
    }
}