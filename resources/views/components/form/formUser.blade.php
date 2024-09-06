<form id="{{ $form_id }}" action="#" method="POST" enctype="multipart/form-data">
    @csrf
    @if (isset($method) && $method == 'PUT')
        @method('PUT')
    @endif

    <div class="row">
        <div class="col-lg col-md">
            {{-- Username --}}
            @component('components.formGroup.input',
                [
                    'label' => 'Nama Pengguna',
                    'type' => 'text',
                    'class' => '',
                    'id' => 'username',
                    'name' => 'username',
                    'placeholder' => 'Masukkan',
                    'value' => $user->username ?? '',
                ])
            @endcomponent
        </div>
        <div class="col-lg col-md">
            {{-- Password --}}
            @component('components.formGroup.input',
                [
                    'label' => 'Kata Sandi',
                    'type' => 'text',
                    'class' => '',
                    'id' => 'password',
                    'name' => 'password',
                    'placeholder' => 'Masukkan',
                    'value' => '',
                ])
            @endcomponent
            <div class="mx-3 text-danger d-none" id="ket-pass">Biarkan kosong apabila tidak ingin mengubah kata sandi
            </div>
        </div>
    </div>
    <div class="row {{ isset($user) && $user->id == 1 ? 'd-none' : '' }} ">
        <div class="col-lg col-md">
            {{-- Role --}}
            <div class="form-group">
                <label>Role</label><br>
                @if (Auth::user()->id == 1)
                    @component('components.formGroup.radio',
                        ['label' => 'Admin', 'id' => 'Admin', 'name' => 'role', 'value' => 'Admin', 'checked' => $user->role ?? null])
                    @endcomponent
                @endif
                @component('components.formGroup.radio',
                    [
                        'label' => 'Sub Admin',
                        'id' => 'sub-admin',
                        'name' => 'role',
                        'value' => 'Sub Admin',
                        'checked' => $user->role ?? null,
                    ])
                @endcomponent
                @component('components.formGroup.radio',
                    [
                        'label' => 'Institusi/Universitas',
                        'id' => 'institusi',
                        'name' => 'role',
                        'value' => 'Institusi',
                        'checked' => $user->role ?? null,
                    ])
                @endcomponent
                @component('components.formGroup.radio',
                    [
                        'label' => 'Supervisor/DPL',
                        'id' => 'supervisor',
                        'name' => 'role',
                        'value' => 'Supervisor',
                        'checked' => $user->role ?? null,
                    ])
                @endcomponent
                @component('components.formGroup.radio',
                    [
                        'label' => 'Surveyor/Mahasiswa',
                        'id' => 'Surveyor',
                        'name' => 'role',
                        'value' => 'Surveyor',
                        'checked' => $user->role ?? null,
                    ])
                @endcomponent
                <span class="text-danger d-block error-text role-error"></span>
            </div>
        </div>
        <div class="col-lg col-md">
            {{-- Status --}}
            <div class="form-group">
                <label>Status</label><br>
                @component('components.formGroup.radio',
                    ['label' => 'Aktif', 'id' => 'Aktif', 'name' => 'status', 'value' => '1', 'checked' => $user->status ?? null])
                @endcomponent
                @component('components.formGroup.radio',
                    [
                        'label' => 'Tidak Aktif',
                        'id' => 'Tidak Aktif',
                        'name' => 'status',
                        'value' => '2',
                        'checked' => $user->status ?? null,
                    ])
                @endcomponent
                <span class="text-danger d-block error-text status-error"></span>
            </div>
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
            if ('{{ $form_id }}' == 'form_edit_user') {
                $('#ket-pass').removeClass('d-none');
                $('#password').attr('type', 'password');
                $('#password').click(function() {
                    $('#password').attr('type', 'text');
                    $('#password').val('');
                });
            }

            $('#{{ $form_id }}').submit(function(e) {
                $("#overlay").fadeIn(100);
                e.preventDefault();
                $('.error-text').text('');
                var formData = new FormData(this)
                $.ajax({
                    type: "POST",
                    url: "{{ $action }}",
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    data: formData,
                    cache: false,
                    processData: false,
                    contentType: false,
                    success: function(data) {
                        $("#overlay").fadeOut(100);
                        if ($.isEmptyObject(data.error)) {
                            if ('{{ $method }}' == 'PUT') {
                                swal({
                                    title: "Berhasil!",
                                    text: "Perubahan berhasil disimpan!",
                                    icon: "success",
                                    button: false
                                })
                            } else {
                                swal({
                                    title: "Berhasil!",
                                    text: "Data berhasil disimpan!",
                                    icon: "success",
                                    button: false
                                })
                            }
                            setTimeout(
                                function() {
                                    window.location.href = '{{ url()->previous() }}';
                                }, 2000);
                        } else {
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
                $.each(msg, function(key, value) {
                    $('.' + key + '-error').text(value);
                });
            }


        });
    </script>
@endpush
