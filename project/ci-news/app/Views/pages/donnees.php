<meta charset="UTF-8">
    <title>Détections pendant les périodes d'activation</title>
    <style>
        body {
            display: flex;
            flex-direction: column;
            align-items: center;
            background: linear-gradient(135deg, #1f1f1f, #3b3b3b);
            margin: 0;
            color: #e4e4e4;
        }

        #contentData {
            width: 100%;
            height: 100%;
            padding: 0 5vw;
        }

        h1 {
            text-align: center;
            color: #e4e4e4;
        }

        details {
            margin-bottom: 10px;
            border: 1px solid #444;
            border-radius: 5px;
            overflow: hidden;
            background-color: rgba(255, 255, 255, 0.1);
            color: #e4e4e4;
        }


        .no-detections {
            background-color: rgba(46, 125, 50, 0.2);
        }

        .has-detections {
            background-color: rgba(183, 28, 28, 0.2);
        }

        summary {
            cursor: pointer;
            padding: 15px;
            font-size: 16px;
            position: relative;
            transition: background-color 0.3s ease;
        }

        summary:hover {
            background-color: rgba(255, 255, 255, 0.2);
        }

        .content {
            padding: 15px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 0;
        }

        table th, table td {
            padding: 10px;
            text-align: left;
            color: #e4e4e4;
        }

        table tr {
            background-color: rgba(183, 28, 28, 0.2);
        }

        table tr:nth-child(even) {
            background-color: rgba(183, 28, 28, 0.1);
        }

        table th {
            background-color: rgba(183, 28, 28, 0.3);
            border-bottom: 1px solid #ddd;
        }

        summary::after {
            content: '\25BC';
            position: absolute;
            right: 20px;
            font-size: 12px;
        }

        details[open] summary::after {
            content: '\25B2';
        }

        .message {
            font-style: italic;
            color: #e4e4e4;
        }
    </style>
</head>
<body>
<?= view('templates/nav'); ?>
<div id="contentData">

    <h1>Détections pendant les périodes d'activation</h1>

    <?php
    $db = db_connect();

    // Récupérer toutes les activations/désactivations ordonnées par temps
    $builder = $db->table('tblActivation');
    $builder->select('*');
    $builder->orderBy('temps', 'ASC');
    $query = $builder->get();
    $activations = $query->getResultArray();

    // Construire les périodes d'activation
    $activationPeriods = [];
    $currentActivationStart = null;

    foreach ($activations as $row) {
        if ($row['OnOff'] == 1) { // Activé
            if ($currentActivationStart === null) {
                $currentActivationStart = $row['temps'];
            }
        } elseif ($row['OnOff'] == 0) { // Désactivé
            if ($currentActivationStart !== null) {
                $activationPeriods[] = [
                    'start' => $currentActivationStart,
                    'end' => $row['temps']
                ];
                $currentActivationStart = null;
            }
        }
    }

    // Si le système est toujours activé à la fin
    if ($currentActivationStart !== null) {
        $activationPeriods[] = [
            'start' => $currentActivationStart,
            'end' => date('Y-m-d H:i:s') // Vous pouvez définir une date maximale ici
        ];
    }

    // Afficher les périodes d'activation avec des sections ouvertes par défaut
    foreach ($activationPeriods as $index => $period) {
        $start = $period['start'];
        $end = $period['end'];

        // Récupérer les détections pour cette période
        $builder = $db->table('tblDetection');
        $builder->select('*');
        $builder->where('temps >=', $start);
        $builder->where('temps <=', $end);
        $query = $builder->get();
        $detections = $query->getResultArray();

        // Déterminer la classe CSS en fonction des détections
        $class = empty($detections) ? 'no-detections' : 'has-detections';

        echo '<details class="' . $class . '">'; // Sections ouvertes par défaut
        echo '<summary>Période d\'activation du ' . $start . ' au ' . $end . '</summary>';

        echo '<div class="content">';

        if (!empty($detections)) {
            echo '<table>';
            echo '<tr><th>Temps de détection</th></tr>';
            foreach ($detections as $detection) {
                echo '<tr><td>' . $detection['temps'] . '</td></tr>';
            }
            echo '</table>';
        } else {
            echo '<div class="message">Aucune détection pendant cette période.</div>';
        }

        echo '</div>';
        echo '</details>';
    }
    ?>
</div>

</body>
</html>