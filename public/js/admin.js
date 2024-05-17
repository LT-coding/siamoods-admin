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

    $(document).on('keyup','#gift',function(){
        if ($(this).val().length >= 3) {
            searchAjax($(this).val(),$(this).data('url'))
        }
    });

    $(document).on('focusout','#gift',function(){
        if ($('.product-zero').length > 0) {
            $('#gift').val('');
            $('.product-gifts').hide();
            $('#gift_val').val('');
        }
    });

    $(document).on('click','.prod-gift li',function(){
        $('#gift_val').val($(this).data('id'));
        $('#gift').val($(this).find('p').text());
        $('.product-gifts').hide();
    })

    $(document).on('click','.labels-list .label-display',function(){
        $('.label-display').removeClass('active');
        $(this).addClass('active');
    })

    $(document).on('click','.remove-label',function(e){
        e.preventDefault();
        $('.label-display').removeClass('active');
        $('.labels-list input').prop('checked',false);
    })

    $(document).on('click','.remove-gift',function(e){
        e.preventDefault();
        $('#gift').val('');
        $('#gift_val').val('');
    })

    $(document).on('focusout ', '.review-input', function () {
        tableAjax($(this));
    })

    $(document).on('change', '.review-select', function () {
        tableAjax($(this));
    })

    $(document).on('click','.free-shipping',function(){
        if (!$(this).is(':checked')) {
            let url = $(this).data('url');
            let k = $(this).closest('.shipping-item').data('id');
            shippingAjax(url,$(this),k);
        } else {
            $(this).closest('.shipping-item').find('.shipping-rate .rate-item').remove();
        }
    })

    $(document).on('click','.add-rate',function(){
        let url = $(this).data('url');
        let k = $(this).closest('.shipping-item').data('id');
        shippingAjax(url,$(this),k);
    })

    //chart
    const monthsInArmenian = {
        1: "Հունվար",
        2: "Փետրվար",
        3: "Մարտ",
        4: "Ապրիլ",
        5: "Մայիս",
        6: "Հունիս",
        7: "Հուլիս",
        8: "Օգոստոս",
        9: "Սեպտեմբեր",
        10: "Հոկտեմբեր",
        11: "Նոյեմբեր",
        12: "Դեկտեմբեր",
    };
    let chart;
    function getData(year) {
        $.ajax({
            url: "admin/getChartData",
            type: "GET",
            data: {
                year,
            },
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            },
            success: function (data) {
                const filledData = fillMissingMonths(data);
                const dataWithArmenianMonths = filledData.map((item) => ({
                    ...item,
                    month: monthsInArmenian[item.month],
                }));

                const seriesData = filledData.map((item) => parseInt(item.total, 10));
                const xasisData = dataWithArmenianMonths.map((item) => item.month);

                let options = {
                    chart: {
                        type: "line",
                    },
                    series: [
                        {
                            name: "Վաճառք",
                            data: seriesData,
                        },
                    ],
                    xaxis: {
                        categories: xasisData,
                    },
                };

                if (chart) {
                    chart.destroy();
                }

                chart = new ApexCharts(document.querySelector("#chart"), options);
                chart.render();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert("there is problem with chart data");
            },
        });
    }

    $(document).on("change", "#yearSelect", function () {
        getData($(this).val());
    });
    const currentDate = new Date();
    const currentYear = currentDate.getFullYear();
    if ($("#chart").length) {
        getData(currentYear);
    }

    function fillMissingMonths(data) {
        // Create an object to store the data by month
        const dataByMonth = {};
        // Convert the "total" values to numbers
        data.forEach((item) => {
            item.total = parseInt(item.total, 10);
            dataByMonth[item.month] = item.total;
        });
        // Find the range of months (e.g., 1 to 12)
        const minMonth = 1;
        const maxMonth = 12;
        // Create an array of missing months with a total value of 0
        const missingMonths = [];
        for (let month = minMonth; month <= maxMonth; month++) {
            if (dataByMonth[month] === undefined) {
                missingMonths.push({ month, total: 0 });
            }
        }
        // Merge the missing months with the existing data
        const result = [...data, ...missingMonths];
        // Sort the result by month
        result.sort((a, b) => a.month - b.month);
        return result;
    }
});
function searchAjax(input,url){
    const csrfToken = $('meta[name="csrf-token"]').attr('content');
    $.ajax({
        url: url+'/'+input,
        type: "GET",
        processData: false,
        contentType: false,
        headers: {
            "X-CSRF-TOKEN": csrfToken // Include the CSRF token in the request headers
        },
        success: function(data){
            $('#gift_types').html(data['view'])
        },
        error: function (jqXHR, textStatus, errorThrown)
        {}
    });
}
function tableAjax(input) {
    let form = input.closest('form')[0];
    const data = new FormData(form);
    let url = input.closest('form').attr('action');
    const csrfToken = $('meta[name="csrf-token"]').attr('content');

    $.ajax({
        url: url,
        type: "PUT",
        data: data,
        processData: false,
        contentType: false,
        headers: {
            "X-CSRF-TOKEN": csrfToken // Include the CSRF token in the request headers
        },
        success: function (data, textStatus, jqXHR) {
        },
        error: function (jqXHR, textStatus, errorThrown) {
        }
    });
}
function shippingAjax(url, item, k=null){
    const csrfToken = $('meta[name="csrf-token"]').attr('content');
    $.ajax({
        url: url+'/'+k,
        type: "GET",
        processData: false,
        contentType: false,
        headers: {
            "X-CSRF-TOKEN": csrfToken
        },
        success: function(data){
            if (data['type'] === 1) {
                item.closest('.shipping-item').find('.shipping-rate').html(data['view'])
                item.closest('.shipping-item').find('.shipping-rate .add-rate').trigger('click')
            } else {
                item.closest('.shipping-item').find('.shipping-option').append(data['view'])
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {}
    });
}
