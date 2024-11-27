<style>
    body {
        display: flex;
        flex-direction: column;
        align-items: center;
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
    <?php 
        $session = session();
    ?>
    <div id="home">
        <h1>Raphael Harvey & Michael Schlatter Tao</h1>
        <h2>Exploration Technologique - 420KTAJQ</h2>
        <img src="../assets/bunker.webp" alt="test1" width="500" height="500">
    </div>
</body>
</html>
