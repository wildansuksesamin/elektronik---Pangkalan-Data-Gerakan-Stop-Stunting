<form id="{{$form_id}}" action="#" method="POST" enctype="multipart/form-data">
    @csrf
    {{-- @if(isset($method) && $method == 'PUT')
        @method('PUT')
    @endif --}}
    
    <div class="row">
        <div class="col-lg col-md">
            {{-- Username --}}
            @component('components.formGroup.input', ['label' => 'Nama Pengguna', 'type' => 'text', 'class' => '', 'id' => 'username', 'name' => 'username', 'placeholder' => 'Masukkan', 'value' => $user->username ?? ''])
            @endcomponent
            {{-- Password --}}
            @component('components.formGroup.input', ['label' => 'Kata Sandi', 'type' => 'text', 'class' => '', 'id' => 'password', 'name' => 'password', 'placeholder' => 'Masukkan', 'value' => ''])
            @endcomponent
            <div class="mx-3 text-danger d-none" id="ket-pass">Biarkan kosong apabila tidak ingin mengubah kata sandi</div>
        </div>
    </div>

    {{-- Submit --}}
    <div class="form-row mt-2">
        <div class="form-group ml-auto">
            @component('components.buttons.submit', ['label' => 'Simpan'])
            @endcomponent
        </div>
    </div>
</form>

@push('script')
    <script>
        $(function() {
            if('{{$form_id}}' == 'form_edit_user2'){
                $('#ket-pass').removeClass('d-none');
                $('#password').attr('type', 'password');
                $('#password').click(function(){
                    $('#password').attr('type', 'text');
                    $('#password').val('');
                });
            }

            $('#{{$form_id}}').submit(function(e){
                $("#overlay").fadeIn(100);
                e.preventDefault();
                $('.error-text').text('');
                var formData = new FormData(this)
                $.ajax({
                    type: "POST",
                    url: "{{$action}}",
                    headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                    data: formData,
                    cache : false,
                    processData: false,
                    contentType: false,
                    success: function (data) {
                        $("#overlay").fadeOut(100);
                        console.log(data)
                        if ($.isEmptyObject(data.error)) {
                            swal({
                                title: "Berhasil!",
                                text: "Perubahan akun berhasil disimpan!",
                                icon: "success",
                                button: false
                            })                        
                            setTimeout(
                            function () {
                                window.location.href = "{{$back_url}}";
                            }, 2000);
                        }
                        else{
                            swal({
                                title: "Terjadi Kesalahan!",
                                text: "Data gagal disimpan, silahkan cek kembali inputan anda.",
                                icon: "error",
                            });
                            printErrorMsg(data.error);
                        }
                    },
                })
            })

            const printErrorMsg = (msg) => {
                $.each(msg, function (key, value) {
                    $('.' + key + '-error').text(value);
                });
            }
        });
    </script>
@endpush