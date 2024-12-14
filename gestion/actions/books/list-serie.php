<?php
// This file belongs to the Bookfind project.
//
// Bookfind is distributed under the terms of the MIT software license.
//
// Copyright (C) 2024 Chromared
?>
<script>
let names_Serie = [
  <?php
    $recupNames = $bdd->query('SELECT serie FROM books ORDER BY serie');
    while ($names = $recupNames->fetch()) { ?>
      "<?= htmlspecialchars($names['serie']); ?>",
  <?php } ?>
];

let sortedNamesSerie = names_Serie.sort();

let inputSerie = document.getElementById("serie");
let listSerie = document.querySelector(".list-serie");
let currentFocusSerie = -1;

inputSerie.addEventListener("input", () => {
  let value = inputSerie.value.toLowerCase();
  removeSerieElements();
  currentFocusSerie = -1;

  if (!value) return;

  for (let iSerie of sortedNamesSerie) {
    if (iSerie.toLowerCase().startsWith(value)) {
      let listItemSerie = document.createElement("li");
      listItemSerie.classList.add("list-items");
      listItemSerie.textContent = iSerie;

      listItemSerie.addEventListener("click", () => {
        inputSerie.value = iSerie;
        removeSerieElements();
      });

      listSerie.appendChild(listItemSerie);
    }
  }
});

inputSerie.addEventListener("keydown", (e) => {
  let items = listSerie.querySelectorAll(".list-items");

  if (e.key === "ArrowDown") {
    currentFocusSerie++;
    if (currentFocusSerie >= items.length) currentFocusSerie = 0;
    addActiveSerie(items);
  } else if (e.key === "ArrowUp") {
    currentFocusSerie--;
    if (currentFocusSerie < 0) currentFocusSerie = items.length - 1;
    addActiveSerie(items);
  } else if (e.key === "Enter") {
    e.preventDefault();
    if (currentFocusSerie > -1 && items[currentFocusSerie]) {
      items[currentFocusSerie].click();
    }
  }
});

function addActiveSerie(items) {
  if (!items) return;
  removeActiveSerie(items);
  if (currentFocusSerie >= 0 && currentFocusSerie < items.length) {
    items[currentFocusSerie].classList.add("active");
  }
}

function removeActiveSerie(items) {
  items.forEach((item) => item.classList.remove("active"));
}

function removeSerieElements() {
  while (listSerie.firstChild) {
    listSerie.removeChild(listSerie.firstChild);
  }
}
</script>