<meta charset="UTF-8">
    <title>Détections pendant les périodes d'activation</title>
    <style>
        /* Styles généraux pour une apparence moderne */
        body {
            display: flex;
            flex-direction: column;
            align-items: center;
            background-color: #f4f4f4;
            margin: 0px;
        }

        #contentData{
            display:flex;
            flex-direction: column;
            flex: 90%;
            width:100%;
            padding-left: 5%;
            padding-right: 5%;
        }

        h1 {
            text-align: center;
        }

        /* Styles pour le détail entier */
        details {
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            overflow: hidden;
            background-color: #fff; /* Couleur de fond par défaut */
            color: black; /* Texte en noir */
        }

        /* Arrière-plan légèrement vert si aucune détection, légèrement rouge s'il y a des détections */
        .no-detections {
            background-color: #e6ffe6; /* Vert pâle */
        }

        .has-detections {
            background-color: #ffe6e6; /* Rouge pâle */
        }

        summary {
            cursor: pointer;
            padding: 15px;
            font-size: 16px;
            position: relative;
            transition: background-color 0.3s ease;
        }

        /* Accentuation au survol */
        summary:hover {
            background-color: #e0e0e0;
        }

        /* Styles pour le contenu interne */
        .content {
            padding: 15px;
        }

        /* Styles pour le tableau */
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 0;
        }

        table th, table td {
            padding: 10px;
            text-align: left;
        }
        table tr{
            background-color: #fc9d9d;
        }
        table tr:nth-child(even) {
            background-color: #ffe6e6;
        }

        table th {
            background-color: #fc9d9d;
            border-bottom: 1px solid #ddd;
        }

        /* Indicateurs de flèche pour les éléments details */
        summary::after {
            content: '\25BC'; /* Flèche vers le bas */
            position: absolute;
            right: 20px;
            font-size: 12px;
        }

        details[open] summary::after {
            content: '\25B2'; /* Flèche vers le haut */
        }

        /* Style pour le message lorsqu'il n'y a aucune détection */
        .message {
            font-style: italic;
            color: black;
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

        echo '<div class="content">'; // Conteneur pour le contenu interne

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

        echo '</div>'; // Fin du conteneur de contenu
        echo '</details>';
    }
    ?>
</div>

</body>
</html>