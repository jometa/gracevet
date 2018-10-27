@extends('commons.base')

@section('content')
<!-- Info boxes -->
<div class="row">
  <!-- left column -->
  <div class="col-md-6 col-md-offset-3">
      <!-- general form elements -->
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">Edit Data Ras</h3>
      </div><!-- /.box-header -->
      <!-- form start -->
      <form role="form" method="post" action="/ras/${{ $item['id'] }}">
        @method('PUT')
        @csrf
        <div class="box-body">
          <div class="form-group">
            <label>Jenis Hewan</label>
            <select class="form-control" name="jenis_hewan" placeholder="Pilih Jenis Hewan"
              readonly>
              @foreach ($jenis_hewan_list as $it)
                <option 
                  value="{{ $it->id }}"
                  @if($it->id == $item['jenis_hewan_id'])
                    selected
                  @endif>
                  {{ $it->nama }}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <label>Nama</label>
            <input type="text" name="nama" class="form-control" placeholder="Masukan Nama"
              value="{{ $item['ras'] }}">
          </div>
        </div>

        <input type="number" hidden name="ras_id" value="{{ $item['ras_id'] }}"/>

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