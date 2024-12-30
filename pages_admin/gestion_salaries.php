<?php
// Inclusion du fichier d'en-tête contenant les configurations ou éléments partagés
include "../includes/header.php";


// --- Récupération des employés ---
$showArchived = isset($_GET['archived']) && $_GET['archived'] === '1'; // Vérifier si on doit afficher les employés archivés

try {
    if ($showArchived) {
        $sql = "SELECT id_employe, prenom_employe, nom_employe, estArchive FROM employés WHERE estArchive = 1";
    } else {
        $sql = "SELECT id_employe, prenom_employe, nom_employe, estArchive FROM employés WHERE estArchive = 0";
    }
    $stmt = $pdo->query($sql);
    $employes = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erreur lors de la récupération des employés : " . $e->getMessage());
}
?>
<div class="manage-employees-container">
    <h1 class="manage-employees-title">Liste des salariés</h1>

<<<<<<< HEAD
<div class="manage-employees-container">
    <h1 class="manage-employees-title">Liste des salariés</h1>

    <!-- Bouton pour basculer l'affichage des employés archivés -->
    <form method="GET" class="toggle-archived-form">
        <button type="submit" name="archived" value="<?php echo $showArchived ? '0' : '1'; ?>" class="btn btn-secondary">
            <?php echo $showArchived ? "Afficher les employés actifs" : "Afficher les employés archivés"; ?>
        </button>
    </form>

    <!-- Formulaire pour la gestion des employés -->
    <form id="salaries-form" method="POST" onsubmit="return confirmAction();">
        <div class="manage-employees-actions">
            <button class="btn btn-primary" type="button" onclick="window.location.href='ajouter_salaries.php'">Ajouter un employé</button>
            <button id="modifier-btn" class="btn manage-employees-btn-secondary" type="button" disabled>Modifier un employé</button>
            <button id="supprimer-btn" class="btn manage-employees-btn-danger" type="submit" name="supprimer" disabled>Supprimer les employés sélectionnés</button>
            <button id="archiver-btn" class="btn btn-primary" type="submit" name="archiver" disabled>Archiver les employés sélectionnés</button>
        </div>

=======
    <!-- Affichage d'un message de confirmation ou d'erreur -->
    <?php if (isset($message)) : ?>
        <p class="manage-employees-message success"><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>

    <!-- Formulaire pour la suppression des employés -->
    <form id="salaries-form" method="POST" onsubmit="return confirmDeletion();">
        <div class="manage-employees-actions">
            <!-- Bouton pour ajouter un employé -->
            <button class="btn btn-primary" type="button" onclick="window.location.href='ajouter_salaries.php'">Ajouter un employé</button>
            <!-- Bouton pour modifier un employé, désactivé par défaut -->
            <button id="modifier-btn" class="btn manage-employees-btn-secondary" type="button" disabled>Modifier un employé</button>
            <!-- Bouton pour supprimer les employés sélectionnés, désactivé par défaut -->
            <button id="supprimer-btn" class="btn manage-employees-btn-danger" type="submit" disabled>Supprimer les employés sélectionnés</button>
            <button id="archiver-btn" class="btn manage-employees-btn-info" type="submit" disabled>Archiver les employés sélectionnés</button>
        </div>

>>>>>>> 14aef7493f10b88f0d1e8d5620a371a38caa163c
        <!-- Tableau des employés -->
        <table class="manage-employees-table">
            <thead>
                <tr>
<<<<<<< HEAD
=======
                    <!-- Case à cocher pour tout sélectionner -->
>>>>>>> 14aef7493f10b88f0d1e8d5620a371a38caa163c
                    <th>
                        <input type="checkbox" id="select-all" onclick="toggleAll(this)"> Tout Sélectionner
                    </th>
                    <th>ID</th>
                    <th>Prénom</th>
                    <th>Nom</th>
<<<<<<< HEAD
                    <th>Archivé ?</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($employes)) : ?>
                    <?php foreach ($employes as $employe) : ?>
                        <tr class="<?php echo $employe['estArchive'] == 1 ? 'archived-row' : ''; ?>">
                            <td>
                                <input type="checkbox" class="manage-employees-checkbox" name="selected_ids[]" value="<?php echo htmlspecialchars($employe['id_employe']); ?>">
                            </td>
                            <td><?php echo htmlspecialchars($employe['id_employe']); ?></td>
                            <td><?php echo htmlspecialchars($employe['prenom_employe']); ?></td>
                            <td><?php echo htmlspecialchars($employe['nom_employe']); ?></td>
                            <td><?php echo ($employe['estArchive'] == 1) ? "Oui" : "Non"; ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="5">Aucun employé trouvé</td>
