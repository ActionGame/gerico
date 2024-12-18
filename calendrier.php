<?php
include "includes/header.php";
?>

<label for="monthSelector">Choisissez un mois :</label>
<select id="monthSelector">
    <!-- Options will be dynamically added -->
</select>

<div class="calendar-container" id="calendarContainer">
    <!-- Calendar will be dynamically inserted here -->
</div>

<div class="selection-info" id="selectionInfo">
    Période sélectionnée : <span id="startDate">-</span> au <span id="endDate">-</span>
</div>
<div>
    <label for="userMessage">Pour quel motif ?</label>
    <textarea id="userMessage" placeholder="Entrez votre motif ici" rows="3" style="width: 100%;"></textarea>
</div>
<button id="saveButton" disabled>Enregistrer</button>

<script>
    let startDate = null;
    let endDate = null;

    function generateMonthOptions() {
        const monthSelector = document.getElementById('monthSelector');
        const today = new Date();

        for (let i = 0; i < 12; i++) {
            const date = new Date(today.getFullYear(), today.getMonth() + i, 1);
            const monthName = date.toLocaleString('default', {
                month: 'long',
                year: 'numeric'
            });

            const option = document.createElement('option');
            option.value = `${date.getFullYear()}-${date.getMonth()}`;
            option.innerText = monthName;
            if (i === 0) {
                option.selected = true;
            }
            monthSelector.appendChild(option);
        }
    }

    function generateCalendar(year, month) {
        const calendarContainer = document.getElementById('calendarContainer');
        calendarContainer.innerHTML = '';

        const date = new Date(year, month, 1);
        const monthName = date.toLocaleString('default', {
            month: 'long'
        });

        const daysInMonth = new Date(date.getFullYear(), date.getMonth() + 1, 0).getDate();

        const monthDiv = document.createElement('div');
        monthDiv.className = 'month';

        const title = document.createElement('h3');
        title.innerText = `${monthName} ${date.getFullYear()}`;
        monthDiv.appendChild(title);

        const daysDiv = document.createElement('div');
        daysDiv.className = 'days';

        // Add day headers
        const dayHeaders = ['Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim'];
        dayHeaders.forEach(day => {
            const headerDiv = document.createElement('div');
            headerDiv.className = 'calendar-header';
            headerDiv.innerText = day;
            daysDiv.appendChild(headerDiv);
        });

        // Add empty slots for days before the first of the month
        const firstDay = date.getDay() === 0 ? 6 : date.getDay() - 1; // Adjust to start with Monday
        for (let j = 0; j < firstDay; j++) {
            const emptyDiv = document.createElement('div');
            daysDiv.appendChild(emptyDiv);
        }

        // Add days of the month
        for (let day = 1; day <= daysInMonth; day++) {
            const dayDiv = document.createElement('div');
            dayDiv.innerText = day;
            dayDiv.dataset.date = `${year}-${month + 1}-${day}`;

            dayDiv.addEventListener('click', function() {
                const clickedDate = this.dataset.date;

                if (!startDate || (startDate && endDate)) {
                    startDate = clickedDate;
                    endDate = null;
                    Array.from(daysDiv.children).forEach(child => child.classList.remove('selected'));
                    this.classList.add('selected');
                } else if (!endDate) {
                    const start = new Date(startDate);
                    const end = new Date(clickedDate);

                    if (end >= start) {
                        endDate = clickedDate;
                        Array.from(daysDiv.children).forEach(child => {
                            const childDate = new Date(child.dataset.date);
                            if (childDate >= start && childDate <= end) {
                                child.classList.add('selected');
                            }
                        });
                    } else {
                        startDate = clickedDate;
                        Array.from(daysDiv.children).forEach(child => child.classList.remove('selected'));
                        this.classList.add('selected');
                    }
                }

                updateSelectionInfo();
            });

            daysDiv.appendChild(dayDiv);
        }

        monthDiv.appendChild(daysDiv);
        calendarContainer.appendChild(monthDiv);
        calendarContainer.style.display = 'block';
    }

    document.getElementById('monthSelector').addEventListener('change', function() {
        const [year, month] = this.value.split('-').map(Number);
        startDate = null;
        endDate = null;
        updateSelectionInfo();
        generateCalendar(year, month);
    });

    document.getElementById('saveButton').addEventListener('click', function() {
        const message = document.getElementById('userMessage').value;

        if (!startDate || !endDate) {
            alert('Veuillez sélectionner une période complète.');
            return;
        }

        if (!message.trim()) {
            alert('Veuillez saisir un message.');
            return;
        }

        // Envoyer les dates et le message au serveur via AJAX
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'save_dates.php', true);
        xhr.setRequestHeader('Content-Type', 'application/json;charset=UTF-8');
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4) {
                if (xhr.status === 200) {
                    alert('Période et message enregistrés avec succès !');
                } else {
                    alert('Erreur lors de l\'enregistrement. Veuillez réessayer.');
                }
            }
        };
        xhr.send(JSON.stringify({
            startDate,
            endDate,
            message
        }));
    });


    // Activer le bouton "Enregistrer" uniquement si une période est complète
    function updateSaveButton() {
        const saveButton = document.getElementById('saveButton');
        saveButton.disabled = !(startDate && endDate);
    }

    // Appelez `updateSaveButton()` après avoir mis à jour les informations de sélection
    function updateSelectionInfo() {
        document.getElementById('startDate').innerText = startDate ? startDate : '-';
        document.getElementById('endDate').innerText = endDate ? endDate : '-';
        updateSaveButton(); // Vérifie si le bouton doit être activé ou non
    }

    // Initial setup
    generateMonthOptions();
    const today = new Date();
    generateCalendar(today.getFullYear(), today.getMonth());
</script>

<?php
include "includes/footer.php";
?>