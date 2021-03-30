@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-info">
                <div class="panel-heading">{{$title}}</div>
                <div class="panel-wrapper collapse in" aria-expanded="true">
                    <div class="panel-body">
                        <form method="post" action="{{ $route."/".$data->id }}" enctype="multipart/form-data">
                            @csrf
                            @method("PUT")

                            <div class="form-group">
                                <label for="title">Title <strong class="text-danger"> &#42; </strong> </label>
                                @error('title')
                                <p class="invalid-feedback text-danger" role="alert"><strong>{{ $message }}</strong></p>
                                @enderror
                                <input type="text" class="form-control" id="title"
                                       placeholder="Title" name="title" value="{{$data->title}}" required>
                            </div>

                            <div class="form-group">
                                <label for="description">Description <strong class="text-danger">
                                        &#42; </strong></label>
                                @error('description')
                                <p class="invalid-feedback text-danger" role="alert"><strong>{{ $message }}</strong></p>
                                @enderror
                                <textarea name="description" id="description" cols="30" rows="10" class="form-control"
                                          style="resize: none;" required>{{$data->description}}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="logo">Upload Thumbnail </label>
                                @error('logo')
                                <p class="invalid-feedback text-danger" role="alert"><strong>{{ $message }}</strong></p>
                                @enderror
                                <input type="file" id="logo" name="logo" class="dropify" data-default-file='{{asset("uploads/$data->logo")}}'/>
                            </div>

                            <div class="form-group">
                                <label for="description">Date <strong class="text-danger"> &#42; </strong></label>
                                @error('date')
                                <p class="invalid-feedback text-danger" role="alert"><strong>{{ $message }}</strong></p>
                                @enderror
                                <input type="text" name="date" required placeholder="yyyy-mm-dd" id="date"
                                       class="form-control" value="{{date('m/d/Y',strtotime($data->date))}}">
                            </div>
                            <div class="form-group">
                                <label for="title">Details Title <strong class="text-danger"> &#42; </strong> </label>
                                @error('details_title')
                                <p class="invalid-feedback text-danger" role="alert"><strong>{{ $message }}</strong></p>
                                @enderror
                                <input type="text" class="form-control" id="title"
                                       placeholder="Details Title" name="details_title" value="{{$data->details_title}}" required>
                            </div>
                            <div class="form-group">
                                <label for="description">Details Description <strong class="text-danger">
                                        &#42; </strong></label>
                                @error('details_description')
                                <p class="invalid-feedback text-danger" role="alert"><strong>{{ $message }}</strong></p>
                                @enderror
                                <textarea name="details_description" id="details_description" cols="30" rows="10" class="form-control"
                                          style="resize: none;" required>{{$data->details_description}}</textarea>
                            </div>




                            <div class="form-group">
                                <label for="logo">Upload Details Image</label>
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dynamic_field">
                                        <tr>
                                            <td>
                                                <div>
                                                     <label for="logo">Image</label>
                                                    <input type="file" name="images[]" class="form-control input-md input_open"/>
                                                </div>
                                            </td>


                                        </tr>
                                    </table>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-success waves-effect waves-light col-md-12">
                                Save {{$title}}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

{{--image part--}}
    {{--image part--}}
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-info">
                <div class="panel-heading">Edit {{$title}} Images</div>
                <div class="panel-wrapper collapse in" aria-expanded="true">
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table id="datatable" class="display table table-hover table-striped nowrap" cellspacing="0"
                                   width="100%">
                                <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Image</th>
                                    <th>Options</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($data->images as $key=>$val)
                                    <tr>
                                        <td>{{$key + 1}}</td>
                                        <td>
                                            @if($val->image != null)
                                                <img src="{{ asset("/uploads/".$val->image)}}" class="img-responsive" width="200">
                                            @endif
                                        </td>

                                        <td>

                                            <form style="display: inline-block" action="{{ $route."/".$data->id."/destroy-image/".$val->id }}"
                                                  method="post" id="work-for-form">
                                                @csrf
                                                @method("DELETE")
                                                <a href="javascript:void(0);" data-text="{{ $title }} Image" class="delForm" data-id="{{$val->id}}">
                                                    <button data-toggle="tooltip"
                                                            data-placement="top" title="Remove"
                                                            class="btn btn-danger btn-circle tooltip-danger"><i
                                                            class="fas fa-trash"></i></button>
                                                </a>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('header')
    <!-- Dropify plugins css -->
    <link rel="stylesheet" href="{{asset('assets/plugins/dropify/dist/css/dropify.min.css')}}">
    <!-- jQuery file upload -->
    <script src="{{asset('assets/plugins/dropify/dist/js/dropify.min.js')}}"></script>

    <link href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.5/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>

    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.5/jquery-ui.min.js" type="text/javascript"></script>
    <!--This is a datatable style -->
    <link href="{{asset('assets/plugins/datatables/media/css/dataTables.bootstrap.css')}}" rel="stylesheet"
          type="text/css"/>
@endpush

@push('footer')

    <script>
        $('.dropify').dropify();

        $('#datatable').DataTable();


        $('#date').datepicker({
            autoclose: true,
            todayHighlight: true,
            format: 'yyyy-mm-dd',
        });

        $(document).ready(function () {
            $('#ui-datepicker-div').css('display','none');
            var i = 1;
            $('#add').click(function () {
                i++;
                $('#dynamic_field').append(`<tr id="row${i}">
			    <td>
                    <div class="col-xs-6">
                        <input type="file" name="images[]" class="form-control input-md input_open"/>
                    </div>

                </td>
			    <td align="center"><button type="button" name="remove" id="${i}" class="btn btn-danger btn_remove"><i class="fas fa-minus"></i></button></td>
			</tr>`);
            });

            $(document).on('click', '.btn_remove', function () {
                var button_id = $(this).attr("id");
                $('#row' + button_id + '').remove();
            });
        });
    </script>
@endpush

