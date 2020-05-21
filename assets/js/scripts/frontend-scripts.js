jQuery(document).ready(function ($){
    console.log('WPBP loaded');
    
    let form_data = {
            nonce: 'nonce_string_here',
        },
        action = 'wpbp_ajax_example';

    fetch(wpbp_data.ajax_url + '?action=' + action, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(form_data)
    }).then(function(result) {
        result.json().then(function(response) {
            console.log('ajax response');
            console.log(response);
        });
    });
});
