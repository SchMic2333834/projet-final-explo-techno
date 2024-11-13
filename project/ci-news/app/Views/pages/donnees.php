</style>
</head>
<h1>Tableaux des détections et Activations</h1>
<?php
use App\Controllers\DonneesController;
$db = db_connect();

        // Use Query Builder to get the 'temps' column from 'tblDetection' table
$builder = $db->table('tblDetection');
$builder->select('temps');
$query = $builder->get();
$data = $query->getResultArray(); // Get all rows as an array of arrays
?>
<table>
    <tr>
        <th>Temps de détection</th>
    </tr>
    
    <?php
    foreach ($data as $row) {
        echo "<tr><td>" . $row['temps'] . "</td></tr>";
    }

    ?>
    
</table>
<?php
$db = db_connect();

// Use Query Builder to get the 'temps' column from 'tblDetection' table
$builder = $db->table('tblActivation');
$builder->select('*');
$query = $builder->get();
$data = $query->getResultArray(); // Get all rows as an array of arrays
?>
<table>
    <tr>
        <th>Activations</th>
    </tr>
    <?php
    foreach ($data as $row) {
        $OnOff;
        if ($row['OnOff'] == 0)
        {
            $OnOff = 'Désactivé';
        }
        else
        {
            $OnOff = 'Activé';
        }
        echo '<tr><td>'. $row['temps'] .'</td><td>' . $OnOff . '</td></tr>';
    }
    ?>
</table>

