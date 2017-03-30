$(function(){


    // Set language
    $(document).on('click','.language',function(){
        var lang = $(this).attr('id');

        $.post('index.php?r=site/language',{'lang':lang},function(data){
           // console.log('Language changed to '. lang);
            location.reload();
        });
    });

    // get the click of the create button
    $('#modalButton').click(function (){
        $('#modal').modal('show')
            .find('#modalContent')
            .load($(this).attr('value'));
    });


/*
    // Create event if lick day in full calendar
    $(document).on('click','.fc-day',function(){
        var date = $(this).attr('data-date');

        $.get('index.php?r=event/create',{'date':date},function(data){
            console.log('Create event by date');
            $('#modal').modal('show')
                .find('#modalContent')
                .html(data);
        });
    });

    // Update event by title if lick day in full calendar
    $(document).on('click','.fc-day-grid-event .fc-content',function(){

        var title = $.trim($(this).text());

        $.get('index.php?r=event/update-by-title',{'title':title},function(data){

            console.log('Update event by title');
            $('#modal').modal('show')
                .find('#modalContent')
                .html(data);
        });

    });
*/

});