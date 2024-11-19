<style>
    header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex:10%;
        width:100%;
        background-color: #1e1e1e;
        padding-left: 50px;
        padding-right: 50px;
    }
    .navButton{
        font-weight: bold;
        text-decoration: none;
        font-size: 27px;
        transition: transform 200ms;
        color: green;
    }
    .navButton:hover{
        transform: scale(1.20);
    }
</style>
<header>
    <a class="navButton" href="pages">Home</a>
    <?php
        $session = session();
        $nom = $session->get("sessionConnexion");
        $role = $session->get("sessionRole");

        if($role == 1){
            echo '<a class="navButton" href="donnees">Espace User</a>';
            echo '<a class="navButton" href="logout">Bonjour, ' . $nom . '</a>';
        }
        if($role == 2){
            echo '<a class="navButton" href="donnees">Espace User</a>';
            echo '<a class="navButton" href="admin">Espace Admin</a>';
            echo '<a class="navButton" href="logout">Bonjour, ' . $nom . '</a>';
        }
        if($role != 1 && $role != 2) {
            echo '<a class="navButton" href="inscription">Inscription</a>';
            echo '<a class="navButton" href="connexion">Connexion</a>';
        }
    ?>
</header>