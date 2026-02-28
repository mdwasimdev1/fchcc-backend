@extends('backend.master')

@section('title', 'Category Page')

@section('content')
    <main class="content-body">

        <!-- Start - Page Title & Breadcrumb -->
        <div class="page-title">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('dashboard') }}">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">FAQ</li>
                </ol>
            </nav>
        </div>
        <!-- end - Page Title & Breadcrumb -->

        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-12">
                    <div class="row">

                        <!-- Start - Blog Category Add -->
                        <div class="col-xl-6">
                            <div class="card card-collapse">
                                <div class="card-header">
                                    <h4 class="card-title">Add FAQ</h4>
                                    <a class="collapse-indicator" data-bs-toggle="collapse" href="#collapseFilter"
                                        role="button" aria-expanded="false" aria-controls="collapseFilter">
                                        <i class="fa fa-angle-down"></i>
                                    </a>
                                </div>
                                <div class="collapsed collapse show" id="collapseFilter">
                                    {{-- Add FAQ Form --}}
                                    <div id="addFaqFormContainer">
                                        <form id="createfaq" action="{{ route('faq.store') }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="card-body">
                                                <div class="mb-3 d-flex flex-column">
                                                    <label class="form-label">Question ?</label>
                                                    <textarea name="que" id="add_que" cols="30" rows="2" class="form-control"></textarea>
                                                </div>
                                                <div class="mb-3 d-flex flex-column">
                                                    <label class="form-label">Answer</label>
                                                    <textarea name="ans" id="ans" cols="30" rows="5"
                                                        class="ck-editor form-control @error('ans') is-invalid @enderror"></textarea>
                                                </div>
                                                <div class="clearfix">
                                                    <button type="submit" class="btn btn-outline-primary">Save</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>

                                    {{-- Edit FAQ Form (Hidden by default) --}}
                                    <div id="editFaqFormContainer" style="display: none;">
                                        <form id="updatefaqform">
                                            @csrf
                                            <input type="hidden" name="id" id="edit_faq_id">
                                            <div class="card-body">
                                                <h5 class="mb-3 ">Edit FAQ</h5>
                                                <div class="mb-3 d-flex flex-column">
                                                    <label class="form-label">Question ?</label>
                                                    <textarea name="que" id="edit_que" cols="30" rows="2" class="form-control"></textarea>
                                                </div>
                                                <div class="mb-3 d-flex flex-column">
                                                    <label class="form-label">Answer</label>
                                                    <textarea name="ans" id="edit_ans" cols="30" rows="5" class="ck-editor-edit form-control"></textarea>
                                                </div>
                                                <div class="clearfix">
                                                    <button type="submit" class="btn btn-outline-primary">Update</button>
                                                    <button type="button" class="btn btn-outline-light"
                                                        id="cancelEdit">Cancel</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End -  FAQ Add -->

                        <!-- Start - FAQ Table -->
                        <div class="col-xl-6">
                            <div class="card card-collapse">
                                <div class="card-header">
                                    <h4 class="card-title">FAQ List</h4>
                                    <a class="collapse-indicator" data-bs-toggle="collapse" href="#collapseContactList"
                                        role="button" aria-expanded="false" aria-controls="collapseContactList">
                                        <i class="fa fa-angle-down"></i>
                                    </a>
                                </div>
                                <div class="collapsed collapse show" id="collapseContactList">
                                    <div class="card-body ">
                                        <div class="accordion" id="accordionExample">
                                            @forelse ($faqs as $key => $item)
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" style="display: flex;">
                                                        <button style="flex: 25; border-radius: 0;"
                                                            class="accordion-button {{ $key == 0 ? '' : 'collapsed' }}"
                                                            type="button" data-bs-toggle="collapse"
                                                            data-bs-target="#collapse{{ $item->id }}"
                                                            aria-expanded="{{ $key == 0 ? 'true' : 'false' }}"
                                                            aria-controls="collapse{{ $item->id }}">
                                                            <span>{{ $key + 1 . '.' }}</span>{{ $item->que }}
                                                        </button>
                                                        <button style="flex: 1; border-radius:0;padding: .8rem 1.25rem;"
                                                            onclick="editfaq({{ $item->id }})" type="button"
                                                            class="btn btn-primary"><i
                                                                class="fa-solid fa-pen-to-square"></i>
                                                        </button>
                                                        <button style="flex: 1; border-radius:0; padding: .8rem 1.25rem;"
                                                            type="button" class="btn btn-danger delete-item"
                                                            data-id="{{ $item->id }}"
                                                            data-url="{{ route('faq.destroy') }}">
                                                            <i class="fa-solid fa-trash"></i>
                                                        </button>
                                                        <button style="flex: 3; border-radius:0;padding: .8rem 1.25rem;"
                                                            type="button" onclick="statusfaq(this, {{ $item->id }})"
                                                            class="btn btn-{{ $item->status == 'active' ? 'success' : 'light' }} toggle-status">
                                                            {{ $item->status == 'active' ? 'Active' : 'Inactive' }}
                                                        </button>
                                                    </h2>

                                                    <div id="collapse{{ $item->id }}"
                                                        class="accordion-collapse collapse {{ $key == 0 ? 'show' : '' }}"
                                                        data-bs-parent="#accordionExample">
                                                        <div class="accordion-body">
                                                            {!! $item->ans !!}
                                                        </div>
                                                    </div>

                                                </div>
                                            @empty
                                                <div class="alert alert-info">
                                                    No Data Found
                                                </div>
                                            @endforelse
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End - Blog Category Table -->

                    </div>
                </div>
            </div>
        </div>

    </main>



