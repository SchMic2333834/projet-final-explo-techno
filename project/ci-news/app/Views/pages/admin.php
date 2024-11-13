        
    <style>
        body {
            margin: 0px;
        }
        #content {
            flex-direction: column;
            display:flex;
            height: 100vh;
            width: 100%;
        }
        #terminal {
            border: 1px solid #444;
            padding: 10px;
            flex: 95%;
            overflow-y: auto;
            background-color: #1e1e1e;
        }
        #input {
            flex:5%;
            padding-left: 10px;
            border: none;
            background-color: #1e1e1e;
            color: #e0e0e0;
            font-family: monospace;
            outline: none;
        }
        p {
            color: green;
        }
    </style>
</head>
<body>
    <div id="content">
        <div id="terminal">
            <?php
                $session = session();
                $history = $session->get('history');
                if (isset($history) && is_array($history)) {
                    foreach ($history as $line) {
                        if(is_array($line)) {
                            foreach ($line as $line2){
                                echo $line2 . "<br>";
                            }
                        }
                        else{
                            echo htmlspecialchars($line) . "<br>";
                        }
                    }
                }
            ?>
        </div>
        <form method="post" action="command">
            <?= csrf_field() ?>
            <input id="input" type="text" name="command" autofocus placeholder="Tapez une commande..." />
            <button type="submit">Enter</button>
        </form>
    </div>
</body>
</html>