=======
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0) : ?>
                    <?php while ($row = $result->fetch_assoc()) : ?>
                        <tr>
                            <!-- Case à cocher pour chaque employé -->
                            <td>
                                <input type="checkbox" class="manage-employees-checkbox" name="selected_ids[]" value="<?php echo htmlspecialchars($row['id_employe']); ?>">
                            </td>
                            <!-- Affichage de l'ID de l'employé -->
                            <td><?php echo htmlspecialchars($row['id_employe']); ?></td>
                            <!-- Affichage du prénom de l'employé -->
                            <td><?php echo htmlspecialchars($row['prenom_employe']); ?></td>
                            <!-- Affichage du nom de l'employé -->
                            <td><?php echo htmlspecialchars($row['nom_employe']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="4">Aucun employé trouvé</td>
>>>>>>> 14aef7493f10b88f0d1e8d5620a371a38caa163c
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </form>
</div>

</html>

<<<<<<< HEAD
<style>
    .archived-row {
        background-color: #f8d7da;
        color: #721c24;
    }

    .manage-employees-table tbody tr {
        transition: background-color 0.3s ease;
    }

    .manage-employees-table tbody tr:hover {
        background-color: #f1f1f1;
    }
</style>

<script>
    // Fonction pour cocher ou décocher toutes les cases
    function toggleAll(source) {
        const checkboxes = document.querySelectorAll('.manage-employees-checkbox');
        checkboxes.forEach(checkbox => checkbox.checked = source.checked);
        updateButtons();
=======
<script>
    // Fonction pour cocher ou décocher toutes les cases
    function toggleAll(source) {
        const checkboxes = document.querySelectorAll('.employee-checkbox');
        checkboxes.forEach(checkbox => checkbox.checked = source.checked);
        updateButtons(); // Met à jour l'état des boutons
>>>>>>> 14aef7493f10b88f0d1e8d5620a371a38caa163c
    }

    // Mise à jour de l'état des boutons en fonction des sélections
    function updateButtons() {
<<<<<<< HEAD
        const checkboxes = document.querySelectorAll('.manage-employees-checkbox');
        const selectedCheckboxes = document.querySelectorAll('.manage-employees-checkbox:checked');
        const modifierBtn = document.getElementById('modifier-btn');
        const supprimerBtn = document.getElementById('supprimer-btn');
        const archiverBtn = document.getElementById('archiver-btn');

        modifierBtn.disabled = selectedCheckboxes.length !== 1;
        const isAnySelected = selectedCheckboxes.length > 0;
        supprimerBtn.disabled = !isAnySelected;
        archiverBtn.disabled = !isAnySelected;

        if (selectedCheckboxes.length === 1) {
            const id = selectedCheckboxes[0].value;
=======
        const checkboxes = document.querySelectorAll('.employee-checkbox:checked');
        const modifierBtn = document.getElementById('modifier-btn');
        const supprimerBtn = document.getElementById('supprimer-btn');

        // Activer le bouton "Modifier" seulement si un seul employé est sélectionné
        modifierBtn.disabled = checkboxes.length !== 1;
        // Activer le bouton "Supprimer" si au moins un employé est sélectionné
        supprimerBtn.disabled = checkboxes.length === 0;

        // Si un seul employé est sélectionné, rediriger vers la page de modification avec son ID
        if (checkboxes.length === 1) {
            const id = checkboxes[0].value;
>>>>>>> 14aef7493f10b88f0d1e8d5620a371a38caa163c
            modifierBtn.onclick = () => {
                window.location.href = `modifier_salaries.php?id=${id}`;
            };
        } else {
            modifierBtn.onclick = null;
        }
    }

<<<<<<< HEAD
    // Fonction pour confirmer l'action (supprimer ou archiver)
    function confirmAction() {
        const checkboxes = document.querySelectorAll('.manage-employees-checkbox:checked');
        if (checkboxes.length > 0) {
            return confirm('Êtes-vous sûr de vouloir effectuer cette action sur les employés sélectionnés ?');
        }
        alert('Veuillez sélectionner au moins un employé.');
        return false;
    }

    // Ajouter un événement "change" à chaque case à cocher
    document.querySelectorAll('.manage-employees-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', updateButtons);
    });

    document.addEventListener('DOMContentLoaded', () => {
        updateButtons();
    });
</script>

=======
    // Fonction pour confirmer avant de supprimer les employés sélectionnés
    function confirmDeletion() {
        const checkboxes = document.querySelectorAll('.employee-checkbox:checked');
        if (checkboxes.length > 0) {
            return confirm('Êtes-vous sûr de vouloir supprimer les employés sélectionnés ?');
        }
        alert('Veuillez sélectionner au moins un employé à supprimer.');
        return false;
    }

    // Ajouter un événement "change" à chaque case à cocher pour mettre à jour les boutons
    document.querySelectorAll('.employee-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', updateButtons);
    });
</script>
>>>>>>> 14aef7493f10b88f0d1e8d5620a371a38caa163c
<?php
include "../includes/footer.php";
?>