<style>
    body {
        display: flex;
        flex-direction: column;
        align-items: center;
        color:white;
    }
    #home {
        display: flex;
        flex-direction: column;
        align-items: center;
        width: 100%;
        flex:90%;
    }
</style>
</head>
<body>
    <?= view('templates/nav'); ?>
    <div id="home">
    <?php 
        $session = session();
        $nom = $session->get("sessionConnexion");
            $role = $session->get("sessionRole");
            echo "<h1>Bienvenue à l'interface de contrôle</h1>";
            if ($nom)
            {
                echo "Accédez aux données dans la page utilisateur.";
            }
            else{
                echo"<h2>Connectez-vous pour pouvoir accéder aux données.</h2>";
            }
    ?>

    </div>
    <?= view('templates/footer'); ?>
</body>
</html>
