@extends('master')
@section('title', 'loginPage')
@section('header')
    <link href="{{ URL::asset('../app/assets/css/signin.css')}}" rel="stylesheet" />
@endsection
@section('content')
    <div class="container">

      <form class="form-signin" name="loginForm" method="post" action="loginController">
        <h2 class="form-signin-heading">Please sign in</h2>
        <label for="inputEmail" class="sr-only">Email address</label>
        <input type="email" id="inputEmail" name="inputEmail" class="form-control" placeholder="Email address" required autofocus>
        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" id="inputPassword" name="inputPassword" class="form-control" placeholder="Password" required>
        @if($msg!="") 
          &nbsp <h4 style="color:red;" > {{ $msg }}</h4>
        @endif
        <div class="checkbox">
          <label>
            <input type="checkbox" value="remember-me"> Remember me
          </label>
        </div>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
      </form>

    </div> <!-- /container -->
@endsection
@section('footer')
@endsection

 