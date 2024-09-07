@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center" style="max-height: 100vh">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">

                        <center><a href="<?= aplikasi()[0]->toko ?>" target="_blank"><img src="<?php echo asset('gambar/' . aplikasi()[0]->icon); ?>"
                                    width="210" alt="homepage" /></a></center>
                        <form method="POST" action="{{ route('login') }}" aria-label="{{ __('Login') }}">
                            @csrf
                            <br>
                            <div class="form-group row">
                                <label for="email" class="col-sm-4 col-form-label text-md-right">Username</label>

                                <div class="col-md-6">
                                    <input id="username" type="text"
                                        class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}"
                                        name="username" value="{{ old('username') }}" placeholder="admin" required
                                        autofocus>

                                    @if ($errors->has('email'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>

                                <div class="col-md-6">
                                    <input id="password" type="password"
                                        class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                                        placeholder="********" name="password" required>

                                    @if ($errors->has('password'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-md-right"></label>
                                <div class="col-md-6">
                                    {{-- @if (app()->environment('production')) --}}
                                        <center>
                                            <div class="g-recaptcha" data-sitekey="<?= aplikasi()[0]->rechaptca ?>"></div>
                                        </center>
                                    {{-- @endif --}}
                                </div>
                            </div>
                            <input type="hidden" name="status" value="aktif">
                            <div class="form-group row mb-0">
                                <div class="col-md-12">
                                    <center>

                                        <button type="submit" class="btn btn-primary btn-lg">
                                            {{ __('Login') }}
                                        </button>
                                        <br>
                                    </center>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
