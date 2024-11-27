<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
    <style>
        body{
            display: flex;
            flex-direction: column;
        }
        #body2 {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 90vh;
    margin: 0;
    background: linear-gradient(135deg, #1f1f1f, #3b3b3b);
    color: #e4e4e4;
}

.container {
    background: rgba(255, 255, 255, 0.1);
    border-radius: 15px;
    padding: 30px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
    max-width: 400px;
    width: 100%;
    display: flex;
    flex-direction: column;
    gap: 15px;
    text-align: center;
}

.container h1 {
    margin-bottom: 20px;
    color: white;
}

.container label {
    font-weight: bold;
    margin-bottom: 5px;
    text-align: left;
}

.container input {
    width: 95%;
    padding: 10px;
    border-radius: 8px;
    margin: 10px;
    border: none;
    outline: none;
    font-size: 16px;
    color: #333;
}

.container input:focus {
    border: 2px solid #1f7a8c;
}

.container button {
    background-color: #1f7a8c;
    margin-top: 20px;
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

.container button:hover {
    background-color: #166270;
}

.alert {
    color: #ff6b6b;
    font-weight: bold;
    text-align: center;
}
    </style>
</head>
<body>
    <?= view('templates/nav'); ?>
    <div id="body2">
    <div class="container">
        <h1>Connexion</h1>

        <?php if (session()->getFlashdata('message')): ?>
            <div class="alert">
                <?= session()->getFlashdata('message') ?>
            </div>
        <?php endif; ?>

        <?= \Config\Services::validation()->listErrors(); ?>

        <form action="connexion" method="post">
            <?= csrf_field() ?>
            <div>
                <label for="email">Email :</label>
                <input type="email" name="email" value="<?= set_value('email') ?>" required>
            </div>
            <div>
                <label for="mdp">Mot de passe :</label>
                <input type="password" name="mdp" required>
            </div>
            <div>
                <button type="submit">Se connecter</button>
            </div>
        </form>
    </div>
</div>
<?= view('templates/footer'); ?>
</body>
</html>
