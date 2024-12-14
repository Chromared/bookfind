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
    $recupTypes = $bdd->query('SELECT type FROM books ORDER BY type');
    while ($types = $recupTypes->fetch()) { ?>
      "<?= htmlspecialchars($types['type']); ?>",
  <?php } ?>
];

let sortedNamesType = names_type.sort();

let inputType = document.getElementById("type");
let listType = document.querySelector(".list-type");
let currentFocusType = -1;

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
    e.preventDefault();
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