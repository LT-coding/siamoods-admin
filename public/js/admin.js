$(function(){
    let hash = window.location.hash;
    hash && $('.nav-link[href="' + hash + '"]').tab('show');
    let invalid = $('.is-invalid');
    if (invalid.length > 0) {
        if(invalid.closest('.tab-pane').length > 0) {
            let tab_hash = invalid.closest('.tab-pane').attr('id')
            $('.nav-link[href="#' + tab_hash + '"]').tab('show');
        }
        if(invalid.closest('.collapse').length > 0) {
            invalid.closest('.collapse').collapse()
        }
    }

    $('.customization-tabs a').click(function(){
        let id = $(this).attr('id').replace("-tab", "");
        $('#page').val(id)
    })

    $(document).on('click', '.btn-remove', function (e) {
        e.preventDefault()
        let action = $(this).data('action')
        $('.form-remove').attr('action', action).submit()
    })

    $(document).on('change', '.status-change', function (e) {
        e.preventDefault()
        let form = $('.form-status')
        let id = $(this).data('id'),
            s = $(this).val(),
            t = form.find('[name=_token]').val(),
            url = form.attr('action') + '/' + id;
        $.ajax({
            url: url,
            type: 'PUT',
            data: {_token: t, status: s},
            success: function (result) {}
        });
    })
});
