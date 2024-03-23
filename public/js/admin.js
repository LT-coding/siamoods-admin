$(function(){
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
