jQuery(document).ready(function($){
    let search_form = $('#my_search_form');
    
    search_form.submit(function(event){
        event.preventDefault();
        let search_term = $('#my_search_term').val();
        let form_data = new FormData();
        form_data.append('action', 'my_search_fun');
        form_data.append('search_term', search_term);
        // console.log(search_term);
        // alert(search_term);

        $.ajax({
            url:  ajaxurl,
            type: 'post',
            data:  form_data,
            processData: false,
            contentType: false,
            success: function(response){
                //console.log(response);
                $('#my-table-result').html(response);
            },
            error: function(){
                console.log(error);
            }
        });
    });
});
