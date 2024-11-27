<style>
    header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex: 10%;
        width: 100%;
        height: 7vh;
        background-color: #1e1e1e;
        padding-left: 50px;
        padding-right: 50px;
    }

    .navLeft {
        display: flex;
        flex-direction: row;
        gap: 50px;
    }

    .navRight {
        display: flex;
        gap: 50px;
    }

    .navButton {
        font-weight: bold;
        text-decoration: none;
        font-size: 27px;
        transition: transform 200ms;
        color: #33FF00;
    }

    .navButton:hover {
        transform: scale(1.20);
    }

    #bonjour{
        font-weight: bold;
        text-decoration: none;
        font-size: 27px;
        color: white;
    }
</style>
<header>
    <div class="navLeft">
        <a class="navButton" href="accueil">Home</a>
        <?php
            $session = session();
            $nom = $session->get("sessionConnexion");
            $role = $session->get("sessionRole");
            if ($nom)
            {
                echo '<a id="bonjour">Bonjour, '.$nom.'</a>';
            }
        ?>
    </div>
    <div class="navRight">
        <?php
        if ($role == 1) {
            echo '<a class="navButton" href="donnees">Espace Utilisateur</a>';
            echo '<a class="navButton" href="logout">Déconnexion</a>';
        }
        if ($role == 2) {
            echo '<a class="navButton" href="donnees">Espace Utilisateur</a>';
            echo '<a class="navButton" href="admin">Espace Admin</a>';
            echo '<a class="navButton" href="logout">Déconnexion</a>';
        }
        if ($role != 1 && $role != 2) {
            echo '<a class="navButton" href="inscription">Inscription</a>';
            echo '<a class="navButton" href="connexion">Connexion</a>';
        }
        ?>
    </div>
</header>