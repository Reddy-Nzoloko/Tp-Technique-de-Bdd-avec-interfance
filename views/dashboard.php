<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Gestion Hospitalière</title>
</head>
<body class="bg-gray-100 p-10">
    <div class="max-w-6xl mx-auto">
        <h1 class="text-3xl font-bold text-gray-800 mb-8">Structure de l'Organisation</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <?php foreach ($data as $row): ?>
            <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-blue-500">
                <div class="mb-2">
                    <span class="text-xs font-bold text-blue-600 uppercase">Organisation</span>
                    <h2 class="text-xl font-bold"><?= $row['nomOrganisation'] ?></h2>
                </div>
                <div class="mb-4">
                    <span class="text-xs font-bold text-gray-400 uppercase">Site</span>
                    <p class="text-gray-700 font-medium"><?= $row['nomSite'] ?? 'Aucun site' ?></p>
                </div>
                <div class="bg-gray-50 p-3 rounded border border-gray-200">
                    <span class="text-xs font-bold text-gray-400 uppercase">Service</span>
                    <div class="flex justify-between items-center">
                        <p class="text-gray-800"><?= $row['nomService'] ?? 'Aucun service' ?></p>
                        <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded text-xs font-mono">
                            <?= $row['codePrefixe'] ?? 'N/A' ?>
                        </span>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>