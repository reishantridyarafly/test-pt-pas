@extends('layouts.auth.main')
@section('title', 'Masuk')
@section('content')
    <div class="card-body p-4">
        <div class="text-center mt-2">
            <h5 class="text-primary">Masuk</h5>
        </div>
        <div class="p-2 mt-4">
            <form id="loginForm">
                <div class="mb-3">
                    <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="email" name="email" placeholder="Masukan email">
                    <small class="text-danger errorEmail mt-2"></small>
                </div>

                <div class="mb-3">
                    <label class="form-label" for="password">Kata Sandi <span class="text-danger">*</span></label>
                    <input type="password" class="form-control password-input" placeholder="Masukan kata sandi"
                        id="password" name="password">
                    <small class="text-danger errorPassword mt-2"></small>
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="remember" name="remember"
                        {{ old('remember') ? 'checked' : '' }}>
                    <label class="form-check-label" for="remember">Ingat saya</label>
                </div>

                <div class="mt-4">
                    <button id="login" class="btn btn-success w-100" type="submit">Masuk</button>
                </div>

            </form>
        </div>
    </div>
    <!-- end card body -->
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#email').on('input', function() {
                $(this).removeClass('is-invalid');
                $('.errorEmail').html('');
            });

            $('#password').on('input', function() {
                $(this).removeClass('is-invalid');
                $('.errorPassword').html('');
            });

            $('#loginForm').submit(function(e) {
                e.preventDefault();
                $.ajax({
                    data: $(this).serialize(),
                    url: "{{ route('login') }}",
                    type: "POST",
                    dataType: 'json',
                    beforeSend: function() {
                        $('#login').prop('disabled', true).html(
                            '<i class="mdi mdi-loading mdi-spin me-2"></i> Proses...'
                        );

                        $('.form-control').removeClass('is-invalid');
                        $('.text-danger').html('');
                    },
                    complete: function() {
                        $('#login').prop('disabled', false).text('Masuk');
                    },
                    success: function(response) {
                        if (response.redirect) {
                            window.location.href = response.redirect;
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            if (errors.email) {
                                $('#email').addClass('is-invalid');
                                $('.errorEmail').html(errors.email.join('<br>'));
                            }
                            if (errors.password) {
                                $('#password').addClass('is-invalid');
                                $('.errorPassword').html(errors.password.join('<br>'));
                            }
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Kesalahan',
                                text: 'Terjadi kesalahan, silakan coba lagi.',
                                confirmButtonColor: '#3085d6',
                                confirmButtonText: 'OK'
                            });
                        }
                    }
                });
            });
        });
    </script>
@endsection
