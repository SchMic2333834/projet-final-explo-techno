<?php
namespace App\Controllers;

use CodeIgniter\Controller;

class ConnexionController extends BaseController
{
    function addAttempt($user, $db) {
        // Increment 'tentatives' by 1
        $builder = $db->table('tblTentatives');
        $builder->where('id', $user);
        $builder->set('tentatives', 'tentatives + 1', false);
        $builder->update();
    
        // Check if attempts have reached 5
        $attempts = $this->getAttempt($user, $db);
        if ($attempts['tentatives'] == 5) {
            // Set 'bloque' to 1 and update 'derniere_tentative' to current time
            $builder->where('id', $user);
            $builder->set('bloque', 1);
            $builder->set('derniere_tentative', date('Y-m-d H:i:s'));
            $builder->update();
        }
    }
    
    function getAttempt($user, $db) {
        $builder = $db->table('tblTentatives');
        $builder->select('tentatives');
        $builder->where('id', $user);
        $query = $builder->get();
        $attempts = $query->getRowArray(); // Returns the row as an associative array
        return $attempts;
    }
    
    function getTempsBloqueRestant($user, $db) {
        $builder = $db->table('tblTentatives');
        $builder->select("TIMESTAMPDIFF(MINUTE, NOW(), DATE_ADD(derniere_tentative, INTERVAL 15 MINUTE)) AS temps_restant", false);
        $builder->where('id', $user);
        $query = $builder->get();
        $temps = $query->getRowArray();
        return $temps;
    }
    
    function resetAttempts($user, $db) {
        $builder = $db->table('tblTentatives');
        $builder->where('id', $user);
        $builder->set('bloque', 0);
        $builder->set('tentatives', 0);
        $builder->update();
    }
    
    function getBlockedEtat($user, $db) {
        $builder = $db->table('tblTentatives');
        $builder->select('bloque');
        $builder->where('id', $user);
        $query = $builder->get();
        $blocked = $query->getRowArray();
        return $blocked;
    }

    public function verifierInfo()
    {
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
    
        if (!$user) {
            // User not found
            $session->setFlashdata('message', 'Email ou mot de passe incorrect.');
            return redirect()->to('connexion');
        }
    
        // Check if user is blocked
        $blockedStatus = $this->getBlockedEtat($user['id'], $db);
        if ($blockedStatus && $blockedStatus['bloque'] == 1) {
            // Check remaining block time
            $remainingTime = $this->getTempsBloqueRestant($user['id'], $db);
            if ($remainingTime && $remainingTime['temps_restant'] <= 0) {
                $this->resetAttempts($user['id'], $db);
            } else {
                // User is still blocked
                $session->setFlashdata('message', 'Votre compte est bloqué. Veuillez réessayer plus tard.');
                return redirect()->to('connexion');
            }
        }
    
        // Get current attempt count
        $attempts = $this->getAttempt($user['id'], $db);
        if ($attempts && $attempts['tentatives'] < 5) {
            // User found and not over attempt limit
            // Retrieve salt and stored hash
            $salt = $user['sel'];        // Assuming 'sel' is the column name for salt
            $storedHash = $user['mdp'];  // Assuming 'mdp' is the column name for the hashed password
    
            // Hash the entered password with the salt
            // Ensure that HashPassword function is defined and accessible
            $hash = \Config\Services::HashPassword($mdp, $salt);
    
            // Compare the hashes
            if ($hash == $storedHash) {
                // Password is correct, set session and regenerate ID
                $this->resetAttempts($user['id'], $db);
                $session->set('sessionConnexion', $user['nom']);
                $session->set('sessionRole', $user['role_id']);
                $session->regenerate();
                return redirect()->to('accueil');
            } else {
                // Incorrect password
                $this->addAttempt($user['id'], $db);
                $session->setFlashdata('message', 'Email ou mot de passe incorrect.');
                return redirect()->to('connexion');
            }
        } else {
            // Too many attempts
            $session->setFlashdata('message', 'Vous avez dépassé le nombre de tentatives autorisées.');
            return redirect()->to('connexion');
        }
    }
}