document.addEventListener('DOMContentLoaded', function () {
    startApp();
});

function startApp() {
    searchByDate();
}

function searchByDate() {
    const dateInput = document.querySelector('#date');
    dateInput.addEventListener('input', function (e) {
        const dateSelected = e.target.value;
        
        window.location = `?date=${dateSelected}`;
    });
}