$(document).ready(function () {
	$('.btn-flow-delete').click(function() {
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
                    $("#flow_delete_form").attr("action", $("#flow_delete_form").data("current_url") + "/" + selectedId);
                    $("#flow_delete_form").submit();
                }
            }
        });
    });
});