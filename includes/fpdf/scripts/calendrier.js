const calendar = document.getElementById('calendar');
const startDateSpan = document.getElementById('start-date');
const endDateSpan = document.getElementById('end-date');
const inputStartDate = document.getElementById('input-start-date');
const inputEndDate = document.getElementById('input-end-date');

const daysInMonth = 30;
let isSelecting = false;
let startDate = null;
let endDate = null;

for (let day = 1; day <= daysInMonth; day++) {
    const dayElement = document.createElement('div');
    dayElement.classList.add('day');
    dayElement.textContent = day;
    dayElement.dataset.date = `2023-12-${String(day).padStart(2, '0')}`;
    calendar.appendChild(dayElement);

    dayElement.addEventListener('mousedown', (e) => {
        isSelecting = true;
        startDate = dayElement.dataset.date;
        endDate = dayElement.dataset.date;
        updateSelection();
    });

    dayElement.addEventListener('mouseover', (e) => {
        if (isSelecting) {
            endDate = dayElement.dataset.date;
            updateSelection();
        }
    });

    dayElement.addEventListener('mouseup', (e) => {
        isSelecting = false;
    });
}

document.addEventListener('mouseup', () => {
    isSelecting = false;
});

function updateSelection() {
    const allDays = document.querySelectorAll('.day');
    allDays.forEach(day => {
        const date = day.dataset.date;
        if (date >= startDate && date <= endDate) {
            day.classList.add('selected');
        } else {
            day.classList.remove('selected');
        }
    });
    startDateSpan.textContent = startDate;
    endDateSpan.textContent = endDate;
    inputStartDate.value = startDate;
    inputEndDate.value = endDate;
}