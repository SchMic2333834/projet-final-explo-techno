        
    <style>
        body {
            display: flex;
            flex-direction: column;
            margin: 0px;
            overflow: hidden;
        }
        #content {
            flex-direction: column;
            display:flex;
            width: 100%;
            flex:90%;
            overflow-y: auto;
        }
        #terminal {
            border: 1px solid #444;
            padding: 10px;
            flex: 95%;
            overflow-y: auto;
            background-color: #1e1e1e;
        }
        form {
            flex: 5%;
            border-bottom: 1px solid #444;
            border-left: 1px solid #444;
            border-right: 1px solid #444;
        }
        #input {
            padding-left: 10px;
            width: 100%;
            height: 100%;
            border: none;
            background-color: #1e1e1e;
            color: #e0e0e0;
            font-family: monospace;
            outline: none;
        }
        p {
            color: #33FF00;
            margin: 0px;
        }
    </style>
</head>
<body>
    <?= view('templates/nav') ?>
    <div id="content">
        <div id="terminal">
            <?php
                $session = session();
                $history = $session->get('history');
                if (isset($history) && is_array($history)) {
                    foreach ($history as $line) {
                        if(is_array($line)) {
                            foreach ($line as $line2){
                                echo "<p>" . $line2 . "</p>";
                            }
                        }
                        else{
                            echo "<p>" . $line . "</p>";
                        }
                    }
                }
            ?>
        </div>
        <form method="post" action="command">
            <?= csrf_field() ?>
            <input id="input" type="text" name="command" autofocus placeholder="Tapez une commande..." />
        </form>
    </div>
    <?= view('templates/footer'); ?>
</body>
</html>