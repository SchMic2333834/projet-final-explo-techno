<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
    <!-- Include your CSS files here -->
    <style>
        /* Simple styling for demonstration purposes */
        body {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .container {
            width: 100%;
            margin: 0 auto;
            display: flex;
            flex-direction: column;
            align-items: center;
            flex:90%;
        }
        .alert {
            color: red;
        }
        label, input {
            display: block;
            width: 100%;
            margin-bottom: 10px;
        }
        button {
            width: 100%;
        }
    </style>
</head>
<body>
    <?= view('templates/nav'); ?>
    <div class="container">
        <h1>Connexion</h1>

        <!-- Display any flashdata messages -->
        <?php if (session()->getFlashdata('message')): ?>
            <div class="alert">
                <?= session()->getFlashdata('message') ?>
            </div>
        <?php endif; ?>

        <!-- Display validation errors -->
        <?= \Config\Services::validation()->listErrors(); ?>

        <!-- Login Form -->
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
</body>
</html>