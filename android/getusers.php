<?php
/**
 * Creates Unsynced rows data as JSON
 */
include_once 'db_functions.php';
$db = new DB_Functions();
$users = $db->getUnSyncRowCount();
$a = array();
$b = array();
if ($users != false){
    while ($row = mysqli_fetch_array($users)) {
        $b["numero_intervention"] = $row["numero_intervention"];
        $b["date_visite"] = $row["date_visite"];
        $b["heure_visite"] = $row["heure_visite"];
        $b["matricule_technicien"] = $row["matricule_technicien"];
        $b["numero_client"] = $row["numero_client"];
        $b["validation"] = $row["validation"];
        array_push($a,$b);
    }
    echo json_encode($a);
}
?>