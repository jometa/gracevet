@extends('commons.base')

@section('current_page', 'Edit tipe hasil lab');

@section('content')
<!-- Info boxes -->
<div class="row">
  <!-- left column -->
  <div class="col-md-8 col-md-offset-2">
      <!-- general form elements -->
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">Edit Tipe Hasil Lab</h3>
      </div><!-- /.box-header -->
      <!-- form start -->
      <div id="app_vue">
        <form role="form" @submit.prevent="update">
          <div class="box-body">
            <div class="form-group">
              <label for="exampleInputEmail1">Nama</label>
              <input type="text" class="form-control" id="thlName" placeholder="Masukan Nama"
                v-model="name">
            </div>
  
            <div class="form-group">
              <button
                type="button"
                v-on:click.prevent="addItem()"
                class="btn btn-info">Tambah atribut</button>
            </div>

            <div class="row" v-for="(item, index) in items" :key="index">
              <div class="col-md-5">
                  <div class="form-group">
                      <label>@{{ item.name }}</label>
                      <input type="text" class="form-control" v-model="item.name">
                  </div>
              </div>
              <div class="col-md-5">
                  <div class="form-group">
                      <label>Tipe</label>
                      <select class="form-control" v-model="item.tipe">
                        <option value="number">Number</option>
                        <option value="string">String</option>
                      </select>
                  </div>
              </div>
              <div class="col-md-2">
                <div class="form-group" style="margin-top: 26px;">
                  <button class="btn btn-danger btn-sm"
                    v-on:click="remove(index)">
                    <i class="fa fa-trash"></i>
                  </button>
                </div>
              </div>
            </div>
          </div><!-- /.box-body -->
  
          <div class="box-footer">
            <button v-bind:disabled="invalid" 
              v-on:click.stop.prevent="update()"
              type="button" class="btn btn-primary">Submit</button>
          </div>
        </form>
      </div>
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
        name: "{{ $item['nama'] }}",
        items: [
          @foreach($item['struktur'] as $it)
            {
              name: "{{$it->name}}",
              type: "{{$it->type}}",
              value: @if($it->type=='string') "{{$it->value}}" @else {{ $it->value }} @endif
            }
            @if(!$loop->last)
              ,
            @endif
          @endforeach
        ]
      },
      computed: {
        invalid () {
          var nameVal = this.name != undefined && this.name != '';
          if (!nameVal) { return true; }
          for (var i = 0; i < this.items.length; i++) {
            var it = this.items[i];
            if (it.name == '') { return true; }
          }
          return false;
        }
      },
      methods: {
        addItem () {
          this.items.push({
            name: '--',
            type: 'string',
            value: '--'
          })
        },
        remove (index) {
          this.items.splice(index, 1);
        },
        update () {
          var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
          var payload = {
            nama: this.name,
            items: this.items,
            _token: CSRF_TOKEN
          };
          var url = "/hasil-lab/{{$item['id']}}";
          console.log('url = ', url);
          axios.put(url, payload)
            .then(resp => {
              console.log('original request = ', resp.reqest);
              console.log('resp.status = ', resp.status);
              if (resp.status != 200) {
                alert('gagal');
              } else {
                alert('sukses');
              }
            })
            .catch(err => {
              console.log(err.response);
              alert('gagal');
            });
        }
      }
    })
  </script>
@endsection