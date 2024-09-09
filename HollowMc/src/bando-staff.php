<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ottieni i dati dal form
    $minecraft_account = htmlspecialchars($_POST['minecraft_account']);
    $discord_name = htmlspecialchars($_POST['discord_name']);
    $minecraft_name = htmlspecialchars($_POST['minecraft_name']);
    $age = htmlspecialchars($_POST['age']);
    $staff_type = htmlspecialchars($_POST['staff_type']);
    $why_staff = htmlspecialchars($_POST['why_staff']);
    $activity = htmlspecialchars($_POST['activity']);
    $extra = htmlspecialchars($_POST['extra']);

    // Inizializza il contenuto HTML
    $data = <<<HTML
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Candidatura Staff</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #111;
            color: #eee;
            margin: 0;
            padding: 0;
            min-height: 100vh; /* Assicura che l'altezza copra tutta la vista */
            display: flex;
            justify-content: center;
            align-items: center;
        }
        h1 {
            color: #f39c12;
            text-align: center;
            padding: 20px;
        }
        .container {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
            background-color: #222;
            border-radius: 8px;
        }
        p {
            margin: 10px 0;
        }
        strong {
            color: #f39c12;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Candidatura Staff</h1>
        <p><strong>Nome Discord:</strong> $discord_name</p>
        <p><strong>Nome Minecraft:</strong> $minecraft_name</p>
        <p><strong>Account Minecraft:</strong> $minecraft_account</p>
        <p><strong>Età:</strong> $age</p>
        <p><strong>Tipo di Staffer:</strong> $staff_type</p>
        <p><strong>Perché vuoi diventare staffer:</strong> $why_staff</p>
        <p><strong>Attività:</strong> $activity</p>
        <p><strong>Cosa pensi di avere in più:</strong> $extra</p>
    </div>
</body>
</html>
HTML;

    // Crea la directory se non esiste
    $directory = 'candidature';
    if (!is_dir($directory)) {
        mkdir($directory, 0777, true);
    }

    // Genera il nome del file
    $file_name = "candidature-staff-$discord_name.html";
    $file_path = "$directory/$file_name";

    // Controlla se il file esiste già prima di salvarlo
    if (!file_exists($file_path)) {
        // Salva il contenuto HTML nel file
        file_put_contents($file_path, $data, LOCK_EX);
    }

    // Invio dei dati a Discord tramite una Webhook
    $webhook_url = "https://discord.com/api/webhooks/1280962980531671153/0Bc7Vs-TUulGIvizeav60Y6xp25G8_DrqoVILjirxfzHlGoks29RdlRb-3jq5VVDjcuq"; // Inserisci qui il tuo URL della webhook
    $message = [
        "content" => "",
        "embeds" => [
            [
                "title" => "Nuova Candidatura Staff",
                "color" => hexdec("f39c12"),
                "fields" => [
                    ["name" => "**__Nome Discord__**", "value" => $discord_name, "inline" => true],
                    ["name" => "**__Nome Minecraft__**", "value" => $minecraft_name, "inline" => true],
                    ["name" => "**__Account Minecraft__**", "value" => $minecraft_account, "inline" => true],
                    ["name" => "**__Età__**", "value" => $age, "inline" => true],
                    ["name" => "**__Tipo di Staffer__**", "value" => $staff_type, "inline" => true],
                    ["name" => "**__Perché vuoi diventare staffer__**", "value" => $why_staff, "inline" => true],
                    ["name" => "**__Attività__**", "value" => $activity, "inline" => true],
                    ["name" => "**__Cosa pensi di avere in più__**", "value" => $extra, "inline" => true]
                ]
            ]
        ]
    ];

    $json_data = json_encode($message);

    $ch = curl_init($webhook_url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    $response = curl_exec($ch);
    curl_close($ch);

    // Mostra un messaggio di successo con un link al file creato
    echo <<<HTML
    <style>
        body {
           background: #222; 
           color: #fff;
        }

        a{
            color: #fff;
            text-decoration: none;
            font-style: italic;
        }
    </style>

    <div style="font-family: Arial, sans-serif; text-align: center; padding: 20px; background-color: #222; color: #eee; border-radius: 8px; margin: 50px auto; width: 50%; box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.5);">
        <div style="font-size: 50px; margin-bottom: 20px;">
            ✅ <!-- Emoji checkmark -->
        </div>

        <h1 style="color: #f39c12; font-weight: Bold;">Per Completare la tua candidatura apri un Ticket! <a target="_blank" href="https://discord.com/channels/1211782052022718474/1213151440831250462">Clicca Qui!</a> </h1>

        <h2 style="color: #f39c12;">Candidatura inviata con successo!</h2>
        <p><a href='$file_path' style="color: #f39c12; text-decoration: none; font-weight: bold;">Visualizza il tuo file</a></p>
    </div>
HTML;
}
?>
