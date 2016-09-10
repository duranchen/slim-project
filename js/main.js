/**
 * Created by duranchen on 9/5/16.
 */

// The root URL for the RESTful services
var apiURL = "http://api.slimproject.dev";

var currentWine;

findAll();

$('#btn-search').click(function () {

    search($('#search-key').val());

    return false;

});

$('#btn-add').click(function () {
    newWine();
    return false;
});

$('#btn-delete').hide();

$('#wine-list').on('click', 'a', function () {
    findById($(this).data('identity'));
});

$('#btn-save').click(function () {

    if ($('#wine-id').val() == '') {

        addWine();
    }

    return false;
});


function search(searchKey) {
    if (searchKey == '') {
        findAll();
    } else {
        findByName(searchKey);
    }
}


function findAll() {
    $.ajax({
        type: 'GET',
        url: apiURL,
        dataType: "json",
        success: renderList
    })
}


function findById(id) {

    $.ajax({
        type: 'GET',
        url: apiURL + '/wine/' + id,
        dataType: "json",
        success: function (data) {
            renderDetails(data);
        }
    })
}

function renderDetails(wine) {
    $('#wine-id').val(wine.id);
    $('#name').val(wine.name);
    $('#grapes').val(wine.grapes);
    $('#country').val(wine.country);
    $('#region').val(wine.region);
    $('#year').val(wine.year);
    $('#pic').attr('src', 'pics/' + wine.picture);
    $('#description').val(wine.description);
}

function findAll() {
    $.ajax({
        type: 'GET',
        url: apiURL + '/wines',
        dataType: "json",
        success: renderList
    })
}

function renderList(data) {
    var list = data == null ? [] : (data instanceof  Array ? data : [data]);

    $('#wine-list li').remove();
    $.each(list, function (index, wine) {
        $('#wine-list').append('<li><a href="#" data-identity="' + wine.id + '">' + wine.name + '</a> </li>');
    })
}

function findByName(searchKey) {
    $.ajax({
        type: 'GET',
        url: apiURL + '/wines/search/' + searchKey,
        dataType: "json",
        success: renderList

    });
};

$('#search-key').keypress(function (e) {
    if (e.which == 13) {
        search($('#search-key').val());
        e.preventDefault();
        return false;
    }
    ;
});


function newWine() {
    $('#btn-delete').hide();
    currentWine = {picture: "generic.jpg"};
    renderDetails(currentWine);
};

function addWine(){

    $.post({
        type: 'POST',
        url: apiURL + '/wine',
        contentType: 'application/json',
        dataType: "json",
        data: formToJson(),
        success: function (data, textStatus, jqXHR) {
            alert("Wine created successfully!");
            $('#btn-delete').show();
            $('#wine-id').val(data.id);
        },
        error: function (jqXHR, textStatus, errorThrow) {
            alert('addWine error: ' + textStatus);
        }

    })


}

function formToJson() {
    return JSON.stringify(
        {
            "id": $('#wine-id').val(),
            "name": $('#name').val(),
            "grapes": $('#grapes').val(),
            "country": $('#country').val(),
            "region": $('#region').val(),
            "year": $('#year').val(),
            "picture": $('#picture').val(),
            "description": $('#description').val()
        }
    );
}