@endsection

@push('scripts')
    <script src="//code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/23.0.0/classic/ckeditor.js"></script>

    <script>
        let addEditor;
        let editEditor;

        // Initialize Add Form Editor
        ClassicEditor
            .create(document.querySelector('#ans'), {
                removePlugins: ['CKFinderUploadAdapter', 'CKFinder'],
                height: '500px'
            })
            .then(editor => {
                addEditor = editor;
            })
            .catch(error => {
                console.error(error);
            });

        // Initialize Edit Form Editor
        ClassicEditor
            .create(document.querySelector('#edit_ans'), {
                removePlugins: ['CKFinderUploadAdapter', 'CKFinder'],
                height: '500px'
            })
            .then(editor => {
                editEditor = editor;
            })
            .catch(error => {
                console.error(error);
            });
    </script>
    <script>
        function statusfaq(btn, id) {
            let $btn = $(btn);
            $.ajax({
                url: "{{ route('faq.status') }}",
                type: "POST",
                data: {
                    id: id,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    if (response.success) {
                        if ($btn.hasClass('btn-success')) {
                            $btn.removeClass('btn-success').addClass('btn-light').text('Inactive');
                        } else {
                            $btn.removeClass('btn-light').addClass('btn-success').text('Active');
                        }
                        toastr.success(response.message);
                    }
                },
                error: function(xhr) {
                    toastr.error("Something went wrong!");
                    console.error(xhr.responseText);
                }
            });
        }

        function editfaq(id) {
            $.ajax({
                url: "{{ route('faq.get') }}",
                type: "GET",
                data: {
                    id: id
                },
                success: function(response) {
                    $('#edit_faq_id').val(response.id);
                    $('#edit_que').val(response.que);
                    editEditor.setData(response.ans);

                    $('#addFaqFormContainer').hide();
                    $('#editFaqFormContainer').show();

                    // Scroll to form
                    $('html, body').animate({
                        scrollTop: $("#collapseFilter").offset().top - 100
                    }, 500);
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                }
            });
        }

        $('#cancelEdit').on('click', function() {
            $('#editFaqFormContainer').hide();
            $('#addFaqFormContainer').show();
        });

        $('#updatefaqform').on('submit', function(e) {
            e.preventDefault();
            let formData = {
                id: $('#edit_faq_id').val(),
                que: $('#edit_que').val(),
                ans: editEditor.getData(),
                _token: "{{ csrf_token() }}"
            };

            $.ajax({
                url: "{{ route('faq.update') }}",
                type: "POST",
                data: formData,
                success: function(response) {
                    if (response.success) {
                        let id = $('#edit_faq_id').val();
                        let newQue = $('#edit_que').val();
                        let newAns = editEditor.getData();

                        // Update the FAQ in the list
                        let $item = $(`#collapse${id}`).closest('.accordion-item');
                        $item.find('.accordion-button').html(
                            `<span>${$item.index() + 1}.</span>${newQue}`);
                        $item.find('.accordion-body').html(newAns);

                        // Switch back to Add form
                        $('#editFaqFormContainer').hide();
                        $('#addFaqFormContainer').show();

                        // Clear add form
                        $('#add_que').val('');
                        addEditor.setData('');
                    }
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                    alert('Update failed');
                }
            });
        });
    </script>
@endpush
