<div id="signin" class="signWindow">
	<a>X</a>
	<h2>SIGN IN</h2>
	<p class="warning">(account is invalid!)</p>
		<label>User name:</label>
		<input style="color:black;" type="text" placeholder="username" class="logname">
		<label>Password:</label>
		<input style="color:black;" type="password" placeholder="password" class="logpass">
		<button type="button" id="submitLog" data-route="{{route('login')}}" style="color:black;">Log in</button>
		<hr>
		<ul style="display: inline-block; list-style: none">
			<li><i class="fa fa-facebook-square"><button style="color:black;" onclick="location.href='/login/facebook'">facebook</button></i></li>
			<li><i class="fa fa-google"><button onclick="location.href='/login/google'" style="color:black;">google</button></i></li>
		</ul>
</div>

<div id="signup" class="signWindow" >
	<a>X</a>
	<h2>SIGN UP</h2>
	<p class="warning">Atuo Generate Errors!!</p>
		<label>Email:</label>
		<input style="color:black;" type="email" name="email" placeholder="Your email" class="genEmail">
		<button id="submitReg" data-route="{{route('generate-account')}}" type="button" style="color:black;">Auto generate account</button>
	<hr>
		<label class="text-center"> or sign up</label>
		<button type="button" id="signupButton" onclick="location.href='/register'" style="color:black;"> Sign Up</button>
</div>
