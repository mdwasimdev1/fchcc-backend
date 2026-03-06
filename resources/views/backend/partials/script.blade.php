<!-- jQuery (ONLY ONCE) -->
<script src="{{ asset('backend/app-assets/vendor/jquery/dist/jquery.min.js') }}"></script>

<!-- Bootstrap -->
<script src="{{ asset('backend/app-assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>

<!-- Plugins -->
<script src="{{ asset('backend/app-assets/vendor/metismenu/dist/metisMenu.min.js') }}"></script>
<script src="{{ asset('backend/app-assets/vendor/bootstrap-select/dist/js/bootstrap-select.min.js') }}"></script>
<script src="{{ asset('backend/app-assets/vendor/@yaireo/tagify/dist/tagify.js') }}"></script>

<!-- Swiper -->
<script src="{{ asset('backend/app-assets/vendor/swiper/swiper-bundle.min.js') }}"></script>

<!-- Charts -->
<script src="{{ asset('backend/app-assets/vendor/apexcharts/dist/apexcharts.min.js') }}"></script>

<!-- Vector Map -->
<script src="https://cdn.jsdelivr.net/npm/jsvectormap"></script>
<script src="https://cdn.jsdelivr.net/npm/jsvectormap/dist/maps/world.js"></script>

<!-- Dashboard -->
<script src="{{ asset('backend/app-assets/js/dashboard/dashboard.js') }}"></script>

<!-- Translator -->
<script src="{{ asset('backend/app-assets/vendor/i18n/i18n.js') }}"></script>
<script src="{{ asset('backend/app-assets/js/translator.js') }}"></script>

<!-- Custom JS (AFTER plugins) -->
<script src="{{ asset('backend/app-assets/js/custom.js') }}"></script>
<script src="{{ asset('backend/app-assets/js/icnav-init.js') }}"></script>

<!-- DataTables -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<!-- Dropify -->
<script src="https://cdn.jsdelivr.net/npm/dropify/dist/js/dropify.min.js"></script>

<!-- Toastr JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

{{-- Toastr --}}
<script>
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    };

    @if (Session::has('success'))
        toastr.success("{{ Session::get('success') }}");
    @endif

    @if (Session::has('error'))
        toastr.error("{{ Session::get('error') }}");
    @endif

    @if (Session::has('info'))
        toastr.info("{{ Session::get('info') }}");
    @endif

    @if (Session::has('warning'))
        toastr.warning("{{ Session::get('warning') }}");
    @endif
</script>


<script>
    $(document).ready(function() {
        if ($.fn.dropify) {
            $('.dropify').dropify();
        }
    });
</script>

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>

<script>
    document.getElementById('themeToggle')?.addEventListener('click', function() {
        fetch("{{ route('theme.toggle') }}", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute("content")
            }
        }).then(() => location.reload());
    });
</script>

{{-- Common sweetalart for status Update --}}
<script>
    $(document).on('change', '.status-toggle', function() {

        let toggle = $(this);
        let id = toggle.data('id');
        let model = toggle.data('model');
        let url = toggle.data('url');

        let status = toggle.is(':checked') ? 1 : 0;

        Swal.fire({
            title: "Are you sure?",
            text: "You want to change the status?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, change it!"
        }).then((result) => {

            if (result.isConfirmed) {

                $.ajax({
                    url: url,
                    type: "POST",
                    data: {
                        id: id,
                        model: model,
                        status: status,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {

                        if (response.success) {
                            toastr.success(response.message);
                        } else {
                            toggle.prop('checked', !toggle.prop('checked'));
                            toastr.error(response.message);
                        }
                    },
                    error: function() {
                        toggle.prop('checked', !toggle.prop('checked'));
                        toastr.error("Something went wrong!");
                    }
                });

            } else {
                toggle.prop('checked', !toggle.prop('checked'));
            }

        });

    });
</script>

{{-- Common Sweetalart for delete --}}

<script>
    $(document).on('click', '.delete-item', function(e) {
        e.preventDefault();

        let button = $(this);
        let id = button.data('id');
        let url = button.data('url');
        let tableSelector = button.data('table') || '#myTable';

        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {

            if (result.isConfirmed) {

                button.prop('disabled', true);

                $.ajax({
                    url: url,
                    type: "DELETE",
                    data: {
                        id: id,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },

                    success: function(response) {

                        if (response.success) {

                            toastr.success(response.message);
                            if ($.fn.DataTable.isDataTable(tableSelector)) {
                                $(tableSelector).DataTable().ajax.reload(null, false);
                            } else {
                                button.closest('tr').remove();
                            }

                        } else {
                            toastr.error(response.message);
                            button.prop('disabled', false);
                        }
                    },

                    error: function(xhr) {
                        toastr.error("Something went wrong!");
                        button.prop('disabled', false);
                    }
                });

            }

        });

    });
</script>


{{-- Common Edit js --}}

<script>
    $(document).on('click', '.btn-edit', function() {

        let btn = $(this);

        let url = btn.data('url');
        let target = btn.data('target'); // edit container id

        $.get(url, function(response) {

            // Auto fill form fields
            $.each(response, function(key, value) {
                $('#edit_' + key).val(value);
            });

            $('.add-container').hide();
            $(target).show();

            $('html, body').animate({
                scrollTop: $(target).offset().top - 100
            }, 500);
        });
    });


    $(document).on('submit', '.ajax-update-form', function(e) {

        e.preventDefault();

        let form = $(this);
        let url = form.data('url');
        let formData = new FormData(this);

        $.ajax({
            url: url,
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {

                if (response.success) {

                    $('.edit-container').hide();
                    $('.add-container').show();

                    if (typeof table !== "undefined") {
                        table.ajax.reload(null, false);
                    }

                    alert(response.message);
                }
            },
            error: function(xhr) {

                let errors = xhr.responseJSON.errors;
                if (errors) {
                    alert(Object.values(errors)[0][0]);
                }
            }
        });
    });


    $(document).on('click', '.btn-cancel-edit', function() {
        $('.edit-container').hide();
        $('.add-container').show();
    });
</script>
