	var currentTab = 0;
	var x = document.getElementsByClassName("tab");
	var sound = null;

var music_image = '<svg id="play"  viewBox="0 0 163 163" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px"="0px">'+
			'    '+
			'    <g fill="none">'+
			'        <g  transform="translate(2.000000, 2.000000)" stroke-width="4">'+
			'            <path d="M10,80 C10,118.107648 40.8923523,149 79,149 L79,149 C117.107648,149 148,118.107648 148,80 C148,41.8923523 117.107648,11 79,11" id="lineOne" stroke="#A5CB43"></path>'+
			'            <path d="M105.9,74.4158594 L67.2,44.2158594 C63.5,41.3158594 58,43.9158594 58,48.7158594 L58,109.015859 C58,113.715859 63.4,116.415859 67.2,113.515859 L105.9,83.3158594 C108.8,81.1158594 108.8,76.6158594 105.9,74.4158594 L105.9,74.4158594 Z" id="triangle" stroke="#A3CD3A"></path>'+
			'            <path d="M159,79.5 C159,35.5933624 123.406638,0 79.5,0 C35.5933624,0 0,35.5933624 0,79.5 C0,123.406638 35.5933624,159 79.5,159 L79.5,159" id="lineTwo" stroke="#A5CB43"></path>'+
			'        </g>'+
			'    </g>'+
			'</svg>';


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
			Swal.fire({
			  type: 'error',
			  title: 'Oops...',
			  text: 'Something went wrong!'
			})
		});
	}

	$(document).on('mouseover', '.audio-image', function(event) {
		event.preventDefault();
		let music = $(this).siblings('.audio').attr('src');
		 if (sound != null) {
	        sound.stop();
	        sound.unload();
	        sound = null;
	    }
		sound = new Howl({
		  src: [music],
		  format: 'mp3'
		});
		sound.play();
	});

	$(document).on('mouseleave', '.audio-image', function(event) {
		event.preventDefault();
		sound.stop();
        sound.unload();
        sound = null;
	});

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
				answerHTML += "<label class='col-4'>" +
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
