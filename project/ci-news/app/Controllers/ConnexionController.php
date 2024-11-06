<?php
namespace App\Controllers;

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
        $builder = $db->table('tblUtilisateurs');
        $builder->where('email', $email);
        $query = $builder->get();
        $user  = $query->getRowArray();

        if ($user) {
            // User found, retrieve salt and stored hash
            $salt = $user['sel'];        // Assuming 'sel' is the column name for salt
            $storedHash = $user['mdp'];  // Assuming 'mdp' is the column name for the hashed password

            // Hash the entered password with the salt
            $hash = \Config\Services::HashPassword($mdp, $salt);

            // Compare the hashes
            if ($hash == $storedHash) {
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