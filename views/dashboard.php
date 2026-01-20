<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <title>Dashboard Multi-Hôpital</title>
</head>
<body class="bg-gray-50 font-sans">

    <nav class="bg-indigo-700 text-white p-4 shadow-lg sticky top-0 z-40">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-xl font-bold"><i class="fas fa-hospital-user mr-2"></i> Hôpital Manager PRO</h1>
            <div class="flex gap-2">
                <button onclick="toggleModal('modalOrg')" class="bg-indigo-500 hover:bg-indigo-400 px-3 py-2 rounded text-xs transition font-bold uppercase tracking-wider">+ Organisation</button>
                <button onclick="toggleModal('modalSite')" class="bg-blue-500 hover:bg-blue-400 px-3 py-2 rounded text-xs transition font-bold uppercase tracking-wider">+ Site</button>
                <button onclick="toggleModal('modalService')" class="bg-emerald-500 hover:bg-emerald-400 px-3 py-2 rounded text-xs transition font-bold uppercase tracking-wider">+ Service</button>
            </div>
        </div>
    </nav>

    <div class="container mx-auto py-10 px-4">
        <h2 class="text-2xl font-semibold text-gray-700 mb-8">Structure de l'Etablissement</h2>

        <?php if (empty($organisations)): ?>
            <div class="bg-white p-12 rounded-xl shadow border-2 border-dashed border-gray-200 text-center">
                <i class="fas fa-sitemap text-gray-200 text-6xl mb-4"></i>
                <p class="text-gray-500 text-lg">Aucune structure configurée. Commencez par ajouter une organisation.</p>
            </div>
        <?php else: ?>
            <div class="grid grid-cols-1 gap-8">
                <?php foreach ($organisations as $org): ?>
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                        <div class="bg-gray-100 p-4 border-b flex justify-between items-center">
                            <h3 class="text-xl font-bold text-indigo-900 leading-tight">
                                <i class="fas fa-building mr-2 text-indigo-400"></i><?= htmlspecialchars($org['nom']) ?>
                            </h3>
                            <span class="text-xs bg-indigo-200 text-indigo-700 px-3 py-1 rounded-full font-bold"><?= count($org['sites']) ?> SITES</span>
                        </div>
                        <div class="p-6">
                            <?php if (empty($org['sites'])): ?>
                                <p class="text-gray-400 italic text-sm">Aucun site rattaché.</p>
                            <?php else: ?>
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                    <?php foreach ($org['sites'] as $site): ?>
                                        <div class="border rounded-lg p-4 bg-gray-50 border-gray-200">
                                            <h4 class="font-bold text-gray-800 mb-3 flex items-center">
                                                <i class="fas fa-map-marker-alt text-red-500 mr-2 text-sm"></i><?= htmlspecialchars($site['nom']) ?>
                                            </h4>
                                            <div class="space-y-2">
                                                <?php if (empty($site['services'])): ?>
                                                    <p class="text-[11px] text-gray-400">Aucun service.</p>
                                                <?php else: ?>
                                                    <?php foreach ($site['services'] as $service): ?>
                                                        <div class="flex justify-between items-center bg-white p-2 rounded border border-gray-100 text-sm shadow-sm">
                                                            <span class="text-gray-700 font-medium"><?= htmlspecialchars($service['nom']) ?></span>
                                                            <span class="text-[9px] font-mono bg-indigo-50 text-indigo-600 px-2 py-0.5 rounded border border-indigo-100 font-bold"><?= htmlspecialchars($service['code']) ?></span>
                                                        </div>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <div id="modalOrg" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50">
        <div class="bg-white rounded-xl p-6 w-full max-w-md shadow-2xl">
            <h3 class="text-xl font-bold mb-4 text-gray-800">Nouvelle Organisation</h3>
            <form method="POST" action="index.php">
                <input type="hidden" name="action" value="addOrg">
                <input type="text" name="nomOrganisation" placeholder="ex: Groupe Médical Sud" class="w-full border p-2 rounded-lg mb-4 outline-none focus:ring-2 focus:ring-indigo-500" required>
                <div class="flex justify-end gap-2">
                    <button type="button" onclick="toggleModal('modalOrg')" class="px-4 py-2 text-gray-500">Annuler</button>
                    <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-lg font-bold">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>

    <div id="modalSite" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50">
        <div class="bg-white rounded-xl p-6 w-full max-w-md shadow-2xl">
            <h3 class="text-xl font-bold mb-4 text-gray-800">Nouveau Site</h3>
            <form method="POST" action="index.php">
                <input type="hidden" name="action" value="addSite">
                <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Organisation parente</label>
                <select name="idOrganisation" class="w-full border p-2 rounded-lg mb-4" required>
                    <option value="">-- Choisir une organisation --</option>
                    <?php foreach($allOrgs as $o): ?>
                        <option value="<?= $o['idOrganisation'] ?>"><?= htmlspecialchars($o['nomOrganisation']) ?></option>
                    <?php endforeach; ?>
                </select>
                <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Nom du Site</label>
                <input type="text" name="nomSite" placeholder="ex: Pavillon A" class="w-full border p-2 rounded-lg mb-4 outline-none focus:ring-2 focus:ring-blue-500" required>
                <div class="flex justify-end gap-2">
                    <button type="button" onclick="toggleModal('modalSite')" class="px-4 py-2 text-gray-500">Annuler</button>
                    <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg font-bold">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>

    <div id="modalService" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50">
        <div class="bg-white rounded-xl p-6 w-full max-w-md shadow-2xl">
            <h3 class="text-xl font-bold mb-4 text-gray-800">Nouveau Service</h3>
            <form method="POST" action="index.php">
                <input type="hidden" name="action" value="addService">
                <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Site rattaché</label>
                <select name="idSite" class="w-full border p-2 rounded-lg mb-4" required>
                    <option value="">-- Choisir un Site --</option>
                    <?php foreach($allSites as $s): ?>
                        <option value="<?= $s['idSite'] ?>"><?= htmlspecialchars($s['nomSite']) ?></option>
                    <?php endforeach; ?>
                </select>
                <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Nom du service</label>
                <input type="text" name="nomService" placeholder="ex: Urgences" class="w-full border p-2 rounded-lg mb-4" required>
                <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Code Préfixe (Tickets)</label>
                <input type="text" name="codePrefixe" placeholder="ex: URG" class="w-full border p-2 rounded-lg mb-4" maxlength="5">
                <div class="flex justify-end gap-2">
                    <button type="button" onclick="toggleModal('modalService')" class="px-4 py-2 text-gray-500">Annuler</button>
                    <button type="submit" class="bg-emerald-600 text-white px-6 py-2 rounded-lg font-bold">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function toggleModal(id) {
            const modal = document.getElementById(id);
            modal.classList.toggle('hidden');
        }
        // Fermeture automatique en cliquant à côté de la modale
        window.onclick = function(event) {
            if (event.target.classList.contains('bg-opacity-50')) {
                event.target.classList.add('hidden');
            }
        }
    </script>
</body>
</html>