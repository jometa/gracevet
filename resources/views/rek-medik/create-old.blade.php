@extends('commons.base')

@section('current_page', 'Kunjungan Member')

@section('content')
<div id="app_vue">
  <div class="row">
    <div class="col-md-9">
      <div class="btn-group" 
        style="margin-bottom: 12px; display: flex; justify-content: space-between;"
        >
          <button v-for="(st, index) in stages" :key="st.name" 
            class="btn"
            v-bind:class="{ 
              active: activeStage.name == st.name,
              'btn-primary': validation[index]
            }"
            style="flex-grow: 1;"
            v-on:click="changeStage(index)"
            {{-- v-bind:style="validationStyles[index]" --}}
            >
            <i v-bind:class="'fa ' + st.icon"></i>
            @{{ st.name }}
          </button>

      </div>
    </div>
    <div class="col-md-3">
      <button class="btn btn-block btn-outline-primary"
        v-on:click="submit"
        v-bind:disabled="submitInvalid">
        Submit
      </button>
    </div>
  </div>

  <div class="row">
    <!-- left column -->
    <div v-if="activeStage.name == 'pemilik'" class="col-md-12">
      <div class="row">
        <div class="col-md-6">
          <div class="box box-primary">
            <div class="box-header with-border">
              <form>
                <div class="form-group">
                  <input type="text" class="form-control" placeholder="Keyword"
                    v-model="pemilik_keyword"/>
                </div>
              </form>
            </div><!-- /.box-header -->
            <div class="box-body">
              <table id="main-table" class="table table-hover">
                <thead>
                  <tr>
                    <th>Id</th>
                    <th>Nama</th>
                    <th>Alamat</th>
                    <th>No.Telp</th>
                    <th>Last Visit</th>
                    <th>Total Visit</th>
                  </tr>
                </thead>
                <tbody v-for="(item, index) in pemilik_list" :key="index">
                  <tr v-on:click="set_active_pemilik(item)">
                    <td>@{{ item.id }}</td>
                    <td>@{{ item.nama }}</td>
                    <td>@{{ item.alamat }}</td>
                    <td>@{{ item.no_telp }}</td>
                    <td>@{{ item.last_visit }}</td>
                    <td>@{{ item.total_visit }}</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="col-md-6">
            <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Data Pemilik</h3>
            </div><!-- /.box-header -->
            <!-- form start -->
            <form role="form" method="post" action="/ras">
              <div class="box-body">
                <div class="form-group">
                  <label>Nama</label>
                  <input type="text" name="nama" class="form-control" placeholder="Masukan Nama"
                    v-model="pemilik.nama" readonly>
                </div>
                <div class="form-group">
                  <label>No. Telp / WA</label>
                  <input type="text" name="no_telp" class="form-control" placeholder="Masukan nomor telp."
                  v-model="pemilik.no_telp" readonly>
                </div>
                <div class="form-group">
                  <label>Alamat</label>
                  <input type="text" class="form-control" placeholder="Masukan Alamat"
                  v-model="pemilik.alamat" readonly>
                </div>
              </div>
      
              <div class="box-footer">
                <button v-bind:disabled="invalidNext" 
                  v-on:click.prevent="nextStage"
                  type="button" 
                  class="btn btn-primary">Next</button>
              </div>
            </form>
          </div><!-- /.box -->
        
        </div><!--/.col (left) -->
      </div>
    </div>

    <div v-if="activeStage.name == 'pasien'" class="col-md-12">
      <div class="row">
        <div class="col-md-6">
          <div class="box box-primary">
            <div class="box-header with-border">
              <form>
                <div class="form-group">
                  <input type="text" class="form-control" placeholder="Keyword"
                    v-model="pasien_keyword"/>
                </div>
              </form>
            </div><!-- /.box-header -->
            <div class="box-body">
              <table id="main-table" class="table table-hover">
                <thead>
                  <tr>
                    <th>Id</th>
                    <th>Nama</th>
                    <th>JK</th>
                    <th>Signalemen</th>
                    <th>Umur</th>
                    <th>Jenis Hewan</th>
                    <th>Ras</th>
                  </tr>
                </thead>
                <tbody v-for="(item, index) in pasien_list" :key="index">
                  <tr v-on:click="set_active_pasien(item)">
                    <td>@{{ item.id }}</td>
                    <td>@{{ item.nama }}</td>
                    <td>@{{ item.jk }}</td>
                    <td>@{{ item.signalemen }}</td>
                    <td>@{{ item.umur }}</td>
                    <td>@{{ item.jh_ras.jenis_hewan.nama }}</td>
                    <td>@{{ item.jh_ras.ras.nama }}</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="col-md-6">
            <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Data Pasien</h3>
            </div><!-- /.box-header -->
            <!-- form start -->
            <form role="form" method="post" action="/ras">
              <div class="box-body">
                <div class="form-group">
                  <label>Nama</label>
                  <input type="text" name="nama" class="form-control" placeholder="Masukan Nama"
                    v-bind:value="pasien.nama" readonly>
                </div>
  
                <div class="form-group">
                  <label>Jenis Hewan</label>
                  <input type="text" name="nama" class="form-control" placeholder="Masukan Nama"
                    v-bind:value="pasien.jenis_hewan" readonly>
                </div>
  
                <div class="form-group">
                  <label>Ras</label>
                  <input type="text" name="nama" class="form-control" placeholder="Masukan Nama"
                    v-bind:value="pasien.ras" readonly>
                </div>
  
                <div class="form-group">
                  <label>Jenis Kelamin</label>
                  <select v-model="pasien.jk" class="form-control" readonly>
                    <option value="0">Jantan</option>
                    <option value="1">Betina</option>
                  </select>
                </div>
                <div class="form-group" class="form-control">
                    <label>Signalement</label>
                    <input type="text" class="form-control" placeholder="Signalemen"
                      v-bind:value="pasien.signalemen" readonly>
                </div>
                <div class="form-group">
                    <label>Lahir</label>
                    <input type="date" class="form-control" placeholder="Tanggal Lahir"
                      v-bind:value="pasien.lahir" readonly>
                </div>
              </div>
      
              <div class="box-footer">
                <button type="button" v-on:click.prevent="nextStage()" class="btn btn-primary">Next</button>
              </div>
            </form>
          </div><!-- /.box -->
        
        </div><!--/.col (left) -->
      </div>
    </div>

    <div v-if="activeStage.name == 'lab'">
      <div class="col-md-12">
          <!-- general form elements -->
        <div class="row">
          <div class="col-md-4" v-for="(thl, index) in thasil_labs" :key="index">
            <div class="box box-primary">
              <div class="box-header with-border">
                <div class="checkbox">
                  <input type="checkbox" v-model="thl.used" />
                </div>
                <h3 class="box-title">@{{ thl.nama }}</h3>
              </div><!-- /.box-header -->
              <!-- form start -->
              <form role="form" method="post" action="/ras">
                <div class="box-body">
                  <div class="form-group" v-for="(str, j) in thl.struktur" :index="j">
                    <label>@{{ str.name }}</label>
                    <input 
                      v-bind:type="str.type == 'string' ? 'text' : str.type" name="nama" class="form-control"
                      v-model="str.value"
                      v-bind:disabled="!thl.used">
                  </div>
                </div>
        
                <div class="box-footer">
                  <button type="button" v-on:click.prevent="nextStage()" class="btn btn-primary">Next</button>
                </div>
              </form>
            </div><!-- /.box -->
          </div>
        </div>
      
      </div><!--/.col (left) -->
    </div>

    <div v-if="activeStage.name == 'rekam-medik'">
      <div class="col-md-6 col-md-offset-3">
          <!-- general form elements -->
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Data Rekam Medik</h3>
          </div><!-- /.box-header -->
          <!-- form start -->
          <form role="form" method="post" action="/ras">
            <div class="box-body">

              <div class="form-group">
                <label>Tanggal</label>
                <input type="date" class="form-control" placeholder="Masukan Tanggal"
                  v-model="rekam_medik.tanggal">
              </div>

              <div class="form-group">
                <label>No Rekam Medik</label>
                <div class="row">
                  <div class="col-md-4">
                    <select class="form-control"
                      v-model="rekam_medik.tipe_norek">
                      <option v-for="(item, index) in tipe_norek_opts" :key="item">@{{ item }}</option>
                    </select>
                  </div>
                  <div class="col-md-8">
                    <input type="text" class="form-control"
                      v-model="rekam_medik.norek">
                  </div>
                </div>
              </div>

              <div class="form-group">
                <label>Berat</label>
                <input type="number" min=0 max=1000 step="0.25" class="form-control"
                  v-model="rekam_medik.berat">
              </div>

              <div class="form-group">
                <label>Freq. N</label>
                <input type="number" min=0 max=1000 class="form-control"
                  v-model="rekam_medik.freq_n">
              </div>

              <div class="form-group">
                <label>Freq. P</label>
                <input type="number" min=0 max=1000 class="form-control"
                  v-model="rekam_medik.freq_p">
              </div>

              <div class="form-group">
                <label>Freq. T</label>
                <input type="number" min=0 max=1000 class="form-control"
                  v-model="rekam_medik.freq_t">
              </div>

              <div class="form-group">
                <label>Mulut, Telinga, dan Hidung</label>
                <input type="text" class="form-control"
                  v-model="rekam_medik.mth">
              </div>

              <div class="form-group">
                <label>Mulut</label>
                <input type="text" class="form-control"
                  v-model="rekam_medik.mulut">
              </div>

              <div class="form-group">
                <label>Kulit Rambut</label>
                <input type="text" class="form-control"
                  v-model="rekam_medik.kul_rambut">
              </div>

              <div class="form-group">
                <label>Kelenjar Limfe</label>
                <input type="text" class="form-control"
                  v-model="rekam_medik.kelenjar_limfe">
              </div>

              <div class="form-group">
                <label>Kelenjar Limfe</label>
                <input type="text" class="form-control"
                  v-model="rekam_medik.pernapasan">
              </div>

              <div class="form-group">
                <label>Peredaran Darah</label>
                <input type="text" class="form-control"
                  v-model="rekam_medik.peredaran_darah">
              </div>

              <div class="form-group">
                <label>Pencernaan</label>
                <input type="text" class="form-control"
                  v-model="rekam_medik.pencernaan">
              </div>

              <div class="form-group">
                <label>Kelamin / Perkencingang</label>
                <input type="text" class="form-control"
                  v-model="rekam_medik.kelamin_perkencingan">
              </div>

              <div class="form-group">
                <label>Anggota Gerak</label>
                <input type="text" class="form-control"
                  v-model="rekam_medik.ang_gerak">
              </div>

              <div class="form-group">
                <label>Diagnosa</label>
                <textarea class="form-control"
                  v-model="rekam_medik.diagnosa">
                </textarea>
              </div>

              <div class="form-group">
                <label>Prognosis</label>
                <textarea class="form-control"
                  v-model="rekam_medik.prognosis">
                </textarea>
              </div>

              <div class="form-group">
                <label>Terapi</label>
                <textarea class="form-control"
                  v-model="rekam_medik.terapi">
                </textarea>
              </div>

            </div>
    
            <div class="box-footer">
              <button type="button" v-on:click.prevent="nextStage()" class="btn btn-primary">Next</button>
            </div>
          </form>
        </div><!-- /.box -->
      
      </div><!--/.col (left) -->
    </div>

    <div v-if="activeStage.name == 'penanganan-khusus'">
      <div class="col-md-12">
          <!-- general form elements -->
        <div class="row">
          <div class="col-md-6" v-for="(pen, index) in pen_types" :key="index" style="margin-bottom: 12px;">
            <div class="box box-primary">
              <div class="box-header with-border">
                <div class="checkbox">
                  <input type="checkbox" v-model="pen.used" />
                </div>
                <h3 class="box-title">@{{ pen.nama }}</h3>
              </div><!-- /.box-header -->
              <!-- form start -->
              <form role="form" method="post" action="/ras">
                <div class="box-body">
                  <div class="form-group">
                    <label>Deskripsi</label>
                    <textarea
                      rows="10"
                      class="form-control"
                      v-model="pen.deskripsi"
                      v-bind:disabled="!pen.used">
                    </textarea>
                  </div>
                </div>
              </form>
            </div><!-- /.box -->
          </div>
        </div>
      
      </div><!--/.col (left) -->
    </div>
    
  </div><!-- /.row -->
