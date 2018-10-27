@extends('commons.base')

@section('current_page', 'Data Pemilik')

@section('content')
<div class="row" id="app_vue">
  <!-- left column -->
  <div class="col-md-12">
      <div class="box">
          <div class="box-body">
            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                  <select placeholder="Per Halaman" class="form-control" v-model="perPage">
                    <option>50</option>
                    <option>75</option>
                    <option>100</option>
                  </select>
                </div>
              </div>
              <div class="col-md-6">
                <div class="input-group">
                  <input class="form-control" type="text" v-model="keyword"/>
                  <span class="input-group-btn">
                    <button id="pemilik-search" class="btn btn-flat" v-on:click.stop.prevent="reload()">
                      <i class="fa fa-search"></i>
                    </button>
                  </span>
                </div>
              </div>
              <div class="col-md-3">
                  <a href="/pemilik/create" class="btn btn-block btn-primary">Tambah</a>
              </div>
            </div>
            <table id="main-table" class="table table-hover">
              <thead>
                <tr>
                  <th>Id</th>
                  <th style="min-width: 120px;">Nama</th>
                  <th>Alamat</th>
                  <th>No.Telp</th>
                  <th>Kunjungan Terakhir</th>
                  <th>Total Kunjungan</th>
                  <th class="fit">Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach($items as $it)
                  <tr>
                    <td>{{ $it->id }}</td>
                    <td>{{ $it->nama }}</td>
                    <td>{{ $it->alamat }}</td>
                    <td>{{ $it->no_telp }}</td>
                    <td>{{ $it->last_visit }}</td>
                    <td>{{ $it->total_visit }}</td>
                    <td class="fit">
                        {{-- <a href='/rekam-medik/pemilik/{{$it->id}}'>Rekam Medik</a> --}}
                        <a href='/pemilik/{{$it->id}}/edit' class='btn btn-sm btn-info'>Edit</a>
                        @if($it->total_visit == 0)
                          <button v-on:click='remove({{ $it->id }})' class='btn btn-sm btn-danger'>Delete</button>
                        @endif
                    </td>
                  </tr>
                @endforeach
              </tbody>
              <tfoot>
                <tr>
                    <th>Id</th>
                    <th>Nama</th>
                    <th>Alamat</th>
                    <th>No.Telp</th>
                    <th>Last Visit</th>
                    <th>Total Visit</th>
                    <th>Action</th>
                </tr>
              </tfoot>
            </table>
            {{ $items->links() }}
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
  <script src="/dist/js/vue.js"></script>
  <script src="/dist/js/axios.js"></script>
  <script>
    var app_vue  = new Vue({
      el: '#app_vue',
      data: {
        perPage: {{ $perPage }},
        keyword: "{{ $keyword }}"
      },
      methods: {
        remove (id) {
          axios.delete(`/pemilik/${id}`)
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
        },
        reload () {
          var pp = this.perPage;
          var k = this.keyword;
          window.location = `/pemilik?page=1&perPage=${pp}&keyword=${k}`;
        }
      },
      watch: {
        perPage() {
          this.reload();
        }
      }
    });
  </script>
@endsection