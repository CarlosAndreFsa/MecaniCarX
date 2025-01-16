@extends('layouts.main_layout')
@section('content')

    <div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-5 card p-5">
            <form action="{{ route('password.update')}}" method="post">
                @csrf
                <p class="display-6 text-center">REDEFENIR SENHA</p>
<input type="hidden" value="{{ route('') }}">
                <div class="mb-3">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="password">Senha</label>
                    <input type="password" name="password" id="password" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="password_confirmation">Confirmação da senha</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
                </div>

                <div class="mt-4 d-flex justify-content-between">
                    <div>
                        <a href="{{ route('login') }}">Página Inicial</a>
                    </div>
                    <div class="text-end">
                        <button type="submit" class="btn btn-secondary px-5">Definir Senha</button>
                    </div>
                </div>
            </form>
            {{--            erros--}}
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="m-0">
                        @foreach( $errors->all() as $erro)
                            <li> {{$erro}} </li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
