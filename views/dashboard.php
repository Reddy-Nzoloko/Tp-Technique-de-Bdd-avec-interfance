<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <title>Dashboard Admin - Hôpital Gestion</title>
</head>
<body class="bg-gray-50 font-sans">

    <nav class="bg-indigo-700 text-white p-4 shadow-lg sticky top-0 z-40">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-xl font-bold">
                <i class="fas fa-hospital-user mr-2"></i> Hôpital Gestion <span class="text-xs bg-red-500 px-2 py-1 rounded ml-2 uppercase">Admin</span>
            </h1>
            <div class="flex gap-2">
                <button onclick="toggleModal('modalOrg')" class="bg-indigo-500 hover:bg-indigo-400 px-3 py-2 rounded text-xs transition font-bold uppercase">+ Organisation</button>
                <button onclick="toggleModal('modalSite')" class="bg-blue-500 hover:bg-blue-400 px-3 py-2 rounded text-xs transition font-bold uppercase">+ Site</button>
                <button onclick="toggleModal('modalService')" class="bg-emerald-500 hover:bg-emerald-400 px-3 py-2 rounded text-xs transition font-bold uppercase">+ Service</button>
            </div>
        </div>
    </nav>

    <div class="container mx-auto py-10 px-4">
        <h2 class="text-2xl font-semibold text-gray-700 mb-8">Structure de l'Etablissement</h2>

        <?php if (empty($organisations)): ?>
            <div class="bg-white p-12 rounded-xl shadow border-2 border-dashed border-gray-200 text-center">
                <i class="fas fa-sitemap text-gray-200 text-6xl mb-4"></i>
                <p class="text-gray-500 text-lg">Aucune structure configurée.</p>
            </div>
        <?php else: ?>
            <div class="grid grid-cols-1 gap-8">
                <?php foreach ($organisations as $idOrg => $org): ?>
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                        
                        <div class="bg-gray-100 p-4 border-b flex justify-between items-center">
                            <h3 class="text-xl font-bold text-indigo-900 flex items-center">
                                <i class="fas fa-building mr-2 text-indigo-400"></i><?= htmlspecialchars($org['nom']) ?>
                            </h3>
                            
                            <div class="flex items-center gap-4">
                                <span class="text-xs bg-indigo-200 text-indigo-700 px-3 py-1 rounded-full font-bold">
                                    <?= count($org['sites']) ?> SITES
                                </span>
                                
                                <form method="POST" action="index.php" onsubmit="return confirm('Attention ! Supprimer l\'organisation supprimera TOUS ses sites et services.');">
                                    <input type="hidden" name="action" value="deleteOrg">
                                    <input type="hidden" name="idOrganisation" value="<?= $idOrg ?>">
                                    <button type="submit" class="text-red-400 hover:text-red-600 p-2"><i class="fas fa-trash-alt"></i></button>
                                </form>
                            </div>
                        </div>

                        <div class="p-6">
                            <?php if (empty($org['sites'])): ?>
                                <p class="text-gray-400 italic text-sm">Aucun site rattaché.</p>
                            <?php else: ?>
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                    <?php foreach ($org['sites'] as $idSite => $site): ?>
                                        <div class="border rounded-lg p-4 bg-gray-50 border-gray-200 relative group">
                                            
                                            <div class="flex justify-between items-start mb-3">
                                                <h4 class="font-bold text-gray-800 flex items-center">
                                                    <i class="fas fa-map-marker-alt text-red-500 mr-2 text-sm"></i><?= htmlspecialchars($site['nom']) ?>
                                                </h4>
                                                <form method="POST" action="index.php" onsubmit="return confirm('Supprimer ce site et ses services ?');">
                                                    <input type="hidden" name="action" value="deleteSite">
                                                    <input type="hidden" name="idSite" value="<?= $idSite ?>">
                                                    <button type="submit" class="text-gray-300 hover:text-red-500 transition shadow-sm"><i class="fas fa-times-circle"></i></button>
                                                </form>
                                            </div>

                                            <div class="space-y-2">
                                                <?php if (empty($site['services'])): ?>
                                                    <p class="text-[11px] text-gray-400 italic">Aucun service.</p>
                                                <?php else: ?>
                                                    <?php foreach ($site['services'] as $service): ?>
                                                        <div class="flex justify-between items-center bg-white p-2 rounded border border-gray-100 text-sm shadow-sm">
                                                            <span class="text-gray-700"><?= htmlspecialchars($service['nom']) ?></span>
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

    <div id="modalOrg" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center p-4 z-50">
        <div class="bg-white rounded-xl p-6 w-full max-w-md shadow-2xl">
            <h3 class="text-xl font-bold mb-4">Nouvelle Organisation</h3>
            <form method="POST" action="index.php">
                <input type="hidden" name="action" value="addOrg">
                <input type="text" name="nomOrganisation" placeholder="Nom de l'organisation" class="w-full border p-2 rounded-lg mb-4" required>
                <div class="flex justify-end gap-2">
                    <button type="button" onclick="toggleModal('modalOrg')" class="px-4 py-2">Annuler</button>
                    <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-lg font-bold">Créer</button>
                </div>
            </form>
        </div>
    </div>

    <div id="modalSite" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center p-4 z-50">
        <div class="bg-white rounded-xl p-6 w-full max-w-md shadow-2xl">
            <h3 class="text-xl font-bold mb-4">Nouveau Site</h3>
            <form method="POST" action="index.php">
                <input type="hidden" name="action" value="addSite">
                <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Choisir l'organisation</label>
                <select name="idOrganisation" class="w-full border p-2 rounded-lg mb-4" required>
                    <?php foreach($allOrgs as $o): ?>
                        <option value="<?= $o['idOrganisation'] ?>"><?= htmlspecialchars($o['nomOrganisation']) ?></option>
                    <?php endforeach; ?>
                </select>
                <input type="text" name="nomSite" placeholder="Nom du Site (ex: Aile Nord)" class="w-full border p-2 rounded-lg mb-4" required>
                <div class="flex justify-end gap-2">
                    <button type="button" onclick="toggleModal('modalSite')" class="px-4 py-2">Annuler</button>
                    <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg font-bold">Créer</button>
                </div>
            </form>
        </div>
    </div>

    <div id="modalService" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center p-4 z-50">
        <div class="bg-white rounded-xl p-6 w-full max-w-md shadow-2xl">
            <h3 class="text-xl font-bold mb-4">Nouveau Service</h3>
            <form method="POST" action="index.php">
                <input type="hidden" name="action" value="addService">
                <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Choisir le Site</label>
                <select name="idSite" class="w-full border p-2 rounded-lg mb-4" required>
                    <?php foreach($allSites as $s): ?>
                        <option value="<?= $s['idSite'] ?>"><?= htmlspecialchars($s['nomSite']) ?></option>
                    <?php endforeach; ?>
                </select>
                <input type="text" name="nomService" placeholder="Nom du Service (ex: Urgences)" class="w-full border p-2 rounded-lg mb-4" required>
                <input type="text" name="codePrefixe" placeholder="Préfixe Ticket (ex: URG)" class="w-full border p-2 rounded-lg mb-4" maxlength="5">
                <div class="flex justify-end gap-2">
                    <button type="button" onclick="toggleModal('modalService')" class="px-4 py-2">Annuler</button>
                    <button type="submit" class="bg-emerald-600 text-white px-6 py-2 rounded-lg font-bold">Créer</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Fonction pour afficher/cacher les modales
        function toggleModal(id) {
            const modal = document.getElementById(id);
            if(modal) modal.classList.toggle('hidden');
        }

        // Fermeture si clic à l'extérieur de la modale
        window.onclick = function(event) {
            if (event.target.classList.contains('bg-black/50')) {
                event.target.classList.add('hidden');
            }
        }
    </script>
</body>
</html>