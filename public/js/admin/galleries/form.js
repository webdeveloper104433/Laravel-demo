$(document).ready(function() {
	$('#save_btn').click(function() {

        var data = $("#gallery_form").serialize();
        
        $(".spinner").show();
        $.ajax({
            type: 'POST',
            url: $("#gallery_form").attr("action"),
            dataType: 'json',
            data: data,
            success: function(data) {
                var gallery = data.gallery;
                method(gallery.id,"https://photos.app.goo.gl/" + gallery.google_link);
            }
        });
    });
})