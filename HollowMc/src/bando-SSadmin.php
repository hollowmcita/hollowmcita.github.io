<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ottieni i dati dal form
    $minecraft_name_ss = htmlspecialchars($_POST['minecraft_name_ss']);
    $discord_name_ss = htmlspecialchars($_POST['discord_name_ss']);
    $minecraft_account_ss = htmlspecialchars($_POST['minecraft_account_ss']);
    $age_ss = htmlspecialchars($_POST['age_ss']);
    $ss_experience = htmlspecialchars($_POST['ss_experience']);
    $current_staffer_ss = htmlspecialchars($_POST['current_staffer_ss']);
    $why_ss_admin = htmlspecialchars($_POST['why_ss_admin']);
    $activity_ss = htmlspecialchars($_POST['activity_ss']);
    $extra_ss = htmlspecialchars($_POST['extra_ss']);

    // Inizializza il contenuto HTML
    $data_ss = <<<HTML
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Candidatura SS Admin</title>
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
            color: #e74c3c;
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
            color: #e74c3c;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Candidatura SS Admin</h1>
        <p><strong>Nome Minecraft:</strong> $minecraft_name_ss</p>
        <p><strong>Nome Discord:</strong> $discord_name_ss</p>
        <p><strong>Account Minecraft:</strong> $minecraft_account_ss</p>
        <p><strong>Età:</strong> $age_ss</p>
        <p><strong>Esperienza SS:</strong> $ss_experience</p>
        <p><strong>Staffer attuale:</strong> $current_staffer_ss</p>
        <p><strong>Perché SS Admin:</strong> $why_ss_admin</p>
        <p><strong>Attività:</strong> $activity_ss</p>
        <p><strong>Cosa pensi di avere in più:</strong> $extra_ss</p>
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
    $file_name_ss = "candidature-ss-$discord_name_ss.html";
    $file_path_ss = "$directory/$file_name_ss";

    // Controlla se il file esiste già prima di salvarlo
    if (!file_exists($file_path_ss)) {
        // Salva il contenuto HTML nel file
        file_put_contents($file_path_ss, $data_ss, LOCK_EX);
    }

    // Invio dei dati a Discord tramite una Webhook
    $webhook_url = "https://discord.com/api/webhooks/1280962980531671153/0Bc7Vs-TUulGIvizeav60Y6xp25G8_DrqoVILjirxfzHlGoks29RdlRb-3jq5VVDjcuq"; 
    $message = [
        "content" => "",
        "embeds" => [
            [
                "title" => "Nuova Candidatura SS Admin",
                "color" => hexdec("e74c3c"),
                "fields" => [
                    ["name" => "**__Nome Minecraft__**", "value" => $minecraft_name_ss, "inline" => true],
                    ["name" => "**__Nome Discord__**", "value" => $discord_name_ss, "inline" => true],
                    ["name" => "**__Account Minecraf__**t", "value" => $minecraft_account_ss, "inline" => true],
                    ["name" => "**__Età__**", "value" => $age_ss, "inline" => true],
                    ["name" => "**__Esperienza SS__**", "value" => $ss_experience, "inline" => true],
                    ["name" => "**__Staffer attuale__**", "value" => $current_staffer_ss, "inline" => true],
                    ["name" => "**__Perché SS Admin__**", "value" => $why_ss_admin, "inline" => true],
                    ["name" => "**__Attività__**", "value" => $activity_ss, "inline" => true],
                    ["name" => "**__Cosa pensi di avere in più__**", "value" => $extra_ss, "inline" => true]
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
            ✅
        </div>

        <h1 style="color: #e74c3c; font-weight: Bold;">Per Completare la tua candidatura apri un Ticket! <a target="_blank" href="https://discord.com/channels/1211782052022718474/1213151440831250462">Clicca Qui!</a> </h1>

        <h2 style="color: #e74c3c;">Candidatura SS inviata con successo!</h2>
        <p><a href='$file_path_ss' style="color: #e74c3c; text-decoration: none; font-weight: bold;">Visualizza il tuo file</a></p>
    </div>
HTML;
}
?>
