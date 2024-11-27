</style>
<style>
    body{
            display: flex;
            flex-direction: column;
        }
    #body2 {
        display: flex;
        flex-direction: row;
        justify-content: center;
        align-items: center;
        height: 90vh;
        margin: 0;
        background: linear-gradient(135deg, #1f1f1f, #3b3b3b);
        color: #e4e4e4;
    }

    form {
        background: rgba(255, 255, 255, 0.1);
        border-radius: 15px;
        padding: 30px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
        max-width: 400px;
        width: 100%;
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    form label {
        font-weight: bold;
        margin-bottom: 5px;
    }

    form input {
        width: 100%;
        padding: 10px;
        border-radius: 8px;
        border: none;
        outline: none;
        font-size: 16px;
        color: #333;
    }

    form input:focus {
        border: 2px solid #1f7a8c;
    }

    #connexion {
        background-color: #1f7a8c;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 8px;
        font-size: 18px;
        font-weight: bold;
        cursor: pointer;
        transition: background-color 0.3s;
        font-family: "quantico", "regular";
    }

    #connexion:hover {
        background-color: #166270;
    }

    .alert {
        color: #ff6b6b;
        font-weight: bold;
        text-align: center;
    }

    #noms {
        display: flex;
        gap: 10px;
    }

    .nom {
        display: flex;
        flex-direction: column;
        width: 50%;
    }
    #inscription{
        color:white;
        text-align: center;
    }
</style>
</head>
<body>
    <?= view('templates/nav'); ?>
    <div id="body2">
        <form method="post" action="test/insc">
            <h1 id="inscription">Inscription</h1>
            <?= csrf_field() ?>

            <?php if (session()->getFlashdata('message')): ?>
            <div class="alert">
                <?= session()->getFlashdata('message') ?>
            </div>
        <?php endif; ?>
            
            <div id="noms">
                <div class="nom">
                    <label for="nom" class="boxNom">Nom :</label>
                    <input type="text" required name="nom" id="nom" class="boxNom">
                </div>
                <div class="nom">
                    <label for="prenom" class="boxNom">Prénom :</label>
                    <input type="text" required name="prenom" id="prenom" class="boxNom">
                </div>
            </div>
            
            <label for="email">Email :</label>
            <input type="email" required name="email" id="email">
            
            <label for="mdp">Mot de passe :</label>
            <input type="password" required minlength="8" name="mdp" id="mdp">
            
            <label for="mdpConfirm">Confirmer Mot de passe :</label>
            <input type="password" required minlength="8" name="mdpConfirm" id="mdpConfirm">
            
            <button id="connexion" type="submit">S'inscrire</button>
    </form>
</div>
<?= view('templates/footer'); ?>
</body>
</html>