@extends('commons.base')

@section('content')
<!-- Info boxes -->
<div class="row" style="margin-bottom: 12px;">
  <div class="col-md-3">
    <a href="/ras/create" class="btn btn-block btn-primary">Tambah</a>
  </div>
</div>
<div class="row">
  <!-- left column -->
  <div class="col-md-12">
      <div class="box">
          <div class="box-header">
            <h3 class="box-title">Data Ras</h3>
          </div><!-- /.box-header -->
          <div class="box-body">
            <table id="main-table" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>Id</th>
                  <th>Jenis Hewan</th>
                  <th>Ras</th>
                  <th>Total Kunjungan</th>
                  <th>Kunjungan Terakhir</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach($items as $it)
                  <tr>
                    <td>{{ $it->id }}</td>
                    <td>{{ $it->jenis_hewan->nama }}</td>
                    <td>{{ $it->ras->nama }}</td>
                    <td>{{ $it->total_visit }}</td>
                    <td>{{ $it->last_visit }}</td>
                    <td>
                      <a href="/jenis-hewan/{{ $it->id }}/edit" class="btn btn-sm btn-info">Edit</a>
                      @if($it->total_visit == 0)
                        <a href="/jenis-hewan/{{ $it->id }}/del" class="btn btn-sm btn-danger">Del</a>
                      @endif
                    </td>
                  </tr>
                @endforeach
              </tbody>
              <tfoot>
                <tr>
                  <th>Id</th>
                  <th>Jenis Hewan</th>
                  <th>Ras</th>
                  <th>Total Kunjungan</th>
                  <th>Kunjngan Terakhir</th>
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