</div>

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
        stages: [ 
          {
            name: 'pemilik',
            icon: 'fa-user'
          }, {
            name: 'pasien', 
            icon: 'fa-medkit'
          },{
            name: 'rekam-medik',
            icon: 'fa-hospital-o'
          }, {
            name: 'lab',
            icon: 'fa-stethoscope'
          }, {
            name: 'penanganan-khusus',
            icon: 'fa-stethoscope'
          }
        ],
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
        ],
        activeStageIndex: 0,
        pemilik: {
          id: null,
          nama: '',
          no_telp: '',
          alamat: ''
        },
        pasien: {
          id: null,
          nama: '',
          jenis_hewan: null,
          ras: null,
          signalemen: '',
          jk: '',
          lahir: null
        },
        rekam_medik: {
          tanggal: new Date(),
          berat: 0.5,
          tipe_norek: 'GA',
          norek:'',
          freq_n: 0,
          freq_p: 0,
          freq_t: 0,
          mth: "",
          mulut: "",
          kul_rambut: "",
          kelenjar_limfe: "",
          pernapasan: "",
          peredaran_darah: "",
          pencernaan: "",
          kelamin_perkencingan: "",
          ang_gerak: "",
          diagnosa: "",
          prognosis: "",
          terapi: ""
        },
        tipe_norek_opts: ['GA', 'GB', 'GC', 'GD'],
        thasil_labs: [
          {
            id: 0,
            nama: 'A',
            used: false,
            struktur: [
              {
                name: 'AAA1',
                type: 'string',
                value: '--'
              },
              {
                name: 'AAA2',
                type: 'number',
                value: 0
              }
            ]
          }
        ],
        pen_types: [
          @foreach ($pen_types as $it)
            {
              nama: "{{ $it->nama }}",
              id: {{ $it->id }},
              deskripsi: "",
              used: false
            }
            @if(!$loop->last)
              ,
            @endif
          @endforeach
        ],
        pemilik_list: [],
        pemilik_keyword: '',

        pasien_list: [],
        pasien_keyword: ''
      },
      computed: {
        activeStage () {
          return this.stages[this.activeStageIndex];
        },
        invalidNext () {
          return this.activeStage >= this.stages.length;
        },
        filteredRaces () {
          return this.races.filter(it => {
            return it.jenis_hewan == this.pasien.jenis_hewan_id;
          });
        },
        pemilikValid () {
          return this.pemilik.nama != '' && this.pemilik.no_telp != '' &&this.pemilik.alamat != '';
        },
        pasienValid () {
          return this.pasien.id != '' && 
            this.pasien.id != null;
        },
        rekMedikValid () {
          return this.rekam_medik.tanggal != '' &&
            this.rekam_medik.tanggal != null &&
            this.rekam_medik.norek != '';
        },
        validation () {
          return [
            this.pemilikValid,
            this.pasienValid,
            this.rekMedikValid,
            true,
            true,
            true
          ]
        },
        submitInvalid () {
          // DANGER HERE... there is posibility that validation updated in the middle of loop
          for (var i = 0; i < this.validation.length; i++) {
            if (!this.validation[i]) {
              return true;
            }
          }
          return false;
        }
      },
      methods: {
        nextStage () {
          if (this.activeStage == this.stages.length) {
            return;
          } else {
            this.activeStageIndex += 1;
          }
        },
        changeStage (index) {
          this.activeStageIndex = index;
        },
        loadTHasilLabs () {
          axios('/api/hasil-lab').then(resp => resp.data)
            .then(items => {
              this.thasil_labs = items.map(it => {
                it.used = false;
                return it;
              });
            })
            .catch(err => {
              console.log(err);
            });
        },
        submit () {
          
          var payload = {
            pemilik: this.pemilik.id,
            pasien: this.pasien.id,
            rekam_medik: this.rekam_medik,
            hasil_labs: this.thasil_labs.filter(t => t.used),
            pen_khusus: this.pen_types.filter(t => t.used)
          };

          payload.pasien.jh_ras_id = payload.pasien.ras;

          axios.post('/api/old-member-rek-medik', payload)
            .then(resp => resp.data)
            .then(() => {
              alert('Sukses');
              window.location = "/";
            })
            .catch(err => {
              console.log(err);
              alert('Gagal');
            });
        },

        searchPemilik () {
          var keyword = this.pemilik_keyword;
          axios.get(`/api/pemilik?keyword=${keyword}`)
            .then(resp => resp.data)
            .then(items => {
              this.pemilik_list = items;
            })
            .catch(err => {
              console.log(err);
            });
        },
        set_active_pemilik (item) {
          this.pemilik = Object.assign({}, item);
        },

        searchPasien () {
          var keyword = this.pasien_keyword;
          axios.get(`/api/pasien?keyword=${keyword}`)
            .then(resp => resp.data)
            .then(items => {
              this.pasien_list = items;
            })
            .catch(err => {
              console.log(err);
            });
        },
        set_active_pasien (item) {
          this.pasien.id = item.id;
          this.pasien.nama = item.nama;
          this.pasien.signalemen = item.signalemen;
          this.pasien.jk = item.jk;
          this.pasien.jenis_hewan = item.jh_ras.jenis_hewan.nama;
          this.pasien.ras = item.jh_ras.ras.nama;
          this.pasien.lahir = item.lahir;
        }
      },
      mounted () {
        this.loadTHasilLabs();
      },
      watch: {
        pemilik_keyword: function (val) {
          this.searchPemilik()
        },
        pasien_keyword: function (val) {
          this.searchPasien()
        }
      }
    })
  </script>
@endsection