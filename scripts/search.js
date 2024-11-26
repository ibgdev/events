document.addEventListener("DOMContentLoaded", () => {
    let nameInput = document.getElementById("search-name");
    let locationInput = document.getElementById("search-location");
    let dateInput = document.getElementById("search-date");
    let eventCards = document.querySelectorAll(".event-card");

    let filterEvents = () => {
        let name = nameInput.value.toLowerCase();
        let location = locationInput.value.toLowerCase();
        let date = dateInput.value;

        eventCards.forEach(card => {
            let title = card.dataset.title;
            let eventLocation = card.dataset.location;
            let eventDate = card.dataset.date;

            let matchesName = !name || title.includes(name);
            let matchesLocation = !location || eventLocation.includes(location);
            let matchesDate = !date || eventDate === date;

            card.style.display = matchesName && matchesLocation && matchesDate ? "block" : "none";
        });
    };

    nameInput.addEventListener("input", filterEvents);
    locationInput.addEventListener("input", filterEvents);
    dateInput.addEventListener("change", filterEvents);
});        document.addEventListener("DOMContentLoaded", () => {
    let nameInput = document.getElementById("search-name");
    let locationInput = document.getElementById("search-location");
    let dateInput = document.getElementById("search-date");
    let eventCards = document.querySelectorAll(".event-card");

    let filterEvents = () => {
        let name = nameInput.value.toLowerCase();
        let location = locationInput.value.toLowerCase();
        let date = dateInput.value;

        eventCards.forEach(card => {
            let title = card.dataset.title;
            let eventLocation = card.dataset.location;
            let eventDate = card.dataset.date;

            let matchesName = !name || title.includes(name);
            let matchesLocation = !location || eventLocation.includes(location);
            let matchesDate = !date || eventDate === date;

            card.style.display = matchesName && matchesLocation && matchesDate ? "block" : "none";
        });
    };

    nameInput.addEventListener("input", filterEvents);
    locationInput.addEventListener("input", filterEvents);
    dateInput.addEventListener("change", filterEvents);
});