<?php
// Inclusion du fichier d'en-tête contenant les configurations ou éléments partagés
include "../includes/header.php";

// --- Connexion à la base de données ---
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gerico";

// Création de la connexion à la base de données
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérification de la connexion
if ($conn->connect_error) {
    // Si la connexion échoue, afficher un message d'erreur et arrêter l'exécution
    die("Connexion échouée : " . $conn->connect_error);
}

// --- Suppression des employés sélectionnés ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['selected_ids'])) {
    // Récupération des IDs des employés sélectionnés depuis le formulaire
    $ids = $_POST['selected_ids'];

    if (!empty($ids)) {
        // Préparer une chaîne de "?" pour les IDs, en évitant les injections SQL
        $ids_placeholder = implode(',', array_fill(0, count($ids), '?'));

        // Préparation de la requête SQL de suppression
        $sql = "DELETE FROM employés WHERE id_employe IN ($ids_placeholder)";
        $stmt = $conn->prepare($sql);

        // Associer les IDs aux espaces réservés
        $stmt->bind_param(str_repeat('i', count($ids)), ...$ids);

        // Exécuter la requête et définir le message correspondant
        if ($stmt->execute()) {
            $message = "Employés supprimés avec succès.";
        } else {
            $message = "Erreur lors de la suppression : " . $conn->error;
        }

        // Fermeture du statement
        $stmt->close();
    } else {
        $message = "Aucun employé sélectionné pour suppression.";
    }
}

// --- Récupération des employés dans la base de données ---
$sql = "SELECT id_employe, prenom_employe, nom_employe FROM employés";
$result = $conn->query($sql);
?>
<div class="manage-employees-container">
    <h1 class="manage-employees-title">Liste des salariés</h1>

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

        <!-- Tableau des employés -->
        <table class="manage-employees-table">
            <thead>
                <tr>
                    <!-- Case à cocher pour tout sélectionner -->
                    <th>
                        <input type="checkbox" id="select-all" onclick="toggleAll(this)"> Tout Sélectionner
                    </th>
                    <th>ID</th>
                    <th>Prénom</th>
                    <th>Nom</th>
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
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </form>
</div>

</html>

<script>
    // Fonction pour cocher ou décocher toutes les cases
    function toggleAll(source) {
        const checkboxes = document.querySelectorAll('.employee-checkbox');
        checkboxes.forEach(checkbox => checkbox.checked = source.checked);
        updateButtons(); // Met à jour l'état des boutons
    }

    // Mise à jour de l'état des boutons en fonction des sélections
    function updateButtons() {
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
            modifierBtn.onclick = () => {
                window.location.href = `modifier_salaries.php?id=${id}`;
            };
        } else {
            modifierBtn.onclick = null;
        }
    }

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
<?php
// Fermeture de la connexion à la base de données
$conn->close();
include "../includes/footer.php";
?>