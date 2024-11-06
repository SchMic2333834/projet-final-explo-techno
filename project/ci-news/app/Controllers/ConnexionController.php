<?php
namespace App\Controllers;/*


namespace App\Controllers;

use CodeIgniter\Database\Query;

class LoginController extends BaseController {
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
                    $sql = "SELECT sel FROM tblUtilisateurs WHERE email = $email";
                    $salt = $con->query($sql);
                    $hash = \Config\Services::HashPassword($mdp, $salt);

                    $requete = "SELECT * FROM tblUtilisateurs WHERE email = ? AND mdp = ?";
                    $reponse = $con->prepare($requete);
                    if ($utilisateur = $reponse->fetch()){
                        $_SESSION["sessionConnexion"] = $utilisateur["nom"];
                        return redirect()->to("pages/accueil");
                    }

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
    */
    
use CodeIgniter\Controller;

class ConnexionController extends BaseController
{
    public function verifierInfo()
    {
        // Start the session
        $session = session();

        // Validate input
        $validation = \Config\Services::validation();
        $validation->setRules([
            'email' => 'required|valid_email',
            'mdp'   => 'required|min_length[6]',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            // Validation failed
            $session->setFlashdata('message', 'Veuillez remplir tous les champs correctement.');
            return redirect()->to('pages/inscription')->withInput();
        }

        // Retrieve sanitized input
        $email = $this->request->getPost('email');
        $mdp   = $this->request->getPost('mdp');

        $db = db_connect();

        // Use Query Builder to get the user by email
        $builder = $db->table('tblutilisateurs');
        $builder->where('email', $email);
        $query = $builder->get();
        $user  = $query->getRowArray();

        if ($user) {
            // User found, verify password
            if (password_verify($mdp, $user['mdp'])) {
                // Password is correct, set session and regenerate ID
                $session->set('sessionConnexion', $user['nom']);
                $session->regenerate();
                return redirect()->to('accueil');
            } else {
                // Incorrect password
                $session->setFlashdata('message', 'Email ou mot de passe incorrect.');
                return redirect()->to('connexion');
            }
        } else {
            // User not found
            $session->setFlashdata('message', 'Email ou mot de passe incorrect.');
            return redirect()->to('connexion');
        }
    }
}
