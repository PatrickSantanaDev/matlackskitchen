
// When the page loads, get the ingredients from the server and display them
window.onload = function () {
    var ingredientsDiv = document.getElementById('ingredientsDiv');

    //AJAX request for ingredients
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'get_ingredients_handler.php?refreshIngredients=true', true);
    xhr.onload = function () {
        if (this.status == 200) {
            var response = JSON.parse(this.responseText);

            //group the ingredients by category
            var groupedIngredients = {};
            for (var i = 0; i < response.proteinIngredients.length; i++) {
                var ingredient = response.proteinIngredients[i];
                if (!groupedIngredients.hasOwnProperty(ingredient.category)) {
                    groupedIngredients[ingredient.category] = [];
                }
                groupedIngredients[ingredient.category].push(ingredient);
            }
            for (var i = 0; i < response.dairyIngredients.length; i++) {
                var ingredient = response.dairyIngredients[i];
                if (!groupedIngredients.hasOwnProperty(ingredient.category)) {
                    groupedIngredients[ingredient.category] = [];
                }
                groupedIngredients[ingredient.category].push(ingredient);
            }

            //create HTML for the ingredients checkboxes grouped by category
            var html = '';
            for (var category in groupedIngredients) {
                html += '<fieldset class="' + category + '">';
                html += '<legend class="legend">' + category + '</legend>';
                for (var i = 0; i < groupedIngredients[category].length; i++) {
                    var ingredient = groupedIngredients[category][i];
                    html += '<div><input type="checkbox" id="' + ingredient.id + '" name="ingredient_name[]" value="' + ingredient.ingredient_name + '" /><label for="' + ingredient.id + '">' + ingredient.ingredient_name + '</label></div>';
                }
                html += '</fieldset>';
            }

            ingredientsDiv.innerHTML = html;
        }
    };
    xhr.send();
};

// when the add ingredient form is submitted, add the ingredient to the database
var form = document.getElementById('ingredientsList');
window.onsubmit = function () {
form.addEventListener('submit', function (event) {
    event.preventDefault();

    var checkboxes = document.querySelectorAll('input[type="checkbox"]:checked');
    var selectedIngredients = [];
    for (var i = 0; i < checkboxes.length; i++) {
        selectedIngredients.push(checkboxes[i].value);
    }

    //AJAX to submit the array
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'submit_ingredients_handler.php', true);
    xhr.setRequestHeader('Content-Type', 'application/json');
    xhr.onreadystatechange = function () {
        if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
            console.log(xhr.responseText);
        }
    };
    xhr.send(JSON.stringify(selectedIngredients));
});
}
