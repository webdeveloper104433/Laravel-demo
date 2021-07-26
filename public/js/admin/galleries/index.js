$(document).ready(function() {
	$('.btn-gallery-delete').click(function() {
        var selectedId = $(this).data("id");
        bootbox.confirm({
            message: "Are you sure you want to delete it?",
            buttons: {
                confirm: {
                    label: 'Yes',
                    className: 'btn-success'
                },
                cancel: {
                    label: 'No',
                    className: 'btn-danger'
                }
            },
            callback: function (result) {
                if (result === true) {
                    $("#gallery_delete_form").attr("action", $("#gallery_delete_form").data('current_url') + "/" + selectedId);
                    $("#gallery_delete_form").submit();
                }
            }
        });
    });
})