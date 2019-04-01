{{--<div id="signin" class="signWindow">--}}
	{{--<a>X</a>--}}
	{{--<h2>SIGN IN</h2>--}}
	{{--<p class="warning">(account is invalid!)</p>--}}
		{{--<label>User name:</label>--}}
		{{--<input style="color:black;" type="text" placeholder="username" class="logname">--}}
		{{--<label>Password:</label>--}}
		{{--<input style="color:black;" type="password" placeholder="password" class="logpass">--}}
		{{--<button type="button" id="submitLog" data-route="{{route('login')}}" style="color:black;">Log in</button>--}}
		{{--<hr>--}}
		{{--<ul style="display: inline-block; list-style: none">--}}
			{{--<li><i class="fa fa-facebook-square"><button style="color:black;" onclick="location.href='/login/facebook'">facebook</button></i></li>--}}
			{{--<li><i class="fa fa-google"><button onclick="location.href='/login/google'" style="color:black;">google</button></i></li>--}}
		{{--</ul>--}}
{{--</div>--}}

{{--<div id="signup" class="signWindow" >--}}
	{{--<a>X</a>--}}
	{{--<h2>SIGN UP</h2>--}}
	{{--<p class="warning">Atuo Generate Errors!!</p>--}}
		{{--<label>Email:</label>--}}
		{{--<input style="color:black;" type="email" name="email" placeholder="Your email" class="genEmail">--}}
		{{--<button id="submitReg" data-route="{{route('generate-account')}}" type="button" style="color:black;">Auto generate account</button>--}}
	{{--<hr>--}}
		{{--<label class="text-center"> or sign up</label>--}}
		{{--<button type="button" id="signupButton" onclick="location.href='/register'" style="color:black;"> Sign Up</button>--}}
{{--</div>--}}

<div id="modal-sign-in" class="modal fade" role="dialog">
    <div class="modal-dialog" id="signin">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-center">SIGN IN</h4>
            </div>
            <div class="modal-body">
                <div class="login-form">
                    <form action="/examples/actions/confirmation.php" method="post">
                        <h2 class="text-center">Sign in</h2>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                <input type="text" class="form-control" name="username" placeholder="Username" required="required">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                <input type="password" class="form-control" name="password" placeholder="Password" required="required">
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary login-btn btn-block">Sign in</button>
                        </div>
                        <div class="clearfix">
                            <label class="pull-left checkbox-inline"><input type="checkbox"> Remember me</label>
                            <a href="#" class="pull-right">Forgot Password?</a>
                        </div>
                        <div class="or-seperator"><i>or</i></div>
                        <p class="text-center">Login with your social media account</p>
                        <div class="text-center social-btn">
                            <a href="#" class="btn btn-primary"><i class="fa fa-facebook"></i>&nbsp; Facebook</a>
                            <a href="#" class="btn btn-info"><i class="fa fa-twitter"></i>&nbsp; Twitter</a>
                            <a href="#" class="btn btn-danger"><i class="fa fa-google"></i>&nbsp; Google</a>
                        </div>
                    </form>
                    <p class="text-center text-muted small">Don't have an account? <a href="#">Sign up here!</a></p>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>
