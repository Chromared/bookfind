<script>
let names_Serie = [
  <?php

    $recupNames = $bdd->query('SELECT serie FROM books ORDER BY serie');

    while($names = $recupNames->fetch()){?>

      "<?= htmlspecialchars($names['serie']); ?>",

    <?php }

  ?>
];
//Sort names in ascending order
let sortedNameSerie = names_Serie.sort();

//reference
let inputSerie = document.getElementById("serie");

//Execute function on keyup
inputSerie.addEventListener("keyup", (e) => {
  //loop through above array
  //Initially remove all elements ( so if user erases a letter or adds new letter then clean previous outputs)
  removeElements();
  for (let iSerie of sortedNameSerie) {
    //convert input to lowercase and compare with each string

    if (
      iSerie.toLowerCase().startsWith(inputSerie.value.toLowerCase()) && inputSerie.value != "") {
      //create li element
      let listItemSerie = document.createElement("li");
      //One common class name
      listItemSerie.classList.add("list-items");
      listItemSerie.style.cursor = "pointer";
      listItemSerie.setAttribute("onclick", "displayNamesSerie('" + iSerie + "')");
      //Display matched part in bold
      let wordSerie = "<b>" + iSerie.substr(0, inputSerie.value.length) + "</b>";
      wordSerie += iSerie.substr(inputSerie.value.length);
      //display the value in array
      listItemSerie.innerHTML = wordSerie;
      document.querySelector(".list-serie").appendChild(listItemSerie);
    }
  }
});
function displayNamesSerie(value) {
  inputSerie.value = value;
  removeElements();
}
function removeElements() {
  //clear all the item
  let itemsSerie = document.querySelectorAll(".list-items");
  itemsSerie.forEach((item) => {
    item.remove();
  });
}
</script>