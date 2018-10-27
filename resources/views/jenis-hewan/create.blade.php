@extends('commons.base')

@section('content')
<!-- Info boxes -->
<div class="row">
  <!-- left column -->
  <div class="col-md-6 col-md-offset-3">
      <!-- general form elements -->
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">Jenis Hewan Baru</h3>
      </div><!-- /.box-header -->
      <!-- form start -->
      <form role="form" method="post" action="/jenis-hewan">
        <div class="box-body">
          <div class="form-group">
            <label for="exampleInputEmail1">Nama</label>
            <input type="text" name="nama" class="form-control" id="jhNama" placeholder="Masukan Nama">
          </div>
        </div>

        <div class="box-footer">
          <button type="submit" class="btn btn-primary">Submit</button>
        </div>
      </form>
    </div><!-- /.box -->

  </div><!--/.col (left) -->
</div><!-- /.row -->

@endsection

@section('modals-cont')
  @include('new-rek-med-modal')
@endsection

@section('bottom-script')
  @include('commons.bottom')
@endsection