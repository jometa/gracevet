@extends('commons.base')

@section('content')
<!-- Info boxes -->
<div class="row" id="app_vue">
  <!-- left column -->

  <div class="col-md-6 col-md-offset-3">
      <!-- general form elements -->
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">Tambah Data Pasien</h3>
      </div><!-- /.box-header -->
      <!-- form start -->
      <form role="form" method="post" action="/pasien">
        <div class="box-body">
          <div class="form-group">
            <label>Nama</label>
            <input type="text" name="nama" class="form-control" placeholder="Masukan Nama">
          </div>

          <div class="form-group">
            <label>Jenis Hewan</label>
            <select v-model="jenis_hewan_id" class="form-control" name="jenis_hewan_id">
              @foreach ($jenis_hewan_list as $item)
                <option value="{{ $item->id }}">{{ $item->nama }}</option>
              @endforeach
            </select>
          </div>

          <div class="form-group">
            <label>Ras</label>
            <select class="form-control" name="jh_ras_id">
              <option v-for="(item, index) in filteredRaces"
                :key="index"
                :value="item.id">@{{ item.ras }}</option>
            </select>
          </div>

          <div class="form-group">
            <label>Jenis Kelamin</label>
            <select class="form-control" name="jk">
              <option value="0">Jantan</option>
              <option value="1">Betina</option>
            </select>
          </div>

          <div class="form-group" class="form-control">
              <label>Signalement</label>
              <input type="text" class="form-control" placeholder="Signalemen"
                name="signalemen">
          </div>

          <div class="form-group">
              <label>Lahir</label>
              <input type="date" class="form-control" placeholder="Tanggal Lahir"
                name="lahir">
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
  <script src="/dist/js/vue.js"></script>
  <script src="/dist/js/axios.js"></script>
  <script>
    var app_vue  = new Vue({
      el: '#app_vue',
      data: {
        jenis_hewan_id: null,
        races: [
          @foreach ($jhras_list as $item)
            {
              ras: "{{ $item['ras'] }}",
              id: {{ $item['id'] }},
              jenis_hewan: {{ $item['jenis_hewan'] }}
            }
            @if(!$loop->last)
              ,
            @endif
          @endforeach
        ]
      },
      computed: {
        filteredRaces () {
          return this.races.filter(it => {
            return it.jenis_hewan == this.jenis_hewan_id;
          });
        }
      },
      methods: {
        remove (id) {
          axios.delete(`/pasien/${id}`)
            .then(resp => resp.data)
            .then(() => {
              alert('Sukses');
            })
            .catch(err => {
              console.log(err);
              alert('Gagal');
            })
            .then(() => {
              location.reload();
            });
        }
      }
    });
  </script>
@endsection