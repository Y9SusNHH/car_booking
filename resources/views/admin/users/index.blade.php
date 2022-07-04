@extends('layout_backend.master')
@section('content')
    <div class="row">
        <div class="col-12">

            <div class="card">
                <div class="card-header">
                    <form class="form-horizontal" id="form-filter">
                        <div class="form-group col-md-4">
                            <label for="inputState" class="col-form-label" for="role">Role</label>
                            <select id="inputState" class="form-control select-filter" name="role" id="role">
                                <option selected>Tất cả</option>
                                @foreach($roles as $role => $value)
                                    <option value="{{ $value }}"
                                            @if((string)$value === $selectedRole) selected @endif
                                    >
                                        {{ $role }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </form>
                </div>
                <div class="card-body">
                    <table class="table table-striped table-centered mb-0">
                        <thead>
                        <tr>
                            <th>Thông tin</th>
                            <th>CMND</th>
                            <th>GPLX</th>
                            <th>Địa chỉ</th>
                            <th>Role</th>
                            <th>Xử lý</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($data as $each)
                            <tr>
                                <td>{{$each->name}} - {{$each->GenderName}}
                                    <br>
                                    <a href="tel:{{$each->phone}}">
                                        {{$each->phone}}
                                    </a>
                                    <br>
                                    <a href="mailto:{{$each->email}}">
                                        {{$each->email}}
                                    </a>
                                </td>
                                <td>
                                    @foreach($each->files as $file)
                                        @if($file->type === 0)
                                            <img src="{{$file->link}}" class="img-fluid img-thumbnail p-2"
                                                 style="max-width: 80px;" alt="CMND">
                                        @endif
                                    @endforeach
                                </td>
                                <td>
                                    @foreach($each->files as $file)
                                        @if($file->type === 1)
                                            <img src="{{$file->link}}" class="img-fluid img-thumbnail p-2"
                                                 style="max-width: 80px;" alt="GPLX">
                                        @endif
                                    @endforeach
                                </td>
                                <td>{{$each->address}}</td>
                                <td>{{$each->RoleName}}</td>
                                <td class="table-action">
                                    <a href="javascript:void(0);" class="action-icon"> <i class="mdi mdi-eye"></i></a>
                                    <form action="{{ route("admin.$table.destroy", $each)}}" method="post"
                                          class="action-icon">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-link action-icon"><i class="mdi mdi-delete"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <nav>
                        <ul class="pagination pagination-rounded mb-0">
                            {{$data->links()}}
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script type="text/javascript">
        $(document).ready(function () {
            $(".select-filter").change(function () {
                $("#form-filter").submit();
            });
        });

    </script>
@endpush