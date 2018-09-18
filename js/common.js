$(document).ready(function(){
   
   formSubmit('form-submit');
   
   loadSelection();
    
});

function formSubmit($id)
{
    var formId = '#' + $id;
    $(formId).submit(function(e){
        e.preventDefault();
        var data = $(this).serialize();
        $.ajax({
             url: 'index.php/save',
             data: data,
             type: 'POST',
             dataType: 'json'
        }).done(function(data){
            $(formId)[0].reset();
            console.log(data);
            loadSelection();
        }).fail(function(error){
            console.log('fail');
        }); 
    });
}

function loadSelection()
{
    $('#title-select').html('<option>Loading..</option>');
    
    $.ajax({
        url: 'index.php/load?select=title-select',
        type: 'GET',
        dataType: 'json'
   }).done(function(data){
        var $titleSelect = $('#title-select');
        $titleSelect.empty();
        $.each(data, function (index, item){
            $titleSelect.append($('<option>').text(item.title).attr('value', item.id));

        });
   });
}

function saveSearch(value, event)
{
    console.log(event.keyCode);
    
    if (event.keyCode === 46) {
        if(typeof(Storage) !== undefined) {
            console.log(value);
            localStorage.setItem('search', value);
        }
    }
}

function searchPost()
{
    if(typeof(Storage) !== undefined) {
        localStorage.setItem('search', $('#search-post').val());
    }
    $.ajax({
        url: 'index.php/load?select=search-post&search=' + $('#search-post').val(),
        type: 'GET',
        dataType: 'json'
   }).done(function(data){
       
       var html = '<ul>';
        $.each(data, function (index, item){
            html += '<li><a href="index.php/show?id=' + item.id + '">' + item.title + '</a></li>';
        });
        html += '</ul>';
        
        $('#list-post').html(html);
   });
}

