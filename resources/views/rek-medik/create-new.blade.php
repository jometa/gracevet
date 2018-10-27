@extends('commons.base')

@section('current_page', 'Input Data Kunjungan')

@section('content')
<!-- Info boxes -->

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
      <button 
        v-bind:disabled="submitInvalid"
        class="btn btn-block btn-outline-primary"
        v-on:click="submit">
        Submit
      </button>
    </div>
  </div>

  <div class="row">
    <!-- left column -->
    <div v-if="activeStage.name == 'pemilik'">
      <div class="col-md-6 col-md-offset-3">
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
                  v-model="pemilik.nama">
              </div>
              <div class="form-group">
                <label>No. Telp / WA</label>
                <input type="text" name="no_telp" class="form-control" placeholder="Masukan nomor telp."
                v-model="pemilik.no_telp">
              </div>
              <div class="form-group">
                <label>Alamat</label>
                <input type="text" class="form-control" placeholder="Masukan Alamat"
                v-model="pemilik.alamat">
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

    <div v-if="activeStage.name == 'pasien'">
      <div class="col-md-6 col-md-offset-3">
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
                  v-model="pasien.nama">
              </div>

              <div class="form-group">
                <label>Jenis Hewan</label>
                <select v-model="pasien.jenis_hewan_id" class="form-control">
                  @foreach ($jenis_hewan_list as $item)
                    <option value="{{ $item->id }}">{{ $item->nama }}</option>
                  @endforeach
                </select>
              </div>

              <div class="form-group">
                <label>Ras</label>
                <select v-model="pasien.ras" class="form-control">
                  <option v-for="(item, index) in filteredRaces"
                    :key="index"
                    :value="item.id">@{{ item.ras }}</option>
                </select>
              </div>

              <div class="form-group">
                <label>Jenis Kelamin</label>
                <select v-model="pasien.jk" class="form-control">
                  <option value="0">Jantan</option>
                  <option value="1">Betina</option>
                </select>
              </div>
              <div class="form-group" class="form-control">
                  <label>Signalement</label>
                  <input type="text" class="form-control" placeholder="Signalemen"
                    v-model="pasien.signalemen">
              </div>
              <div class="form-group">
                  <label>Lahir</label>
                  <input type="date" class="form-control" placeholder="Tanggal Lahir"
                    v-model="pasien.lahir">
              </div>
            </div>
    
            <div class="box-footer">
              <button type="button" v-on:click.prevent="nextStage()" class="btn btn-primary">Next</button>
            </div>
          </form>
        </div><!-- /.box -->
      
      </div><!--/.col (left) -->
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
          nama: '',
          no_telp: '',
          alamat: ''
        },
        pasien: {
          nama: '',
          jenis_hewan_id: null,
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
        ]
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
          return this.pasien.nama != '' && 
            this.pasien.jenis_hewan_id != null && 
            this.pasien.ras != null && 
            this.pasien.jk != '' && 
            this.pasien.lahir != null && 
            this.pasien.lahir != '';
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
            pemilik: this.pemilik,
            pasien: this.pasien,
            rekam_medik: this.rekam_medik,
            hasil_labs: this.thasil_labs.filter(t => t.used),
            pen_khusus: this.pen_types.filter(t => t.used)
          };

          payload.pasien.jh_ras_id = payload.pasien.ras;

          axios.post('/api/new-member-rek-medik', payload)
            .then(resp => resp.data)
            .then(() => {
              alert('Sukses');
              window.location = "/";
            })
            .catch(err => {
              console.log(err);
              alert('Gagal');
            });
        }
      },
      mounted () {
        this.loadTHasilLabs();
      }
    })
  </script>
@endsection