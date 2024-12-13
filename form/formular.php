<?php
// PHP logika pro kontaktní formulář
$errors = [];
$debugOutput = "";

// Kontaktní formulář - Zpracování POST požadavku
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $message = trim($_POST['message']);

    // Backend validace
    if (empty($name)) $errors[] = "Jméno je povinné.";
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Neplatný email.";
    if (empty($message)) $errors[] = "Zpráva je povinná.";

    // Pokud nejsou chyby, připravíme debug výstup
    if (empty($errors)) {
        $debugOutput = "Jméno: $name<br>Email: $email<br>Zpráva: $message";
    }
}

// PHP logika pro filtraci článků pomocí GET
$articles = [
    ["title" => "Novinky ze světa techniky", "category" => "Technika"],
    ["title" => "další novinky z techniky", "category" => "Technika"],
    ["title" => "krasne dobre rano", "category" => "Technika"],
    ["title" => "Recept na čokoládový dort", "category" => "Gastronomie"],
    ["title" => "Jak na efektivní cvičení", "category" => "Sport"],
    ["title" => "nikoho nezajima sport", "category" => "Sport"],
    ["title" => "zatim jsem neviděl travu", "category" => "Sport"],
    ["title" => "CS2 Major Shanghai!!", "category" => "Sport"],
    ["title" => "Tipy na podzimní dovolenou", "category" => "Cestování"]
];

// Získání kategorie z GET požadavku pro filtraci
$selectedCategory = isset($_GET['category']) ? $_GET['category'] : "";

// Filtrace článků podle zvolené kategorie
$filteredArticles = array_filter($articles, function ($article) use ($selectedCategory) {
    return $selectedCategory === "" || $article["category"] === $selectedCategory;
});

// Dostupné kategorie pro filtraci
$categories = array_unique(array_column($articles, "category"));
?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kontaktní formulář a filtrace článků</title>
    <style>
        /* Základní styling */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 20px;
        }
        h1 {
            color: #333;
            text-align: center;
        }
        form {
            background-color: #ffffff;
            padding: 20px;
            margin-bottom: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            margin: auto;
        }
        label {
            font-weight: bold;
        }
        input, textarea, select {
            width: 100%;
            padding: 8px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
        .error {
            color: red;
            font-weight: bold;
        }
        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        th, td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .alert {
            background-color: #f8d7da;
            padding: 10px;
            margin-top: 20px;
            border-radius: 4px;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>
    <script>
        // Frontend validace formuláře
        function validateForm() {
            const name = document.getElementById("name").value;
            const email = document.getElementById("email").value;
            const message = document.getElementById("message").value;
            if (name === "" || email === "" || message === "") {
                alert("Vyplňte všechna pole!");
                return false;
            }
            return true;
        }
    </script>
</head>
<body>
    <h1>Kontaktní formulář</h1>

    <!-- Zobrazení chyb z backend validace -->
    <?php if (!empty($errors)): ?>
        <div class="alert">
            <?php foreach ($errors as $error): ?>
                <p class="error"><?= htmlspecialchars($error) ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <!-- Formulář pro odeslání kontaktu -->
    <form method="POST" onsubmit="return validateForm()">
        <label for="name">Jméno:</label>
        <input type="text" id="name" name="name" value="<?= htmlspecialchars($_POST['name'] ?? '') ?>"><br>
        
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"><br>
        
        <label for="message">Zpráva:</label>
        <textarea id="message" name="message"><?= htmlspecialchars($_POST['message'] ?? '') ?></textarea><br>
        
        <button type="submit">Odeslat</button>
    </form>

    <!-- Debug výstup pro odeslaný formulář -->
    <?php if (!empty($debugOutput)): ?>
        <h2>Debug Výstup:</h2>
        <div><?= $debugOutput ?></div>
    <?php endif; ?>

    <hr>

    <h1>Filtrace článků</h1>
    <!-- Filtrační formulář pro články -->
    <form method="GET">
        <label for="category">Vyberte kategorii:</label>
        <select id="category" name="category">
            <option value="">-- Všechny --</option>
            <?php foreach ($categories as $category): ?>
                <option value="<?= htmlspecialchars($category) ?>" <?= $selectedCategory === $category ? "selected" : "" ?>>
                    <?= htmlspecialchars($category) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <button type="submit">Filtrovat</button>
    </form>

    <h2>Výsledky filtrace:</h2>
    <!-- Tabulka pro výpis článků -->
    <table>
        <thead>
            <tr>
                <th>Název článku</th>
                <th>Kategorie</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($filteredArticles)): ?>
                <tr>
                    <td colspan="2">Žádné články k zobrazení.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($filteredArticles as $article): ?>
                    <tr>
                        <td><?= htmlspecialchars($article["title"]) ?></td>
                        <td><?= htmlspecialchars($article["category"]) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>