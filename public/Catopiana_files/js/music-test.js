	var currentTab = 0;
	var x = document.getElementsByClassName("tab");

	$('.startBtn').click(async function(){
		  $(this).css('opacity','0').css('z-index','-1');
			setTimeout(function(){
				$('#testForm').css('display','block').css('opacity','1')
			}, 700)
			getQASound(1);
	});

	function getQASound(num){

		$.ajax({
			url: '/getQAAudio',
			type: 'GET',
			dataType: 'json',
			data: { "num" : num},
		})
		.done(function(data) {
			console.log(data);
			render(data.question, data.answers, data.question_image, data.answer_image );
			showTab(currentTab);
		})
		.fail(function(data) {
			console.log(data);
		});
	}

	$(document).on('mouseover', '.audio-image', function(event) {
		event.preventDefault();
		var music = $(this).siblings('.audio').attr('src');
		console.log(music);

		var sound = new Howl({
		  src: [music],
		  format: 'mp3'
		}).play();
	});

	function showTab(n) {
	    for(var i=0; i<x.length; i++){
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
	    var x = document.getElementsByClassName("tab");
	    x[currentTab].style.display = "none";
	    if(currentTab < x.length - 1 ){
	    	currentTab = currentTab + 1;
	    	showTab(currentTab);
	    }else{
		    currentTab = currentTab + 1;
		    getQASound( currentTab + 1)
	    }

	}

	function prev() {
	    var x = document.getElementsByClassName("tab");
	    x[currentTab].style.display = "none";

	    // reder html
	    currentTab = currentTab - 1;
	    showTab(currentTab);

	}

	function render(question, answers, question_image, answer_image){
		var answerHTML = "";
		answers.forEach(function(el) {
				answerHTML += "<label class='col-6'>" +
                                "<input type='radio' name='' value='A'>" +
                                "<img class='audio-image' src='" + answer_image +"' alt=''>" +
                                "<audio src='"+ el+"' class='audio'></audio>" +
                            "</label>"

			});
	    var content = "<div class='tab' style='display: none;'>" +
                           	"<img class='question audio-image' src='"+ question_image +"' alt=''>" +
                           	"<audio src='"+ question +"' class='audio'></audio>" +
                            "<div class='answer'>" +
                                answerHTML +
                        	"</div>" +
                        "</div>" ;
	    $('.button-np').before(content);
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
