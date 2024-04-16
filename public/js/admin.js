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

    $(document).on('click', '.sub-open', function () {
        let id = $(this).closest('li').data('id');
        let level = $("ul li[data-id='level-" + id + "']");
        level.toggle();
        $(this).toggleClass('sub-closed')
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

    $(document).on('change', '.pro-type-select', function () {
        let value = $(this).val();
        $('.pro-type').hide().find('input').attr('name', '');
        $('.pro-type-' + value).show().find('input').attr('name', 'value');
    });

    $(document).on('change','.label-type',function(e){
        $('.preview-label').hide().find('.img_preview-label').attr('src','');
        $('.preview-text').hide();
        $('#label-image').val('');
        $('.lb-text').val('');
        $('.label-input').val('');
        if($(this).val() == 0){
            $('.graph-label').show();
            $('.text-label').hide();
        }else{
            $('.graph-label').hide();
            $('.text-label').show();
        }
    });

    $(document).on('keyup','.label-input',function(){
        $('.preview-text').show().find('.lb-text').text($(this).val())
    })

    $(document).on('change','.label-type-select',function(){
        let i=$(this).val();
        $('.pr-label').attr('class','pr-label').addClass('label-position-'+i)

    })
    $(document).on('change','#label-image',function (e){
        let file=URL.createObjectURL(e.target.files[0]);
        $('.preview-label').show().find('.img_preview-label').attr('src',file);
    })

    $(document).on('change','.txt-color',function (){
        $('.lb-text').css('color',$(this).val());
    })


    $(document).on('change','.bg-color',function (){
        $('.lb-text').css('background-color',$(this).val());
    })

    $(document).on('change','#label-image',function (e){
        let file=URL.createObjectURL(e.target.files[0]);
        $('.preview-label').show().find('.img_preview-label').attr('src',file);
    })
});
