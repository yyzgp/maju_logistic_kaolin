@extends('layouts.administrator')
@section('title', 'Edit Page')
@section('head')
    <link href="{{ asset('assets/js/plugins/intl-tel-input/css/intlTelInput.min.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
    <!-- Start Content-->
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <a href="{{ url()->previous() }}" class="btn btn-sm btn-dark me-1"><i
                                class="mdi mdi-chevron-double-left me-1"></i>Back</a>
                        <button type="submit" class="btn btn-sm btn-danger" form="driverForm"><i
                                class="mdi mdi-database me-1"></i>Update</button>
                    </div>
                    <h4 class="page-title">Edit Page</h4>
                </div>
            </div>
        </div>
        @include('administrator.includes.flash-message')
        <!-- end page title -->
        <div class="row">
            <div class="col-12">
                <form id="driverForm" method="POST" action="{{ route('administrator.pages.update', $page->id) }}"
                    enctype="multipart/form-data" autocomplete="off">
                    @csrf
                    @method('PUT')
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12 mb-2">
                                    <h4 class="text-dark">Page Details</h4>
                                </div>
                                <div class="col-sm-12 mb-2 {{ $errors->has('name') ? 'has-error' : '' }}">
                                    <label class="col-form-label" for="name">Name</label>
                                    <input type="text" class="form-control" id="name" name="name"
                                        placeholder="Enter Page Name" value="{{ old('name', $page->name) }}" autofocus>
                                    @error('name')
                                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-sm-12 mb-2 {{ $errors->has('content') ? 'has-error' : '' }}">
                                    <label class="col-form-label" for="content">Content</label>
                                    <textarea id="content" class="form-control @error('content') is-invalid @enderror" name="content"
                                        placeholder="Write Content here">{{ old('content', $page->content) }}</textarea>
                                    @error('content')
                                        <span id="content-error" class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-sm-12 mb-2 {{ $errors->has('extras') ? 'has-error' : '' }}">
                                    <label class="col-form-label" for="extras">Exras</label>
                                    <textarea id="extras" class="form-control @error('extras') is-invalid @enderror" name="extras"
                                        placeholder="Write Extras here">{{ old('extras', $page->extras) }}</textarea>
                                    @error('extras')
                                        <span id="extras-error" class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-sm-12 mb-2 {{ $errors->has('meta_title') ? 'has-error' : '' }}">
                                    <label class="col-form-label" for="meta_title">Meta Title</label>
                                    <input type="text" class="form-control" id="meta_title" name="meta_title"
                                        placeholder="Enter Page Meta Title" value="{{ old('meta_title', $page->meta_title) }}">
                                    @error('meta_title')
                                        <span id="meta_title-error" class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-sm-12 mb-2 {{ $errors->has('meta_description') ? 'has-error' : '' }}">
                                    <label class="col-form-label" for="meta_description">Meta Description</label>
                                    <textarea id="meta_description" class="form-control @error('meta_description') is-invalid @enderror"
                                        name="meta_description" placeholder="Write Meta Description here">{{ old('meta_description', $page->meta_description) }}</textarea>
                                    @error('meta_description')
                                        <span id="meta_description-error"
                                            class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-sm-12 mb-2 {{ $errors->has('meta_keywords') ? 'has-error' : '' }}">
                                    <label class="col-form-label" for="meta_keywords">Meta Keywords</label>
                                    <input type="text" class="form-control" id="meta_keywords" name="meta_keywords"
                                        placeholder="Enter Page Meta Keywords" value="{{ old('meta_keywords', $page->meta_keywords) }}">
                                    @error('meta_keywords')
                                        <span id="meta_keywords-error"
                                            class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-sm-6">
                                    <label class="col-form-label" for="banner">Banner</label>
                                    <div class="input-group">
                                        <input type="file" class="form-control" id="banner" name="banner"
                                            onchange="loadPreview(this);">
                                    </div>
                                    @if ($errors->has('banner'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('banner') }}</strong>
                                        </span>
                                    @endif
                                    <img id="preview_img" src="{{ $page->banner }}"
                                        class="mt-2" width="100" height="100" />
                                </div>
                            </div>

                        </div>
                        <div class="card-footer text-end">
                            <a href="{{ url()->previous() }}" class="btn btn-sm btn-dark me-1"><i
                                    class="mdi mdi-chevron-double-left me-1"></i>Back</a>
                            <button type="submit" class="btn btn-sm btn-danger" form="driverForm"><i
                                    class="mdi mdi-database me-1"></i>Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div> <!-- container -->
@endsection
@push('scripts')
    <script>
        function loadPreview(input, id) {
            id = id || '#preview_img';
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $(id)
                        .attr('src', e.target.result)
                        .width(100)
                        .height(100);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>

    <script src="{{ asset('assets/js/tinymce/tinymce.min.js') }}"></script>
    <script>
        tinymce.init({
            selector: 'textarea#content',
            height: 1800,
            menubar: false,
            plugins: [
                'a11ychecker', 'advlist', 'advcode', 'advtable', 'autolink', 'checklist', 'export',
                'lists', 'link', 'image', 'charmap', 'preview', 'anchor', 'searchreplace', 'visualblocks',
                'powerpaste', 'fullscreen', 'formatpainter', 'insertdatetime', 'media', 'table', 'help',
                'wordcount'
            ],
            toolbar: 'undo redo | a11ycheck casechange blocks | bold italic backcolor | alignleft aligncenter alignright alignjustify |' +
                'bullist numlist checklist outdent indent | removeformat | code table help'
        })
    </script>
@endpush
