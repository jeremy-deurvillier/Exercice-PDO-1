<?php

require_once('connexion.php');

$db = dbConnect();

// Liste tous les clients
function showAllClients() {
    global $db;

    $request = $db->query('SELECT * FROM clients;');
    $ClientsList = $request->fetchAll(PDO::FETCH_ASSOC);
    $HTMLList = '';

    foreach ($ClientsList as $key => $client) {
        $HTMLList .= '<li id="allclient_' . $key . '">' . $client['firstName'] . ' ' .  $client['lastName']  . '</li>';
    }

    return $HTMLList;
}

// Liste tous les types de spectacle
function displayShowsType() {
    global $db;

    $request = $db->query('SELECT * FROM showTypes;');
    $AllShowsTypes = $request->fetchAll(PDO::FETCH_ASSOC);
    $HTMLList = '';

    foreach($AllShowsTypes as $key => $type) {
        $HTMLList .= '<li id="allShowsType_' . $type['id'] . '">' . $type['type'] . '</li>';
    }

    return $HTMLList;
}

// Liste les 20 premiers clients
function showTop20Clients() {
    global $db;

    $request = $db->query('SELECT * FROM clients LIMIT 20;');
    $ClientsList = $request->fetchAll(PDO::FETCH_ASSOC);
    $HTMLList = '';

    foreach ($ClientsList as $key => $client) {
        $HTMLList .= '<li id="top20client_' . $key . '">' . $client['firstName'] . ' ' .  $client['lastName']  . '</li>';
    }

    return $HTMLList;
}

// Liste tous les clients avec une carte de fidélité
function showClientsWithFidelityCard() {
    global $db;

    $request = $db->query('SELECT * FROM clients WHERE card <> 0;');
    $ClientsWithFidelityCard = $request->fetchAll(PDO::FETCH_ASSOC);
    $HTMLList = '';

    foreach ($ClientsWithFidelityCard as $key => $client) {
        $HTMLList .= '<li id="clientsWithFidelity_' . $key . '">' . $client['firstName'] . ' ' .  $client['lastName']  . '</li>';
    }

    return $HTMLList;
}

// Liste tous les clients dont le nom commence par la lettre "M".
function showClientsLetterMStart() {
    global $db;

    $request = $db->query('SELECT * FROM clients WHERE SUBSTRING(lastName, 1, 1) = "M" ORDER BY lastName ASC;');
    $ClientsWithFidelityCard = $request->fetchAll(PDO::FETCH_ASSOC);
    $HTMLList = '';

    foreach ($ClientsWithFidelityCard as $key => $client) {
        $HTMLList .= '<li id="clientLetterMStart_' . $key . '"><strong>Prénom </strong>: ' . $client['firstName'] . ' , <strong>Nom </Strong>: ' .  $client['lastName']  . '</li>';
    }

    return $HTMLList;
}

// Liste de tous les spectacles
function showAllSights() {
    global $db;

    $request = $db->query('SELECT * FROM shows ORDER BY title ASC;');
    $allShows = $request->fetchAll(PDO::FETCH_ASSOC);
    $HTMLList = '';

    foreach($allShows as $key => $show) {
        $HTMLList .= '<li id="show_' . $show['id'] . '">' . $show['title'] . ' par ' . $show['performer'];
        $HTMLList .= ', le ' . date('d/m/Y', strtotime($show['date'])) . ' à ' . date('H:i', strtotime($show['startTime'])) . '</li>';
    }
    
    return $HTMLList;
}

// Dernier exo !
function clientsList() {
    global $db;

    $request = $db->query('SELECT * FROM clients ORDER BY lastName ASC;');
    $allClients = $request->fetchAll(PDO::FETCH_ASSOC);
    $HTMLList = '';

    foreach ($allClients as $key => $client) {
        $HTMLList .= '<li><div id="clientsList_' . $key . '">';
        $HTMLList .= '<p><strong>Prénom </strong>: ' . $client['firstName'] . '</p>';
        $HTMLList .= '<p><strong>Nom </Strong>: ' .  $client['lastName']  . '</p>';
        $HTMLList .= '<p><strong>Date de naissance </strong>: ' . date('d/m/Y', strtotime($client['birthDate'])) . '</p>';
        $HTMLList .= '<p><strong>Carte de fidélité </strong>: ' . (($client['card'] === 1)?'Oui':'Non') . '</p>';

        if ($client['card'] === 1) $HTMLList .= '<p><strong>Numéro de carte </strong>: ' . $client['cardNumber'] . '</p>';

        $HTMLList  .= '</div></li>';
    }

    return $HTMLList;
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Exercice PDO 1</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <h1>Exercice PDO 1</h1>

    <h2>Tous les clients</h2>
    <ol><?= showAllClients(); ?></ol>

    <h2>Tous les types de spetacle</h2>
    <ol><?= displayShowsType(); ?></ol>

    <h2>20 premiers clients</h2>
    <ol><?= showTop20Clients(); ?></ol>

    <h2>Clients avec carte de fidélité</h2>
    <ol><?= showClientsWithFidelityCard(); ?></ol>

    <h2>Clients dont le nom commence par la lettre "M"</h2>
    <ul><?= showClientsLetterMStart(); ?></ul>

    <h2>Liste des spectacles</h2>
    <ul><?= showAllSights(); ?></ul>

    <h2>Liste des clients</h2>
    <ul><?= clientsList(); ?></ul>

</body>
</html>
