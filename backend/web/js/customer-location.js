$(function(){

    $('#zipCode').change(function(){

        var zipCode = $(this).val();

         $.get('index.php?r=location/get-location',{ zipCode : zipCode },function(data){

             var location = $.parseJSON(data);

             $('#customer-city').val(location.city);
             $('#customer-province').val(location.province);
         });
    });
});