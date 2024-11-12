<?php
//This file belongs to the Bookfind project.
//
//Bookfind is distributed under the terms of the MIT software license.
//
//Copyright (C) 2024 Chromared
?>



<script>
let names_genre = [
  <?php

    $recupNames = $bdd->query('SELECT nom FROM genres ORDER BY nom');

    while($names = $recupNames->fetch()){?>

      "<?= htmlspecialchars($names['nom']); ?>",

    <?php }

  ?>
];
//Sort names in ascending order
let sortedNameGenre = names_genre.sort();

//reference
let inputGenre = document.getElementById("genre");

//Execute function on keyup
inputGenre.addEventListener("keyup", (e) => {
  //loop through above array
  //Initially remove all elements ( so if user erases a letter or adds new letter then clean previous outputs)
  removeElements();
  for (let iGenre of sortedNameGenre) {
    //convert input to lowercase and compare with each string

    if (
      iGenre.toLowerCase().startsWith(inputGenre.value.toLowerCase()) && inputGenre.value != "") {
      //create li element
      let listItemGenre = document.createElement("li");
      //One common class name
      listItemGenre.classList.add("list-items");
      listItemGenre.style.cursor = "pointer";
      listItemGenre.setAttribute("onclick", "displayNamesGenre('" + iGenre + "')");
      //Display matched part in bold
      let wordGenre = "<b>" + iGenre.substr(0, inputGenre.value.length) + "</b>";
      wordGenre += iGenre.substr(inputGenre.value.length);
      //display the value in array
      listItemGenre.innerHTML = wordGenre;
      document.querySelector(".list-genre").appendChild(listItemGenre);
    }
  }
});
function displayNamesGenre(value) {
  inputGenre.value = value;
  removeElements();
}
function removeElements() {
  //clear all the item
  let itemsGenre = document.querySelectorAll(".list-items");
  itemsGenre.forEach((item) => {
    item.remove();
  });
}
</script>