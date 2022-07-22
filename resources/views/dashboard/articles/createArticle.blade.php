@extends('layout.dashboard')

@section('title', 'Create Article')

@section('css')
    <!-- TinyMCE -->
    <script src="https://cdn.tiny.cloud/1/cqgh3hqnsj8hp4ebyxgxqzd4t2s9r4zlx59egrxq33l0btqp/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
@endsection

@section('main')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h1 class="m-0">Create Articles</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">Home</li>
                        <li class="breadcrumb-item">Articles</li>
                        <li class="breadcrumb-item active">Create</li>
                    </ol>
                </div>
            </div>
            <div class="row mt-3">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <form>
                                    <div class="input-group mb-3">
                                        <input id="titleForm" type="text" name="title" class="form-control" placeholder="Title">
                                        <div class="input-group-append">
                                            <div class="input-group-text">
                                                <span class="fas fa-envelope"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="input-group mb-3">
                                        <textarea id="tiny" class="form-control" name="content"></textarea>
                                    </div>
                                    <div class="input-group mb-3">
                                        <input id="imageForm" type="text" name="image" class="form-control" placeholder="Image Link">
                                        <div class="input-group-append">
                                            <div class="input-group-text">
                                                <span class="fas fa-envelope"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="input-group mb-3">
                                        <input id="categoryForm" type="number" name="category_id" class="form-control" placeholder="Category ID">
                                        <div class="input-group-append">
                                            <div class="input-group-text">
                                                <span class="fas fa-envelope"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <a onclick="createArticle()" class="btn btn-primary btn-block">Create Article</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script>
        $(document).ready( () => {
            tinymce.init({
                plugins: 'autoresize',
                selector: 'textarea#tiny',
                plugins: [
                    'a11ychecker','advlist','advcode','advtable','autolink','checklist','export',
                    'lists','link','image','charmap','preview','anchor','searchreplace','visualblocks',
                    'powerpaste','fullscreen','formatpainter','insertdatetime','media','table','help','wordcount'
                ],
                toolbar: 'undo redo | a11ycheck casechange blocks | bold italic backcolor | alignleft aligncenter alignright alignjustify |' +
                'bullist numlist checklist outdent indent | removeformat | code table help',
                resize: false,
                menubar: false,
            });

            createArticle = () => {
                let token = `{{ Cookie::get('access_token') }}`;
                tinymce.triggerSave();

                $.ajax({
                    url: '/api/v1/articles/create',
                    type: 'POST',
                    dataType: 'JSON',
                    contentType: 'application/json',
                    beforeSend: function(request) {
                        request.setRequestHeader("Authorization", "Bearer "+token);
                    },
                    data: JSON.stringify({
                        title: $('#titleForm').val(),
                        content: $('#tiny').val().toString(),
                        image: $('#imageForm').val(),
                        category_id: $('#categoryForm').val(),
                    }),
                }).done( (response) => {
                    window.alert(response.message);
                }).fail( (error) => {
                    console.log(error);
                    window.alert(error.responseJSON.message);
                });
            }
        });
    </script>
@endsection