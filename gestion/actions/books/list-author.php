<?php
//This file belongs to the Bookfind project.
//
//Bookfind is distributed under the terms of the MIT software license.
//
//Copyright (C) 2024 Chromared
?>
<script>
let names_authors = [
  <?php
    $recupNames = $bdd->query('SELECT nomprenom FROM authors ORDER BY nomprenom');
    while ($names = $recupNames->fetch()) { ?>
      "<?= htmlspecialchars($names['nomprenom']); ?>",
  <?php } ?>
];

let sortedNamesAuthor = names_authors.sort();

let inputAuthor = document.getElementById("author");
let listAuthor = document.querySelector(".list-author");
let currentFocus = -1;

inputAuthor.addEventListener("input", () => {
  let value = inputAuthor.value.toLowerCase();
  removeElements();
  currentFocus = -1;

  if (!value) return;

  for (let iAuthor of sortedNamesAuthor) {
    if (iAuthor.toLowerCase().startsWith(value)) {
      let listItemAuthor = document.createElement("li");
      listItemAuthor.classList.add("list-items");
      listItemAuthor.textContent = iAuthor;

      listItemAuthor.addEventListener("click", () => {
        inputAuthor.value = iAuthor;
        removeElements();
      });

      listAuthor.appendChild(listItemAuthor);
    }
  }
});

inputAuthor.addEventListener("keydown", (e) => {
  let items = listAuthor.querySelectorAll(".list-items");

  if (e.key === "ArrowDown") {
    currentFocus++;
    if (currentFocus >= items.length) currentFocus = 0;
    addActive(items);
  } else if (e.key === "ArrowUp") {
    currentFocus--;
    if (currentFocus < 0) currentFocus = items.length - 1;
    addActive(items);
  } else if (e.key === "Enter") {
    e.preventDefault();
    if (currentFocus > -1 && items[currentFocus]) {
      items[currentFocus].click();
    }
  }
});

function addActive(items) {
  if (!items) return;
  removeActive(items);
  if (currentFocus >= 0 && currentFocus < items.length) {
    items[currentFocus].classList.add("active");
  }
}

function removeActive(items) {
  items.forEach((item) => item.classList.remove("active"));
}

function removeElements() {
  while (listAuthor.firstChild) {
    listAuthor.removeChild(listAuthor.firstChild);
  }
}
</script>