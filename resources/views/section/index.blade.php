@extends('layouts.master')
@include('partials.datatable-assets')
@section('template_title')
    {{ __('app.sections') }}
@endsection


@section('content')
    @if (session()->has('Add'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>{{ session()->get('Add') }}</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

    @if (session()->has('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>{{ session()->get('success') }}</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

@if (session()->has('delete'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>{{ session()->get('delete') }}</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

@if (session()->has('edit'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>{{ session()->get('edit') }}</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif
<div class="row">
    <div class="col-xl-12">
        <div class="card mg-b-20">
            <div class="card-header pb-0">
                <div class="d-flex justify-content-between">
                    {{-- @can('اضافة قسم') --}}
                        <a class="modal-effect btn btn-outline-primary btn-block" data-effect="effect-scale"
                            data-toggle="modal" href="#modaldemo8">{{ __('app.add_section') }}</a>
                    {{-- @endcan --}}
                </div>

            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example1" class="table key-buttons text-md-nowrap" data-page-length='50'
                        style="text-align: center">
                        <thead>
                            <tr>
                                <th class="border-bottom-0">#</th>
                                <th class="border-bottom-0">{{ __('app.name') }}</th>
                                <th class="border-bottom-0">{{ __('app.description') }}</th>
                                <th class="border-bottom-0">{{ __('app.created_by') }}</th>
                                <th class="border-bottom-0">{{ __('app.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 0; ?>
                            @foreach ($sections as $x)
                                <?php $i++; ?>
                                <tr>
                                    <td>{{ $i }}</td>
                                    <td>{{ $x->name }}</td>
                                    <td>{{ $x->description }}</td>
                                    <td>{{ $x->created_by }}</td>
                                    <td>
                                        {{-- @can('تعديل قسم') --}}
                                            <a class="modal-effect btn btn-sm btn-info" data-effect="effect-scale"
                                                data-id="{{ $x->id }}" data-name="{{ $x->name }}"
                                                data-description="{{ $x->description }}" data-toggle="modal"
                                                href="#exampleModal2" title="{{ __('app.edit') }}"><i class="las la-pen"></i></a>
                                        {{-- @endcan --}}

                                        {{-- @can('حذف قسم') --}}
                                            <a class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale"
                                                data-id="{{ $x->id }}" data-name="{{ $x->name }}"
                                                data-toggle="modal" href="#modaldemo9" title="{{ __('app.delete') }}"><i
                                                    class="las la-trash"></i></a>
                                        {{-- @endcan --}}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    <div class="modal" id="modaldemo8">
        <div class="modal-dialog" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">{{ __('app.add_section') }}</h6><button aria-label="Close" class="close" data-dismiss="modal"
                        type="button"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('sections.store') }}" method="post">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <label for="exampleInputEmail1">{{ __('app.name') }}</label>
                            <input type="text" class="form-control" id="name" name="name">
                        </div>

                        <div class="form-group">
                            <label for="exampleFormControlTextarea1">{{ __('app.description') }}</label>
                            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success">{{ __('app.submit') }}</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('app.close') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- End Basic modal -->


    </div>
    <!-- edit -->
    <div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ __('app.edit_section') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form action="" method="post" autocomplete="off">
                        {{ method_field('patch') }}
                        {{ csrf_field() }}
                        <div class="form-group">
                            <input type="hidden" name="id" id="id" value="">
                            <label for="name" class="col-form-label">{{ __('app.name') }}:</label>
                            <input class="form-control" name="name" id="name" type="text">
                        </div>
                        <div class="form-group">
                            <label for="description" class="col-form-label">{{ __('app.description') }}:</label>
                            <textarea class="form-control" id="description" name="description"></textarea>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">{{ __('app.submit') }}</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('app.close') }}</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <!-- delete -->
    <div class="modal" id="modaldemo9">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">{{ __('app.delete_section') }}</h6><button aria-label="Close" class="close" data-dismiss="modal"
                        type="button"><span aria-hidden="true">&times;</span></button>
                </div>
                <form action="" method="post">
                    {{ method_field('delete') }}
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <p>{{ __('app.confirm_delete') }}</p><br>
                        <input type="hidden" name="id" id="id" value="">
                        <input class="form-control" name="name" id="name" type="text" readonly>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('app.cancel') }}</button>
                        <button type="submit" class="btn btn-danger">{{ __('app.confirm') }}</button>
                    </div>
            </div>
            </form>
        </div>
    </div>




    <!-- row closed -->
</div>
<!-- Container closed -->
</div>
@endsection
@section('js')
    <script>
        $('#exampleModal2').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var name = button.data('name')
            var description = button.data('description')
            var modal = $(this)
            modal.find('form').attr('action', '/sections/' + id);
            modal.find('.modal-body #id').val(id);
            modal.find('.modal-body #name').val(name);
            modal.find('.modal-body #description').val(description);
        })
    </script>

    <script>
        $('#modaldemo9').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var name = button.data('name')
            var modal = $(this)
            modal.find('form').attr('action', '/sections/' + id);
            modal.find('.modal-body #id').val(id);
            modal.find('.modal-body #name').val(name);
        })
    </script>
@endsection














{{-- @section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                               {{ trans('app.sections') }}
                            </span>

                             <div class="float-right">
                                <a href="{{ route('sections.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
                                  {{ __('Create New') }}
                                </a>
                              </div>
                        </div>
                    </div>
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success m-4">
                            <p>{{ $message }}</p>
                        </div>
                    @endif

                    <div class="card-body bg-white">
                        <div class="table-responsive">
                           <table id="example" class="table key-buttons text-md-nowrap">
                                <thead class="thead">
                                    <tr>
                                        <th>No</th>

									<th >Name</th>

                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($sections as $section)
                                        <tr>
                                            <td>{{ ++$i }}</td>

										<td >{{ $section->name }}</td>

                                            <td>
                                                <form action="{{ route('sections.destroy', $section->id) }}" method="POST">
                                                    <a class="btn btn-sm btn-primary " href="{{ route('sections.show', $section->id) }}"><i class="fa fa-fw fa-eye"></i> {{ __('Show') }}</a>
                                                    <a class="btn btn-sm btn-success" href="{{ route('sections.edit', $section->id) }}"><i class="fa fa-fw fa-edit"></i> {{ __('Edit') }}</a>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="event.preventDefault(); confirm('Are you sure to delete?') ? this.closest('form').submit() : false;"><i class="fa fa-fw fa-trash"></i> {{ __('Delete') }}</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {!! $sections->withQueryString()->links() !!}
            </div>
        </div>
    </div>
@endsection --}}
