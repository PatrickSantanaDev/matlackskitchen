
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
            for (var i = 0; i < response.produceIngredients.length; i++) {
                var ingredient = response.produceIngredients[i];
                if (!groupedIngredients.hasOwnProperty(ingredient.category)) {
                    groupedIngredients[ingredient.category] = [];
                }
                groupedIngredients[ingredient.category].push(ingredient);
            }
            for (var i = 0; i < response.dryGoodsIngredients.length; i++) {
                var ingredient = response.dryGoodsIngredients[i];
                if (!groupedIngredients.hasOwnProperty(ingredient.category)) {
                    groupedIngredients[ingredient.category] = [];
                }
                groupedIngredients[ingredient.category].push(ingredient);
            }
            for (var i = 0; i < response.miscIngredients.length; i++) {
                var ingredient = response.miscIngredients[i];
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
                    html += '<div>';
                    html += '<input type="checkbox" id="' + ingredient.id + '" name="ingredient_name[]" value="' + ingredient.ingredient_name + '" />';
                    html += '<label for="' + ingredient.id + '">' + ingredient.ingredient_name + '</label>';
                    html += '<button id="delete_' + ingredient.id + '" class="deleteButton" onclick="deleteIngredient(' + ingredient.id + ')">Delete</button>';
                    html += '</div>';
                }
                html += '</fieldset>';
            }

            ingredientsDiv.innerHTML = html;
        }
    };
    xhr.send();
};

function deleteIngredient(ingredientId) {
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'delete_ingredient_list_handler.php', true);
    xhr.setRequestHeader('Content-Type', 'application/json');
    xhr.onreadystatechange = function () {
        if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
            console.log(xhr.responseText);
            //delete that bad boy
            var ingredientDiv = document.getElementById(ingredientId).parentNode;
            ingredientDiv.parentNode.removeChild(ingredientDiv);
        }
    };
    xhr.send(JSON.stringify({'ingredientId': ingredientId}));
}


// when the ingredient form is submitted, add the ingredient(s) to the database
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

//display ingredients needed
$(document).ready(function () {
    refreshIngredients();
    setInterval(refreshIngredients, 5000);
});

function refreshIngredients() {
    $.getJSON('get_ingredients_needed_handler.php', { refreshIngredients: true }, function (data) {
        $('#ingredientsTable tbody').empty();
        $.each(data, function (index, row) {
            var tr = $('<tr>');
            tr.append('<td>' + row.ingredient_name + '</td>');
            tr.append('<td>' + (row.is_needed ? 'Yes' : 'No') + '</td>');
            tr.append('<td>' + row.added_by_username + '</td>');
            tr.append('<td>' + row.date_added + '</td>');
            tr.append('<td><button class="delete" data-id="' + row.id + '">Delete</button></td>');
            $('#ingredientsTable tbody').append(tr);
        });
    });
}

$(document).ready(function () {
    refreshIngredients();
    setInterval(refreshIngredients, 5000);

    $('#ingredientsTable').on('click', '.delete', function () {
        var id = $(this).data('id');
        var tr = $(this).closest('tr');

        $.ajax({
            type: 'POST',
            url: 'delete_ingredient_handler.php',
            data: { ingredient_id: id },
            success: function () {
                tr.remove();
            }
        });
    });
});






