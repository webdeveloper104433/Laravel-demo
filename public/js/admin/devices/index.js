$(document).ready(function() {
	$('.btn-device-delete').click(function() {
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
                    $("#device_delete_form").attr("action", $("#device_delete_form").data('current_url') + "/" + selectedId);
                    $("#device_delete_form").submit();
                }
            }
        });
    });
});