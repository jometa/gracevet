@extends('commons.base')

@section('current_page', 'Data Penanganan Khusus')

@section('content')
<!-- Info boxes -->
<div class="row" style="margin-bottom: 12px;">
  <div class="col-md-3">
    <a href="/pen-khusus/create" class="btn btn-block btn-primary">Tambah</a>
  </div>
</div>
<div class="row" id="app_vue">
  <!-- left column -->
  <div class="col-md-12">
      <div class="box">
          <div class="box-body">
            <table id="main-table" class="table table-bordered table-striped table-small">
              <thead>
                <tr>
                  <th>Id</th>
                  <th>Nama</th>
                  <th>Penggunaan</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach($items as $it)
                  <tr>
                    <td>{{ $it->id}}</td>
                    <td>{{ $it->nama}}</td>
                    <td>{{ $it->penggunaan}}</td>
                    <td>
                        <a href='/pen-khusus/{{$it->id}}/edit' class='btn btn-sm btn-info'>Edit</a>
                        <a href='/pen-khusus/{{$it->id}}/del' class='btn btn-sm btn-danger'>Delete</a>
                    </td>
                  </tr>
                @endforeach
              </tbody>
              <tfoot>
                <tr>
                  <th>Id</th>
                  <th>Nama</th>
                  <th>Penggunaan</th>
                  <th>Action</th>
                </tr>
              </tfoot>
            </table>
          </div><!-- /.box-body -->
        </div><!-- /.box -->

  </div><!--/.col (left) -->
</div><!-- /.row -->

@endsection

@section('modals-cont')
  @include('new-rek-med-modal')
@endsection

@section('bottom-script')
  @include('commons.bottom')
  <script src="/plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="/plugins/datatables/dataTables.bootstrap.min.js"></script>
  <script>
      $(function () {
        $('#main-table').DataTable();
      });
    </script>
@endsection