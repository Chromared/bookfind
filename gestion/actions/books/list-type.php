# This file belongs to the Bookfind project.
#
# Bookfind is distributed under the terms of the MIT software license.
#
# Copyright (C) 2024 Chromared


<script>
let names_type = [
  <?php

    $recupNames = $bdd->query('SELECT nom FROM types ORDER BY nom');

    while($names = $recupNames->fetch()){?>

      "<?= htmlspecialchars($names['nom']); ?>",

    <?php }

  ?>
];
//Sort names in ascending order
let sortedNameType = names_type.sort();

//reference
let inputType = document.getElementById("type");

//Execute function on keyup
inputType.addEventListener("keyup", (e) => {
  //loop through above array
  //Initially remove all elements ( so if user erases a letter or adds new letter then clean previous outputs)
  removeElements();
  for (let iType of sortedNameType) {
    //convert input to lowercase and compare with each string

    if (
      iType.toLowerCase().startsWith(inputType.value.toLowerCase()) && inputType.value != "") {
      //create li element
      let listItemType = document.createElement("li");
      //One common class name
      listItemType.classList.add("list-items");
      listItemType.style.cursor = "pointer";
      listItemType.setAttribute("onclick", "displayNamesType('" + iType + "')");
      //Display matched part in bold
      let wordType = "<b>" + iType.substr(0, inputType.value.length) + "</b>";
      wordType += iType.substr(inputType.value.length);
      //display the value in array
      listItemType.innerHTML = wordType;
      document.querySelector(".list-type").appendChild(listItemType);
    }
  }
});
function displayNamesType(value) {
  inputType.value = value;
  removeElements();
}
function removeElements() {
  //clear all the item
  let itemsType = document.querySelectorAll(".list-items");
  itemsType.forEach((item) => {
    item.remove();
  });
}
</script>