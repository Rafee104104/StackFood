@push('script_2')

<script>
$(document).ready(function () {

    // Search form (AJAX)
    $('#dataSearch').on('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);

        $.post({
            url: "{{ route('admin.category.search') }}",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function(data) {
                $('#table-div').html(data.view);
                $('#itemCount').html(data.count);
                $('.page-area').hide();
            }
        });
    });

    // Select2 init
    $('.js-select2-custom').each(function () {
        $.HSCore.components.HSSelect2.init($(this));
    });
});

// Toggle status with confirmation
$(document).on('change', '.toggle-category-status', function () {
    const checkbox = $(this);
    const url = checkbox.data('url');

    Swal.fire({
        title: 'Change status?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Yes',
        cancelButtonText: 'No'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = url;
        } else {
            checkbox.prop('checked', !checkbox.prop('checked'));
        }
    });
});

// Delete category
$(document).on('click', '.delete-category', function () {
    if (typeof form_alert !== 'function') return;
    form_alert($(this).data('id'), $(this).data('message'));
});

// Image preview
function readURL(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => $('#viewer').attr('src', e.target.result);
        reader.readAsDataURL(input.files[0]);
    }
}

$('#customFileEg1').on('change', function () {
    readURL(this);
});

// Language tabs
$('.lang_link').on('click', function (e) {
    e.preventDefault();
    $('.lang_link').removeClass('active');
    $('.lang_form').addClass('d-none');

    $(this).addClass('active');
    const lang = this.id.replace('-link', '');
    $('#' + lang + '-form').removeClass('d-none');
});
</script>

@endpush
