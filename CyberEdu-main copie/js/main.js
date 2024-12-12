document.addEventListener("DOMContentLoaded", () => {
    const lessonsContainer = document.querySelector("#lessonsContainer");

    // Charger les leçons depuis le backend
    const loadLessons = async () => {
        try {
            const response = await fetch("get_lessons.php");
            if (!response.ok) {
                throw new Error(`Erreur HTTP : ${response.status}`);
            }

            const lessons = await response.json();

            // Vérification si aucune leçon n'est trouvée
            if (!lessons || lessons.length === 0) {
                lessonsContainer.innerHTML = "<p>Aucune leçon disponible.</p>";
                return;
            }

            // Générer les cartes de leçons
            lessonsContainer.innerHTML = ""; // Réinitialise le conteneur
            lessons.forEach((lesson) => {
                const card = document.createElement("div");
                card.className = "card";

                card.innerHTML = `
                    <div class="card-image-container">
                        <img src="${lesson.cover_image}" alt="${lesson.title}" class="card-image">
                    </div>
                    <div class="card-content">
                        <span class="badge ${lesson.level.toLowerCase()}">${lesson.level}</span>
                        <h2>${lesson.title}</h2>
                        <p>${lesson.description}</p>
                        <p><strong>${lesson.duration} minutes</strong></p>
                        <a href="lesson.php?id=${lesson.id}" class="btn">Commencer la leçon</a>
                    </div>
                `;
                lessonsContainer.appendChild(card);
            });
        } catch (error) {
            console.error("Erreur lors du chargement des leçons :", error);
            lessonsContainer.innerHTML =
                "<p>Une erreur est survenue lors du chargement des leçons. Veuillez réessayer plus tard.</p>";
        }
    };

    loadLessons();

    // Recherche dynamique
    const searchInput = document.querySelector("#searchInput");
    if (searchInput) {
        searchInput.addEventListener("input", () => {
            const searchTerm = searchInput.value.toLowerCase();
            const cards = document.querySelectorAll(".card");
            let hasResults = false;

            cards.forEach((card) => {
                const title = card.querySelector("h2").textContent.toLowerCase();
                if (title.includes(searchTerm)) {
                    card.style.display = "block";
                    hasResults = true;
                } else {
                    card.style.display = "none";
                }
            });

            // Affiche un message si aucune carte ne correspond à la recherche
            if (!hasResults) {
                lessonsContainer.innerHTML = `<p>Aucune leçon ne correspond à "${searchTerm}".</p>`;
            }
        });
    }
});
