<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $minecraft_name = htmlspecialchars($_POST['minecraft_name_builder']);
    $discord_name = htmlspecialchars($_POST['discord_name_builder']);
    $age = htmlspecialchars($_POST['age_builder']);
    $minecraft_account = htmlspecialchars($_POST['minecraft_account_builder']);
    $build_style = htmlspecialchars($_POST['build_style']);
    $skill_level = htmlspecialchars($_POST['skill_level']);
    $extra = htmlspecialchars($_POST['extra_builder']);
    $previous_experience = htmlspecialchars($_POST['previous_experience']);
    $activity = htmlspecialchars($_POST['activity_builder']);

    // Inizializza il contenuto HTML
    $data = <<<HTML
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Candidatura Builder</title>
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
            color: #3498db;
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
            color: #3498db;
        }
        img {
            max-width: 100%;
            height: auto;
            border-radius: 4px;
            border: 2px solid #3498db;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Candidatura Builder</h1>
        <p><strong>Nome Minecraft:</strong> $minecraft_name</p>
        <p><strong>Nome Discord:</strong> $discord_name</p>
        <p><strong>Età:</strong> $age</p>
        <p><strong>Account:</strong> $minecraft_account</p>
        <p><strong>Stile di Costruzione:</strong> $build_style</p>
        <p><strong>Livello di Abilità:</strong> $skill_level</p>
        <p><strong>Extra:</strong> $extra</p>
        <p><strong>Esperienza Precedente:</strong> $previous_experience</p>
        <p><strong>Attività:</strong> $activity</p>
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
    $file_name = "candidature-builder-$discord_name.html";
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
                "title" => "Nuova Candidatura Builder",
                "color" => hexdec("3498db"),
                "fields" => [
                    ["name" => "**__Nome Minecraft__**", "value" => $minecraft_name, "inline" => true],
                    ["name" => "**__Nome Discord__**", "value" => $discord_name, "inline" => true],
                    ["name" => "**__Età__**", "value" => $age, "inline" => true],
                    ["name" => "**__Account Minecraft__**", "value" => $minecraft_account, "inline" => true],
                    ["name" => "**__Stile di Costruzione__**", "value" => $build_style, "inline" => true],
                    ["name" => "**__Livello di Abilità__**", "value" => $skill_level, "inline" => true],
                    ["name" => "**__Esperienza Precedente__**", "value" => $previous_experience, "inline" => true],
                    ["name" => "**__Attività__**", "value" => $activity, "inline" => true],
                    ["name" => "**__Extra__**", "value" => $extra, "inline" => true]
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

    // Mostra un messaggio di successo
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

    <div style="font-family: Arial, sans-serif; text-align: center; padding: 20px; background-color: #111; color: #eee; border-radius: 8px; margin: 50px auto; width: 50%; box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.5);">
        <div style="font-size: 50px; margin-bottom: 20px;">
            ✅ <!-- Emoji checkmark -->
        </div>
        <h1 style="color: #e74c3c; font-weight: Bold;">Per Completare la tua candidatura apri un Ticket! <a target="_blank" href="https://discord.com/channels/1211782052022718474/1213151440831250462">Clicca Qui!</a> </h1> <br>
        <h2 style="color: #3498db;">Candidatura inviata con successo!</h2>
        <p><a href='$file_path' style="color: #3498db; text-decoration: none; font-weight: bold;">Visualizza il tuo file</a></p>
    </div>
HTML;
}
?>
