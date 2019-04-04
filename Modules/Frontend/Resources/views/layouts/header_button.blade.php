<div id="modal-sign-in" class="modal fade" role="dialog">
    <div class="modal-dialog" id="signin">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-center">SIGN IN</h4>
                <a type="button" class="close-modal" data-dismiss="modal">&times;</a>
            </div>
            <div class="modal-body">
                 <div class="content">
                    <small class="login-errors text-danger hide">(account is invalid!)</small>
                    <div class="form-group">
                        <label for="" >Username:</label>
                        <input type="text" class="form-control logname">
                        <small class="text-danger hide usernameError"></small>
                    </div>
                    <div class="form-group">
                        <label for=""  >Password:</label>
                        <input type="password" class="form-control logpass">
                        <small class="text-danger hide passwordError"></small>
                    </div>
                    <div class="clearfix">
                        <label class="pull-left checkbox-inline"><input type="checkbox"> Remember me</label>
                        {{-- <a href="#" class="pull-right">Forgot Password?</a> --}}
                    </div>
                    <div class="form-group text-center div-login">
                        <button type="submit" data-route="{{route('login')}}" id="submitLog" class="btn login-btn btn-inline-block">Sign in</button>
                    </div>
                </div>
                <div class="or-seperator"><i>or</i></div>
                <p class="text-center">Login with your social media account</p>
                <div class="text-center social-btn">
                    <a href="{{route('social',['facebook'])}}" class="btn btn-primary"><i class="fa fa-facebook"></i>&nbsp; Facebook</a>
                    <a href="{{route('social',['google'])}}" class="btn btn-danger"><i class="fa fa-google-plus"></i>&nbsp; Google</a>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="modal-sign-up" class="modal fade" role="dialog">
    <div class="modal-dialog" id="signup">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-center">SIGN UP </h4>
                <a type="button" class="close-modal" data-dismiss="modal">&times;</a>
            </div>
            <div class="modal-body">
                 <div class="content">
                    {{-- <div class="form-group">
                        <label for=""  >Password:</label>
                        <input type="password" class="form-control logpass">
                        <small class="text-danger hide passwordError"></small>
                    </div> --}}
                    <p class="text-center">Generate Account</p>
                    <div class="form-group text-center div-login">
                        <button type="button" data-route="{{route('generate')}}" id="genButton" class="btn login-btn btn-inline-block">Generate</button>
                        {{-- <a type="button" href="{{route('generate')}}" class="btn login-btn btn-inline-block gen-btn">Generate</a> --}}
                    </div>
                </div>
                <div class="or-seperator"><i>or</i></div>
                <p class="text-center">Create new account</p>
                <div class="text-center div-signup">
                    {{-- <a href="{{route('register')}}" class="btn signup-btn"> Sign Up</a> --}}
                    <a type="button" data-dismiss="modal" data-toggle="modal" data-target="#modal-register" class="btn signup-btn"> Sign Up</a>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="modal-register" class="modal fade" role="dialog">
    <div class="modal-dialog" id="register">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-center">Register</h4>
                <a type="button" class="close-modal" data-dismiss="modal">&times;</a>
            </div>
            <div class="modal-body">
                <form id="form-sign-up" enctype="multipart/form-data" class="validate" method="POST">
                    <div class="content">
                        <div class="form-group">
                            <label for="" >Username:</label>
                            <input type="text" class="form-control regName" required name="username">
                            <small class="text-danger hide usernameError"></small>
                        </div>
                        <div class="form-group">
                            <label for="" >Email:</label>
                            <input type="Email" class="form-control regEmail" required name="email">
                            <small class="text-danger hide emailError"></small>
                        </div>
                        <div class="form-group">
                            <label for=""  >Password:</label>
                            <input type="password" class="form-control regPassword" required name="password">
                            <small class="text-danger hide passwordError"></small>
                        </div>
                        <div class="form-group">
                            <label for=""  >Confirmation Password:</label>
                            <input type="password" class="form-control regPasswordConfirm" required name="password_confirmation">
                            <small class="text-danger hide passwordConFirmError"></small>
                        </div>
                        <div class="form-group">
                            <label for="" >Full Name:</label>
                            <input type="text" class="form-control regFullname" name="fullname">
                            <small class="text-danger hide fullnameError"></small>
                        </div>
                        <div class="clearfix"></div>
                        <div class="form-group text-center div-register">
                            <button type="submit" data-route="{{route('register')}}" id="regButton" class="btn register-btn btn-inline-block">Register</button>
                        </div>
                    </div>
                </form>

                <div class="or-seperator"><i>or</i></div>
                <div class="clearfix">
                    <p class="text-center">Already have an account? <a type="button" data-dismiss="modal" data-toggle="modal" data-target="#modal-sign-in" class="btn signin-btn"> Sign In</a></p>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="modal-after-answertoppic" class="modal fade" role="dialog">
    <div class="modal-dialog" id="answertoppic">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-center"> </h4>
                <a type="button" class="close-modal" data-dismiss="modal">&times;</a>
            </div>
            <div class="modal-body">
                 <div class="content">
                    <p class="text-center">Sign in</p>
                    <div class="text-center div-signup">
                    <a type="button" data-dismiss="modal" data-toggle="modal" data-target="#modal-sign-in" class="btn signup-btn"> Sign in</a>
                </div>
                </div>
                <div class="or-seperator"><i>or</i></div>
                <p class="text-center">Create new account</p>
                <div class="text-center div-signup">
                    <a type="button" data-dismiss="modal" data-toggle="modal" data-target="#modal-register" class="btn signup-btn"> Sign Up</a>
                </div>
                <div class="or-seperator"><i>or</i></div>
                <p class="text-center">Next quiz!</p>
                <div class="text-center div-signup">
                    <a type="button" data-dismiss="modal" id="continues-test" class="btn signup-btn"> Continues</a>
                </div>
            </div>
        </div>
    </div>
</div>