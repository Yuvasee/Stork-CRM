@extends('adminlte::layouts.app')

@section('htmlheader_title')
    Постоянные клиенты
@endsection

@section('contentheader_title')
    Постоянные клиенты
@endsection

@section('main-content')
    <div class="row">
        <div class="col-lg-6">
            <div class="box">
                <div class="box-body">
                    <table id="data-tbl" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Менеджер</th>
                                <th><i class="fa fa-heart"></i> Постоянных клиентов</th>
                                <th>Всего клиентов</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($managersActive as $item)
                            <tr>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->clients()->status1()->count() }}</td>
                                <td>{{ $item->clients()->count() }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    <br>
                    <a href="#" style="border-bottom: dashed 1px;" onclick="$('#data-tbl2').toggle()">Уволенные</a>
                    <table id="data-tbl2" class="table table-bordered table-hover" style="display: none">
                        <thead>
                            <tr>
                                <th>Менеджер</th>
                                <th><i class="fa fa-heart"></i> Постоянных клиентов</th>
                                <th>Всего клиентов</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($managersFired as $item)
                            <tr>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->clients()->status1()->count() }}</td>
                                <td>{{ $item->clients()->count() }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @parent
    <script>
      $(function () {
        var tbl = $('#data-tbl').DataTable({
          "paging": false,
          "lengthChange": false,
          "searching": false,
          "info": false,
          "rowReorder": false,
        });
        tbl.order([1, 'desc']).draw();

        var tbl2 = $('#data-tbl2').DataTable({
          "paging": false,
          "lengthChange": false,
          "searching": false,
          "info": false,
          "rowReorder": false,
        });
        tbl2.order([1, 'desc']).draw();
      });
    </script>
@endsection