<?php
// This file belongs to the Bookfind project.
//
// Bookfind is distributed under the terms of the MIT software license.
//
// Copyright (C) 2024 Chromared
?>
<script>
let names_type = [
  <?php
    $recupNames = $bdd->query('SELECT nom FROM types ORDER BY nom');
    while ($names = $recupNames->fetch()) { ?>
      "<?= htmlspecialchars($names['nom']); ?>",
  <?php } ?>
];

// Trier les noms dans l'ordre alphabétique
let sortedNamesType = names_type.sort();

// Références à l'entrée et à la liste
let inputType = document.getElementById("type");
let listType = document.querySelector(".list-type");
let currentFocusType = -1;

// Fonction principale exécutée lors de la saisie
inputType.addEventListener("input", () => {
  let value = inputType.value.toLowerCase();
  removeTypeElements();
  currentFocusType = -1;

  if (!value) return;

  for (let iType of sortedNamesType) {
    if (iType.toLowerCase().startsWith(value)) {
      let listItemType = document.createElement("li");
      listItemType.classList.add("list-items");
      listItemType.textContent = iType;

      listItemType.addEventListener("click", () => {
        inputType.value = iType;
        removeTypeElements();
      });

      listType.appendChild(listItemType);
    }
  }
});

// Navigation au clavier
inputType.addEventListener("keydown", (e) => {
  let items = listType.querySelectorAll(".list-items");

  if (e.key === "ArrowDown") {
    currentFocusType++;
    if (currentFocusType >= items.length) currentFocusType = 0;
    addActiveType(items);
  } else if (e.key === "ArrowUp") {
    currentFocusType--;
    if (currentFocusType < 0) currentFocusType = items.length - 1;
    addActiveType(items);
  } else if (e.key === "Enter") {
    e.preventDefault(); // Empêche la soumission du formulaire
    if (currentFocusType > -1 && items[currentFocusType]) {
      items[currentFocusType].click();
    }
  }
});

function addActiveType(items) {
  if (!items) return;
  removeActiveType(items);
  if (currentFocusType >= 0 && currentFocusType < items.length) {
    items[currentFocusType].classList.add("active");
  }
}

function removeActiveType(items) {
  items.forEach((item) => item.classList.remove("active"));
}

function removeTypeElements() {
  while (listType.firstChild) {
    listType.removeChild(listType.firstChild);
  }
}
</script>