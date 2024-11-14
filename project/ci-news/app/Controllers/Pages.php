<?php

namespace App\Controllers;

use CodeIgniter\Exceptions\PageNotFoundException;

class Pages extends BaseController
{
    public function index()
    {
        return view('welcome_message');
    }

    public function view(string $page = 'home')
    {
        $session = session();

        if (! is_file(APPPATH . 'Views/pages/' . $page . '.php')) {
            // Whoops, we don't have a page for that!
            throw new PageNotFoundException($page);
        }

        if($page == "admin"){
            if($session->get("sessionRole") != 2){
                return redirect("/");
            }
        }

        if($page == "donnees"){
            if($session->get("sessionRole") < 1){
                return redirect("/");
            }
        }
        

        $data['title'] = ucfirst($page); // Capitalize the first letter
        if($page == "inscription" && key_exists('message', $data) == false) {
            $data['message'] = '';
        }
        
        
        return view('templates/header', $data) 
            . view('pages/' . $page);
    }
}