<?php
// This file belongs to the Bookfind project.
//
// Bookfind is distributed under the terms of the MIT software license.
//
// Copyright (C) 2024 Chromared
?>
<script>
let names_editeur = [
  <?php
    $recupEditors = $bdd->query('SELECT editeur FROM books ORDER BY editeur');
    while ($editors = $recupEditors->fetch()) { ?>
      "<?= htmlspecialchars($editors['editeur']); ?>",
  <?php } ?>
];

// Trier les noms dans l'ordre alphabétique
let sortedNamesEditeur = names_editeur.sort();

// Références à l'entrée et à la liste
let inputEditeur = document.getElementById("editeur");
let listEditeur = document.querySelector(".list-editeur");
let currentFocusEditeur = -1;

// Fonction principale exécutée lors de la saisie
inputEditeur.addEventListener("input", () => {
  let value = inputEditeur.value.toLowerCase();
  removeEditeurElements();
  currentFocusEditeur = -1;

  if (!value) return;

  for (let iEditeur of sortedNamesEditeur) {
    if (iEditeur.toLowerCase().startsWith(value)) {
      let listItemEditeur = document.createElement("li");
      listItemEditeur.classList.add("list-items");
      listItemEditeur.textContent = iEditeur;

      listItemEditeur.addEventListener("click", () => {
        inputEditeur.value = iEditeur;
        removeEditeurElements();
      });

      listEditeur.appendChild(listItemEditeur);
    }
  }
});

// Navigation au clavier
inputEditeur.addEventListener("keydown", (e) => {
  let items = listEditeur.querySelectorAll(".list-items");

  if (e.key === "ArrowDown") {
    currentFocusEditeur++;
    if (currentFocusEditeur >= items.length) currentFocusEditeur = 0;
    addActiveEditeur(items);
  } else if (e.key === "ArrowUp") {
    currentFocusEditeur--;
    if (currentFocusEditeur < 0) currentFocusEditeur = items.length - 1;
    addActiveEditeur(items);
  } else if (e.key === "Enter") {
    e.preventDefault(); // Empêche la soumission du formulaire
    if (currentFocusEditeur > -1 && items[currentFocusEditeur]) {
      items[currentFocusEditeur].click();
    }
  }
});

function addActiveEditeur(items) {
  if (!items) return;
  removeActiveEditeur(items);
  if (currentFocusEditeur >= 0 && currentFocusEditeur < items.length) {
    items[currentFocusEditeur].classList.add("active");
  }
}

function removeActiveEditeur(items) {
  items.forEach((item) => item.classList.remove("active"));
}

function removeEditeurElements() {
  while (listEditeur.firstChild) {
    listEditeur.removeChild(listEditeur.firstChild);
  }
}
</script>