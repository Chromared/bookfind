<?php
// This file belongs to the Bookfind project.
//
// Bookfind is distributed under the terms of the MIT software license.
//
// Copyright (C) 2024 Chromared
?>
<script>
let names_genre = [
  <?php
    $recupGenres = $bdd->query('SELECT genre FROM books ORDER BY genre');
    while ($genres = $recupNames->fetch()) { ?>
      "<?= htmlspecialchars($genres['genre']); ?>",
  <?php } ?>
];

let sortedNamesGenre = names_genre.sort();

let inputGenre = document.getElementById("genre");
let listGenre = document.querySelector(".list-genre");
let currentFocusGenre = -1;

inputGenre.addEventListener("input", () => {
  let value = inputGenre.value.toLowerCase();
  removeGenreElements();
  currentFocusGenre = -1;

  if (!value) return;

  for (let iGenre of sortedNamesGenre) {
    if (iGenre.toLowerCase().startsWith(value)) {
      let listItemGenre = document.createElement("li");
      listItemGenre.classList.add("list-items");
      listItemGenre.textContent = iGenre;

      listItemGenre.addEventListener("click", () => {
        inputGenre.value = iGenre;
        removeGenreElements();
      });

      listGenre.appendChild(listItemGenre);
    }
  }
});

inputGenre.addEventListener("keydown", (e) => {
  let items = listGenre.querySelectorAll(".list-items");

  if (e.key === "ArrowDown") {
    currentFocusGenre++;
    if (currentFocusGenre >= items.length) currentFocusGenre = 0;
    addActiveGenre(items);
  } else if (e.key === "ArrowUp") {
    currentFocusGenre--;
    if (currentFocusGenre < 0) currentFocusGenre = items.length - 1;
    addActiveGenre(items);
  } else if (e.key === "Enter") {
    e.preventDefault();
    if (currentFocusGenre > -1 && items[currentFocusGenre]) {
      items[currentFocusGenre].click();
    }
  }
});

function addActiveGenre(items) {
  if (!items) return;
  removeActiveGenre(items);
  if (currentFocusGenre >= 0 && currentFocusGenre < items.length) {
    items[currentFocusGenre].classList.add("active");
  }
}

function removeActiveGenre(items) {
  items.forEach((item) => item.classList.remove("active"));
}

function removeGenreElements() {
  while (listGenre.firstChild) {
    listGenre.removeChild(listGenre.firstChild);
  }
}
</script>