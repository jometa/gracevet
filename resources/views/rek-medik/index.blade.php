@extends('commons.base')

@section('current_page', 'Rekam Medik')

@section('content')
<div class="row" id="app_vue">
  <!-- left column -->
  <div class="col-md-12">
      <div class="box">
          <div class="box-body">
            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                  <label>Per Halaman</label>
                  <select placeholder="Per Halaman" class="form-control" v-model="perPage">
                    <option>50</option>
                    <option>75</option>
                    <option>100</option>
                  </select>
                </div>
              </div>
              <div class="col-md-3">
                <label>Tanggal Awal</label>
                <div class="input-group">
                  <input class="form-control" type="date" v-model="startDate"/>
                  <span class="input-group-btn">
                    <button class="btn btn-flat" v-on:click.stop.prevent="reload()">
                      <i class="fa fa-calendar"></i>
                    </button>
                  </span>
                </div>
              </div>
              <div class="col-md-3">
                <label>Tanggal Akhir</label>
                <div class="input-group">
                  <input class="form-control" type="date" v-model="endDate"/>
                  <span class="input-group-btn">
                    <button class="btn btn-flat" v-on:click.stop.prevent="reload()">
                      <i class="fa fa-calendar"></i>
                    </button>
                  </span>
                </div>
              </div>
            </div>
            <table id="main-table" class="table table-hover">
              <thead>
                <tr>
                  <th>Id</th>
                  <th>Tanggal</th>
                  <th>No.Rek</th>
                  <th>Pemilik</th>
                  <th>Pasien</th>
                  <th>Jenis/Ras</th>
                  <th class="fit">Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach($items as $it)
                  <tr>
                    <td>{{ $it->id }}</td>
                    <td>
                      {{ $it->tanggal }}
                    </td>
                    <td>{{ $it->norek }}</td>
                    <td>
                      <a href="/pemilik/{{ $it->pemilik->id}}/edit">{{ $it->pemilik->nama }}</a>
                    </td>
                    <td>
                        <a href="/pasien/{{ $it->pasien->id}}/edit">{{ $it->pasien->nama }}</a>
                    </td>
                    <td>
                      {{ $it->pasien->jhRas->jenis_hewan->nama }}
                      / {{ $it->pasien->jhRas->ras->nama }}
                    </td>
                    <td class="fit">
                        <a href='/rekam-medik/{{$it->id}}/edit' class='btn btn-sm btn-info'>Edit</a>
                        <button v-on:click='remove({{ $it->id }})' class='btn btn-sm btn-danger'>Delete</button>
                    </td>
                  </tr>
                @endforeach
              </tbody>
              <tfoot>
                <tr>
                    <th>Id</th>
                    <th>Tanggal</th>
                    <th>No.Rek</th>
                    <th>Pemilik</th>
                    <th>Pasien</th>
                    <th>Jenis/Ras</th>
                    <th class="fit">Action</th>
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
        startDate: "{{ $startDate }}",
        endDate: "{{ $endDate }}"
      },
      methods: {
        remove (id) {
          axios.get(`/rekam-medik/${id}/delete`)
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
          var s = this.startDate;
          var e = this.endDate;
          window.location = `/rekam-medik?page=1&perPage=${pp}&startDate=${s}&endDate=${e}`;
        }
      },
      watch: {
        startDate() {
          this.reload();
        },
        endDate() {
          this.reload();
        }
      }
    });
  </script>
@endsection