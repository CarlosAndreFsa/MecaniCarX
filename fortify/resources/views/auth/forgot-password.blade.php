@extends('layouts.main_layout')
@section('content')

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-5 card p-5">
                <form action="{{ route('password.email') }}" method="post">
                    @csrf
                    <p class="display-6 text-center">RECUPERAR A SENHA</p>
                    <div class="mb-3">
                        <label for="email">INDIQUE SEU E-MAIL</label>
                        <input type="email" name="email" id="email" class="form-control">
                    </div>

                    <div class="mt-4 d-flex justify-content-between">
                        <div>
                            <a href="{{ route('login') }}">Já sei minha senha</a>
                        </div>
                        <div class="text-end">
                            <button type="submit" class="btn btn-secondary px-5">RECUPERARA SENHA</button>
                        </div>
                    </div>
                </form>
                @if(session('status') || $errors->any())
                    <div class="text-center mt-5">
                        <p>Um email foi enviado para o seus endereço de email com as instruções para recuperação de senha</p>
                        <a href="{{ route('login') }}" class="btn btn-primary px-5">Voltar</a>
                    </div>
                @endif
{{--                @if($errors->any())--}}
{{--                    <div class="alert alert-danger">--}}
{{--                        <ul class="m-0">--}}
{{--                            @foreach( $errors->all() as $erro)--}}
{{--                                <li> {{$erro}} </li>--}}
{{--                            @endforeach--}}
{{--                        </ul>--}}
{{--                    </div>--}}
{{--                @endif--}}
            </div>
        </div>
    </div>
@endsection

