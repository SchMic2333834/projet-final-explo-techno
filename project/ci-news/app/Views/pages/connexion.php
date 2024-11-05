    body {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    header {
        display; flex;
        flex: 10%;
    }

    div {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: space-evenly;
        color: white;
        background-color: #6c5e5b;
        flex: 80%;
    }

    footer {
        display: flex;
        flex: 10%;
    }

    form{
        display: flex;
        color: white;
        font-weight: bolder;
        flex-direction: column;
        padding: 10px;
        justify-content: space-between;
        border-style:outset;
        border-width: 5px;
        border-color: #ff585d;
        height: 300px;
        width: 400px;
        padding:50px;
    }
</style>
</head>
<body>
    <header>
        <h1>testHead</h1>
    </header>
    <div>
        <h1>Test</h1>
        <form method="post" action="actions/connexion-action.php">
            <p id="erreur"><?php if(isset($_GET["message"])){ echo $_GET["message"]; }?></p>
            <label for="email">Courriel : </label>
            <input type="email" required name="email" id="email">
            <label for="mdp">Mot de passe : </label>
            <input type="password" required minlength="8" name="mdp" id="mdp">
            <label for="langue">Langue : </label>
            <select id="langue" name="langue">
                <option value="FR">Français</option>
                <option value="EN">English</option>
            </select>
            <button id="connexion" type="submit">Se connecter</button>
        </form>
    </div>
    <footer>
        <h1>testFoot</h1>
    </footer>
</body>