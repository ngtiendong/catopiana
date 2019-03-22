	var currentTab = 0;
	var x = document.getElementsByClassName("tab");
	var level = 1;
	var type = 'normal';
	var style = '';
	var timeout = 5;
	var timerId = null;

	var pathname = window.location.pathname;
	if(pathname == '/memory')
		{
			type = 'memory';
		}
	console.log(pathname);
	$('.startBtn').click(async function(){
		let {value: level1} = await Swal.fire({
		  title: 'Please add level',
		  input: 'text',
		  inputPlaceholder: 'Enter your level'
		})
		if (level1) {
		  $(this).css('opacity','0').css('z-index','-1');
			setTimeout(function(){
				$('#testForm').css('display','block').css('opacity','1')
			}, 700)
			level = level1;
			getQA(level, 1);

		}
	});
	function getQA(level, num){
		$.ajax({
			url: '/getQA',
			type: 'GET',
			dataType: 'json',
			data: {"level": level, "num" : num}
		})
		.done(function(data) {
			console.log(data);
			render(data.question, data.answers);
			showTab(currentTab);
			if(type == 'memory'){
				if(timerId != null){
					clearTimeout(timerId);
					timeout = 5;
				}
				hideQuestion(currentTab);
			}
		})
		.fail(function(data) {
			Swal.fire({
			  type: 'error',
			  title: 'Oops...',
			  text: 'Something went wrong!'
			})
		});
	}

	function showTab(n) {
	    for(let i=0; i<x.length; i++){
	        x[i].style.display = "none";
	    }
	    x[n].style.display = "flex";
	    if (n == 0) {
	    	document.getElementById("prevBtn").style.display = "none";
	    } else {
	    	document.getElementById("prevBtn").style.display = "inline";
	    }
	    // if (n == (x.length - 1)) {
	    //     document.getElementById("nextBtn").innerHTML = "Submit";
	    // } else {
	    //     document.getElementById("nextBtn").innerHTML = "Next";
	    // }
	    // fixStepIndicator(n)
	}

	function fixStepIndicator(n) {
	    var i, x = document.getElementsByClassName("step");
	    for (i = 0; i < x.length; i++) {
	        x[i].className = x[i].className.replace(" active", "");
	    }
	    x[n].className += " active";
	}

	function currentQ(n) {
	    currentTab = n;
	    showTab(currentTab);
	}

	function next(n) {
		if(type == 'memory' && timerId != null && timeout != 5 && timeout != -1)
		{
			return false;
		}
	    var x = document.getElementsByClassName("tab");
	    x[currentTab].style.display = "none";
	    if(currentTab < x.length - 1 ){
	    	currentTab = currentTab + 1;
	    	showTab(currentTab);
	    }else{
		    currentTab = currentTab + 1;
		    getQA(level, currentTab + 1)
	    }
	    
	}

	function prev() {
		if(type == "memory" &&timerId != null && timeout != 5 && timeout != -1)
		{
			return false;
		}
	    var x = document.getElementsByClassName("tab");
	    x[currentTab].style.display = "none";

	    // reder html
	    currentTab = currentTab - 1;
	    showTab(currentTab);
	    
	}

	function render(question, answers){
		var answerHTML = "";
		answers.forEach(function(el) {
				answerHTML += "<label class='col-6'>" +
                                "<input type='radio' name='' value='A'>" +
                                "<img src='" + el +"' alt=''>" +
                            "</label>" 

			});
		if(type == "memory" ){
			style = 'style="visibility : hidden;"';
		}
	    var content = "<div class='tab' style='display: none;'>" +
                           	"<img class='question' src='"+ question +"' alt=''>" +
                           	'<p class="countDownTimer"></p>' +
                            "<div class='answer'"+ style +">" +
                                answerHTML +
                        	"</div>" +
                        "</div>" ;
	    $('.button-np').before(content);
	}

	function hideQuestion(currentTab){
		var x = document.getElementsByClassName("tab");
		$(x[currentTab]).children('answer').css('visibility' ,'hidden')
		timerId = setInterval(function() { 
			if (timeout == -1) {
		    		$(x[currentTab]).children('img').css('visibility' ,'hidden')
					$(x[currentTab]).children('.answer').css('visibility' ,'visible')
					$('.countDownTimer').html( 'time out!')
					clearTimeout(timerId);
					timeout = 5;
			    } else {
			        $('.countDownTimer').html( timeout + ' seconds');
			        timeout--;
			    }
		 }, 1000);
	}
	
	$(document).on('click', 'label', function(event) {
		event.preventDefault();
		$(this).css('opacity', '1');
		$(this).children('input').attr('checked', true);
	    $(this).siblings('label').each(function(index, el) {
	    	$(el).children('input').attr('checked', false);
	    	$(el).css('opacity', '0.3');
	    });
	});


	
