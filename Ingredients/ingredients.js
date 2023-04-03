
// When the page loads, get the ingredients from the server and display them
window.onload = function () {
    var ingredientsDiv = document.getElementById('ingredientsDiv');

    // AJAX request to get the ingredients from the server
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'get_ingredients_handler.php?refreshIngredients=true', true);
    xhr.onload = function () {
        if (this.status == 200) {
            // Parse the response as JSON
            var response = JSON.parse(this.responseText);

            // Group the ingredients by category
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

            // Create HTML for the ingredients checkboxes grouped by category
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

            // Set the HTML of the ingredientsDiv to the generated HTML
            ingredientsDiv.innerHTML = html;
        }
    };
    xhr.send();
};

// When the add ingredient form is submitted, add the ingredient to the database
// Get a reference to the form and add an event listener to the submit event
var form = document.getElementById('ingredientsList');
window.onsubmit = function () {
form.addEventListener('submit', function (event) {
    event.preventDefault(); // prevent the default form submit behavior

    // Get an array of all the checked checkboxes
    var checkboxes = document.querySelectorAll('input[type="checkbox"]:checked');

    // Loop through the checked checkboxes and add their values to an array of selected ingredients
    var selectedIngredients = [];
    for (var i = 0; i < checkboxes.length; i++) {
        selectedIngredients.push(checkboxes[i].value);
    }

    // Use AJAX to submit the array of selected ingredients to the server
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'submit_ingredients_handler.php', true);
    xhr.setRequestHeader('Content-Type', 'application/json');
    xhr.onreadystatechange = function () {
        if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
            // Handle the server response here
            console.log(xhr.responseText);
        }
    };
    xhr.send(JSON.stringify(selectedIngredients));
});
}
