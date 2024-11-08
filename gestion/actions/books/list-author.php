# X11 License
# Copyright © 2024 Chromared


<script>
let names_authors = [
  <?php

    $recupNames = $bdd->query('SELECT nomprenom FROM authors ORDER BY nomprenom');

    while($names = $recupNames->fetch()){?>

      "<?= htmlspecialchars($names['nomprenom']); ?>",

    <?php }

  ?>
];
//Sort names in ascending order
let sortedNamesAuthor = names_authors.sort();

//reference
let inputAuthor = document.getElementById("author");

//Execute function on keyup
inputAuthor.addEventListener("keyup", (e) => {
  //loop through above array
  //Initially remove all elements ( so if user erases a letter or adds new letter then clean previous outputs)
  removeElements();
  for (let iAuthor of sortedNamesAuthor) {
    //convert input to lowercase and compare with each string

    if (
      iAuthor.toLowerCase().startsWith(inputAuthor.value.toLowerCase()) && inputAuthor.value != "") {
      //create li element
      let listItemAuthor = document.createElement("li");
      //One common class name
      listItemAuthor.classList.add("list-items");
      listItemAuthor.style.cursor = "pointer";
      listItemAuthor.setAttribute("onclick", "displayNamesAuthor('" + iAuthor + "')");
      //Display matched part in bold
      let wordAuthor = "<b>" + iAuthor.substr(0, inputAuthor.value.length) + "</b>";
      wordAuthor += iAuthor.substr(inputAuthor.value.length);
      //display the value in array
      listItemAuthor.innerHTML = wordAuthor;
      document.querySelector(".list-author").appendChild(listItemAuthor);
    }
  }
});
function displayNamesAuthor(value) {
  inputAuthor.value = value;
  removeElements();
}
function removeElements() {
  //clear all the item
  let itemsAuthor = document.querySelectorAll(".list-items");
  items.forEach((item) => {
    item.remove();
  });
}
</script>