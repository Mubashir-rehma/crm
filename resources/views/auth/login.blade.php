@extends('main')
@section('title', 'Login')

@section('content')
<div class="main_container">
    <div class="left">
        <div class="top">
            <img src="{{ URL::asset('images/XMLID_665_.png') }}" alt="">
            <img src="{{ URL::asset('images/XMLID_1089_-1.png') }}" alt="" srcset="">
        </div>

        <div class="content">
            <h1>Welcome to DOMAIN BIRD</h1>
            <img src="{{ URL::asset('images/Group 1000001238.png') }}" alt="">
        </div>

        <div class="footer">
            <img src="{{ URL::asset('images/XMLID_982_.png') }}" alt="" srcset="">
            <img src="{{ URL::asset('images/XMLID_1089_.png') }}" alt="" srcset="" style="margin-bottom: -42px;">
            <img src="{{ URL::asset('images/XMLID_932_.png') }}" alt="" srcset="" style="align-self: center;">
            <img src="{{ URL::asset('images/XMLID_1112_.png') }}" alt="" srcset="" style="align-self: baseline;">
        </div>
    </div>
    <div class="right">
        <div class="main_content">
            <div class="logo">
                <img src="{{ URL::asset('images/cropped-domain-logo 1.png') }}" alt="" srcset="" style="width: 170px;">
            </div>
            <div class="content">
                <h2>Sign in to your account</h2>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. In accusamus quibusdam laudantium a! Pariatur quod facilis dolor sed.</p>

                <div class="inputs">
                    <form method="post" id="login_form">
                        @csrf

                        <div class="input">
                            {!! Form::email('email', '', ['id' => 'email']) !!}
                            <label for="email"><i class="fa-solid fa-envelope"></i> Email</label>
                            <div class="invalid-feedback"></div>
                        </div>

                        <div class="input">
                            {!! Form::password('password', ['id' => 'password']) !!}
                            <label for="password"><i class="fa-solid fa-lock"></i> Password</label>
                            <div class="invalid-feedback"></div>
                        </div>

                        <div class="input" style="text-align: right;">
                            <a href="/forgot-password" class="fp">Forgot Your Password?</a>
                        </div>

                        <input type="submit" value="Login" id="login_btn" style="width: 100%;margin-top: 50px;">
                        {{-- {!! Form::button('Login', ['id' => 'login_btn', 'style' => 'width: 100%;margin-top: 50px;']) !!} --}}
                    </form>
                </div>
            </div>
            <div class="footer">
                All Rightd Reserved to @Domain Bird
            </div>
        </div>

    </div>
</div>
@endsection

@section('style')
    <link rel="stylesheet" href="{{ URL::asset('css/login.css') }}">
@endsection

@section('script')
    <script>
        $("body").on("keyup", "input", function(){
            var label = $(this).next()
            var value = $(this).val().trim()

            if(value !== ""){
                label.css({'top' : 0})
            } else if(value == "") {
                label.css({'top' : '35px'})
            }

        })

        $("body").on('submit', "#login_form", function(e){
            e.preventDefault();
            $("body #login_btn").val("Please wait...")
            $.ajax({
                url: '{{ route('auth.login') }}',
                method: 'post',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(data){
                    if(data.status == 400){
                        showError('email', data.message.email)
                        showError('password', data.message.password)
                        $("#login_btn").val("Login")
                    } else if(data.status == 401){
                        $(".success_msg").html(showMessage('fail', data.message))
                        $("#login_btn").val("Login")
                    } else if(data.status == 200){
                        $(".success_msg").append(showMessage('success', data.message))
                        $("#login_form")[0].reset()
                        console.log("Loged in");
                        removeValidtationClasses("#login_form")
                        $("#login_btn").val("Login")
                        window.location = '{{ route("/") }}'
                    } else {
                        $(".success_msg").html(showMessage('fail', "Please make sure you are connected to interent"))
                        $("#login_btn").val("Login")
                    }
                },
                error: function() {
                    console.log('Internet connection is not available.');
                }
            })
        })

        $("body").on('click', '.btn-close', function(){
            $(this).parent().remove()
        })
    </script>
@endsection
