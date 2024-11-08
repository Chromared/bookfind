# X11 License
# 2024 Chromared


<script>
let names_editeur = [
  <?php

    $recupNames = $bdd->query('SELECT nom FROM editeurs ORDER BY nom');

    while($names = $recupNames->fetch()){?>

      "<?= htmlspecialchars($names['nom']); ?>",

    <?php }

  ?>
];
//Sort names in ascending order
let sortedNamesEditeur = names_editeur.sort();

//reference
let inputEditeur = document.getElementById("editeur");

//Execute function on keyup
inputEditeur.addEventListener("keyup", (e) => {
  //loop through above array
  //Initially remove all elements ( so if user erases a letter or adds new letter then clean previous outputs)
  removeElements();
  for (let iEditeur of sortedNamesEditeur) {
    //convert input to lowercase and compare with each string

    if (
      iEditeur.toLowerCase().startsWith(inputEditeur.value.toLowerCase()) && inputEditeur.value != "") {
      //create li element
      let listItemEditeur = document.createElement("li");
      //One common class name
      listItemEditeur.classList.add("list-items");
      listItemEditeur.style.cursor = "pointer";
      listItemEditeur.setAttribute("onclick", "displayNamesEditeur('" + iEditeur + "')");
      //Display matched part in bold
      let wordEditeur = "<b>" + iEditeur.substr(0, inputEditeur.value.length) + "</b>";
      wordEditeur += iEditeur.substr(inputEditeur.value.length);
      //display the value in array
      listItemEditeur.innerHTML = wordEditeur;
      document.querySelector(".list-editeur").appendChild(listItemEditeur);
    }
  }
});
function displayNamesEditeur(value) {
  inputEditeur.value = value;
  removeElements();
}
function removeElements() {
  //clear all the item
  let itemsEditeur = document.querySelectorAll(".list-items");
  itemsEditeur.forEach((item) => {
    item.remove();
  });
}
</script>