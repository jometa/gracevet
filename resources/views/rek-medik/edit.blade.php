@extends('commons.base')

@section('current_page', 'Edit Data Rekam Medik')

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
      <button class="btn btn-block btn-outline-primary"
        v-on:click="submit">
        Submit
      </button>
    </div>
  </div>

  <div class="row">

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
        activeStageIndex: 0,
        pemilik: {{ $item->pemilik->id }},
        pasien: {{ $item->pasien->id }},
        rekam_medik: {
          id: {{ $item->id }},
          tanggal: "{{date('Y-m-d', strtotime($item->tanggal))}}",
          berat: {{ $item->berat }},
          tipe_norek: "{{$item->tipe_norek}}",
          norek: "{{ $item->norek }}",
          freq_n: {{$item->freq_n}},
          freq_p: {{$item->freq_p}},
          freq_t: {{$item->freq_t}},
          mth: "{{ $item->mth }}",
          mulut: "{{ $item->mulut }}",
          kul_rambut: "{{ $item->kul_rambut }}",
          kelenjar_limfe: "{{ $item->kelenjar_limfe }}",
          pernapasan: "{{ $item->pernapasan }}",
          peredaran_darah: "{{ $item->peredaran_darah }}",
          pencernaan: "{{ $item->pencernaan }}",
          kelamin_perkencingan: "{{ $item->kelamin_perkencingan }}",
          ang_gerak: "{{ $item->ang_gerak }}",
          diagnosa: "{{ $item->diagnosa }}",
          prognosis: "{{ $item->prognosis }}",
          terapi: "{{ $item->terapi }}"
        },
        tipe_norek_opts: ['GA', 'GB', 'GC', 'GD'],
        thasil_labs: [
            @foreach ($hasil_labs as $it)
              {
                nama: "{{ $it['nama'] }}",
                used: true,
                id: {{ $it['id'] }},
                struktur: [
                  @foreach ($it['struktur'] as $it2)
                    {
                      name: "{{$it2->name}}",
                      type: "{{$it2->type}}",
                      value:
                        @if($it2->type == 'string')
                          "{{ $it2->value}}"
                        @else
                          {{ $it2->value}}
                        @endif
                    }
                    @if(!$loop->last)
                      ,
                    @endif
                  @endforeach
                ]
              }
              @if(!$loop->last)
                ,
              @endif
            @endforeach
        ],
        pen_types: [
          @foreach ($pen_types as $it)
            {
              nama: "{{ $it->nama }}",
              id: {{ $it->id }},
              deskripsi: "{{ $it->pivot->deskripsi }}",
              used: true
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
        rekMedikValid () {
          return this.rekam_medik.tanggal != '' &&
            this.rekam_medik.tanggal != null &&
            this.rekam_medik.norek != '';
        },
        validation () {
          return [
            this.rekMedikValid,
            true,
            true
          ]
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
        submit () {
          
          var payload = {
            pemilik: this.pemilik,
            pasien: this.pasien,
            rekam_medik: this.rekam_medik,
            hasil_labs: this.thasil_labs.filter(t => t.used),
            pen_khusus: this.pen_types.filter(t => t.used)
          };

          axios.post("/api/rek-medik/update", payload)
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
      }
    })
  </script>
@endsection