	var currentTab = 0;
	var x = document.getElementsByClassName("tab");
	connectDivs("left", "right-1", "blue", 0.2);
	connectDivs("left", "right-2", "blue", 0.2);
	connectDivs("left", "right-3", "blue", 0.0);
	// var level = 1;
	// $('.startBtn').click(async function(){
	// 	let {value: level1} = await Swal.fire({
	// 	  title: 'Please add level',
	// 	  input: 'text',
	// 	  inputPlaceholder: 'Enter your level'
	// 	})
	// 	if (level1) {
		  $('.startBtn').css('opacity','0').css('z-index','-1');
			setTimeout(function(){
				$('#testForm').css('display','block').css('opacity','1')
			}, 700)
			// console.log(level, level1)
			// level = level1;
			// getQA(level, 1);
		// }
	// });
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
		})
		.fail(function(data) {
			console.log(data);
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
	    var content = "<div class='tab' style='display: none;'>" +
                           	"<img class='question' src='"+ question +"' alt=''>" +
                            "<div class='answer'>" +
                                answerHTML +
                        	"</div>" +
                        "</div>" ;
	    $('.button-np').before(content);
	}

	// $(document).on('click', 'label', function(event) {
	// 	event.preventDefault();
	// 	$(this).css('opacity', '1');
	// 	$(this).children('input').attr('checked', true);
	//     $(this).siblings('label').each(function(index, el) {
	//     	$(el).children('input').attr('checked', false);
	//     	$(el).css('opacity', '0.3');
	//     });
	// });

	function createSVG() {
		  var svg = document.getElementById("svg-canvas");
		  if (null == svg) {
		    svg = document.createElementNS("http://www.w3.org/2000/svg", 
		                                   "svg");
		    svg.setAttribute('id', 'svg-canvas');
		    svg.setAttribute('style', 'position:absolute;top:0px;left:0px');
		    svg.setAttribute('width', document.body.clientWidth);
		    svg.setAttribute('height', document.body.clientHeight);
		    svg.setAttributeNS("http://www.w3.org/2000/xmlns/", 
		                       "xmlns:xlink", 
		                       "http://www.w3.org/1999/xlink");
		    document.body.appendChild(svg);
		  }
		  return svg;
		}

	function drawCircle(x, y, radius, color) {
	    var svg = createSVG();
		    var shape = document.createElementNS("http://www.w3.org/2000/svg", "circle");
	    shape.setAttributeNS(null, "cx", x);
	    shape.setAttributeNS(null, "cy", y);
	    shape.setAttributeNS(null, "r",  radius);
	    shape.setAttributeNS(null, "fill", color);
	    svg.appendChild(shape);
	}

	function findAbsolutePosition(el) {
	  	var _x = 0;
	    var _y = 0;
	    while( el && !isNaN( el.offsetLeft ) && !isNaN( el.offsetTop ) ) {
	        _x += el.offsetLeft - el.scrollLeft;
	        _y += el.offsetTop - el.scrollTop;
	        el = el.offsetParent;
	    }
	    
		  return {
		      "x": _x,
		      "y": _y
		  };
	}

	function connectDivs(leftId, rightId, color, tension) {
		  var left = document.getElementById(leftId);
		  var right = document.getElementById(rightId);
			
		  var leftPos = findAbsolutePosition(left);
		  var x1 = leftPos.x;
		  var y1 = leftPos.y;
		  x1 += left.offsetWidth;
		  y1 += (left.offsetHeight / 2);

		  var rightPos = findAbsolutePosition(right);
		  var x2 = rightPos.x;
		  var y2 = rightPos.y;
		  y2 += (right.offsetHeight / 2);

		  var width=x2-x1;
		  var height = y2-y1;

		  drawCircle(x1, y1, 3, color);
		  drawCircle(x2, y2, 3, color);
		  drawCurvedLine(x1, y1, x2, y2, color, tension);
		}

	function drawCurvedLine(x1, y1, x2, y2, color, tension) {
	    var svg = createSVG();
	    var shape = document.createElementNS("http://www.w3.org/2000/svg", 
	                                         "path");
	    if (tension<0) {
		    var delta = (y2-y1)*tension;
		    var hx1=x1;
		    var hy1=y1-delta;
		    var hx2=x2;
		    var hy2=y2+delta;
		    var path = "M " + x1 + " " + y1 + 
		              " C " + hx1 + " " + hy1 + " "  
		                    + hx2 + " " + hy2 + " " 
		                    + x2 + " " + y2;
		} else {
		    var delta = (x2-x1)*tension;
		    var hx1=x1+delta;
		    var hy1=y1;
		    var hx2=x2-delta;
		    var hy2=y2;
		    var path = "M " + x1 + " " + y1 + 
		              " C " + hx1 + " " + hy1 + " "  
		                    + hx2 + " " + hy2 + " " 
		                    + x2 + " " + y2;
		}
	    shape.setAttributeNS(null, "d", path);
	    shape.setAttributeNS(null, "fill", "none");
	    shape.setAttributeNS(null, "stroke", color);
	    svg.appendChild(shape);
	}

	
