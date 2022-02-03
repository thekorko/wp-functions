/*
ajax upvote example ver 0.1
Lacks validation/sanitization
https://developer.wordpress.org/plugins/javascript/ajax/
TheKorko
https://quartex.net
*/
jQuery(document).ready(function($) {    //wrapper
    $(".upvote").click(function() {     //event
        let this2 = this;                  //use in callback
        let post_id = this.value;
        $.post(my_ajax_obj.ajax_url, {     //POST request
            _ajax_nonce: my_ajax_obj.nonce, //nonce
            type: "POST",                   //Request type
            action: "upvote_post",        //action
            post_id: post_id,             //data
        }, function(data) {
            let elemento = `post-karma-${post_id}`;
            //console.log(elemento);
            let post_karma = document.getElementById(elemento);
            post_karma.innerHTML = data;      //insert server response
        });
    });
});
