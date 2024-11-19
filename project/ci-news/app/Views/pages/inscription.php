</style>
<style>
    body {
        display: flex;
        flex-direction: column;
        align-items: center;
        margin:0;
    }
    form {
        flex: 90%;
        width: 100%;
    }
</style>
</head>
<body>
    <?= view('templates/nav'); ?>
    <form method="post" action="test/insc" >
        <?= csrf_field() ?>

        <p id="erreur"><?php echo session()->getFlashdata('message') ?></p>
        <div id="noms">
            <div class="nom">
                <label for="nom" class="boxNom">Nom : </label>
                <input type="text" required name="nom" id="nom" class="boxNom">
            </div>
            <div class="nom">
                <label for="prenom" class="boxNom">Prénom : </label>
                <input type="text" required name="prenom" id="prenom" class="boxNom">
            </div>
        </div>
        <label for="email">Email : </label>
        <input type="email" required name="email" id="email">
        <label for="mdp">Mot de passe : </label>
        <input type="password" required minlength="8" name="mdp" id="mdp">
        <label for="mdpConfirm">Confirmer Mot de passe : </label>
        <input type="password" required minlength="8" name="mdpConfirm" id="mdpConfirm">
        <button id="connexion" type="submit">S'inscrire</button>
    </form>
</body>
</html>