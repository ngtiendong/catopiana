	var currentTab = 0;
	var tab_number = document.getElementsByClassName("tab");
	var relativeEl = document.getElementsByClassName("matching")
	var leftItemImage = "";
	var rightItemImage = "";
	var level = 4;
	var sourceTest = "/test/images/15C.png"

	$('.startBtn').click(async function(){
		let {value: level1} = await Swal.fire({
		  title: 'Please add level',
		  input: 'text',
		  inputPlaceholder: 'Enter your level'
		})
		if (level1) {
		  $('.startBtn').css('opacity','0').css('z-index','-10');
			setTimeout(function(){
				$('#testForm').css('display','block').css('visibility','visible').css('opacity','1')
			}, 700)


			render();
			showTab(currentTab)
		}
	});

	function showTab(n) {
	    // //Badge
	    // console.log(currentTab)
	    // $('.badge').text((currentTab+1)+' / '+total_question)
	    // console.log(currentTab)
	    //Button
	    for (let i = 0; i < tab_number.length; i++) {
	        tab_number[i].style.display = "none";
	    }
	    tab_number[n].style.display = "inline"; 
	    // tab display inline dep nhung ma draw dc :3 do vi tri tinh chat cua may thang position vs display :3
	    if (n === 0) {
	        document.getElementById("prevBtn").style.display = "none";
	        document.getElementById("submitBtn").style.display = "none";

	    // }else if (n === total_question - 1) {
	    //     document.getElementById("nextBtn").style.display = "none";
	    //     document.getElementById("submitBtn").style.display = "inline";

	    }
	    else {
	        document.getElementById("submitBtn").style.display = "none";
	        document.getElementById("prevBtn").style.display = "inline";
	        document.getElementById("nextBtn").style.display = "inline";
	    }
	}

	function next(n) {
	    var x = document.getElementsByClassName("tab");
	    x[currentTab].style.display = "none";
	    if(currentTab < x.length - 1 ){
	    	currentTab = currentTab + 1;
	    	showTab(currentTab);
	    }else{
		    currentTab = currentTab + 1;
	    	render();
		    showTab(currentTab);
	    }
	    
	}

	function prev() {
	    var x = document.getElementsByClassName("tab");
	    x[currentTab].style.display = "none";

	    // reder html
	    currentTab +=  - 1;
	    showTab(currentTab);
	    
	}

	function render(){
		var content = "";
		
		content += '<div class=\'tab\' style=\'display: none;\'>'+
		'    <div class="matching row" style="position: relative;">';

		content += '<div class="div-l column" style="float:left; width:30% ">'+
		'            <ul class="list-l">'+
		'                <li class="list-l-item"  style="margin:10px; padding: 5px;"><img id="'+ currentTab +'-l1" data-pointed="0" class="image-point-l" style="width:200px; border-radius: 15px; cursor: pointer;  " src="'+ sourceTest +'" alt=""></li>'+
		'                <li class="list-l-item"  style="margin:10px; padding: 5px;"><img id="'+ currentTab +'-l2" data-pointed="0" class="image-point-l" style="width:200px; border-radius: 15px; cursor: pointer; " src="'+ sourceTest +'" alt=""></li>'+
		'                <li class="list-l-item"  style="margin:10px; padding: 5px;"><img id="'+ currentTab +'-l3" data-pointed="0" class="image-point-l" style="width:200px; border-radius: 15px; cursor: pointer; " src="'+ sourceTest +'" alt=""></li>'+
		'            </ul>'+
		'        </div>'+
		'        <div class="div-m column" style="float:left; width:40% "></div>'+
		'        <div class="div-r column" style="float:left; width:30% ">'+
		'            <ul class="list-r">'+
		'                <li class="list-r-item"  style="margin:10px; padding: 5px;"><img id="'+ currentTab +'-r1" data-pointed="0" class="image-point-r" style="width:200px; border-radius: 15px; cursor: pointer; " src="'+ sourceTest +'" alt=""></li>'+
		'                <li class="list-r-item"  style="margin:10px; padding: 5px;"><img id="'+ currentTab +'-r2" data-pointed="0" class="image-point-r" style="width:200px; border-radius: 15px; cursor: pointer; " src="'+ sourceTest +'" alt=""></li>'+
		'                <li class="list-r-item" style="margin:10px; padding: 5px;"><img id="'+ currentTab +'-r3" data-pointed="0" class="image-point-r" style="width:200px; border-radius: 15px; cursor: pointer; " src="'+ sourceTest +'" alt=""></li>'+
		'            </ul>'+
		'        </div>';
			
		content += '</div>'+
		'    <div class="clearfix"></div>'+
		'</div>';
	



	    $('.button-np').before(content);
	    return;
	}

	
	$(document).on('click', '.image-point-l', function(event) {
		if($(this).attr('data-pointed') == "1"){
			return false;
		}
		leftItemImage = $(this).attr('id');
		// draw line 
		if(leftItemImage != "" && rightItemImage != ""){
			connectDivs(leftItemImage, rightItemImage, "blue", 0.2, currentTab);
			document.getElementById(leftItemImage).setAttribute("style", "opacity: 0.8;");
			document.getElementById(leftItemImage).setAttribute('data-pointed','1');
			document.getElementById(rightItemImage).setAttribute("style", "opacity:0.8;");
			document.getElementById(rightItemImage).setAttribute('data-pointed','1');
			leftItemImage = "";
			rightItemImage = "";
		}
	});

	$(document).on('click', '.image-point-r', function(event) {
		if($(this).attr('data-pointed') == "1"){
			return false;
		}
		rightItemImage = $(this).attr('id');
		// draw line 
		if(leftItemImage != "" && rightItemImage != ""){
			connectDivs(leftItemImage, rightItemImage, "blue", 0.2, currentTab);
			document.getElementById(leftItemImage).setAttribute("style", "opacity: 0.8;");
			document.getElementById(leftItemImage).setAttribute('data-pointed','1');
			document.getElementById(rightItemImage).setAttribute("style", "opacity:0.8;");
			document.getElementById(rightItemImage).setAttribute('data-pointed','1');
			leftItemImage = "";
			rightItemImage = "";
		}
	});

		
	// draw line with SVG each tab - 1 svg
	function createSVG(currentTab) {
		  var svg = document.getElementById(currentTab +"svg-canvas");
		  if (null == svg) {
		  	var matching = tab_number[currentTab].firstElementChild
		    svg = document.createElementNS("http://www.w3.org/2000/svg", 
		                                   "svg");
		    svg.setAttribute('id', currentTab+'svg-canvas');
		    svg.setAttribute('style', 'position:absolute;top:0px;left:0px;z-index:-10');
		    svg.setAttribute('width', matching.offsetWidth);
		    svg.setAttribute('height', matching.offsetHeight);
		    svg.setAttributeNS("http://www.w3.org/2000/xmlns/", 
		                       "xmlns:xlink", 
		                       "http://www.w3.org/1999/xlink");
		    matching.appendChild(svg);
		  }
		  return svg;
		}

	function drawCircle(x, y, radius, color,currentTab) {
	    var svg = createSVG(currentTab);
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
	    while( el && !isNaN( el.offsetLeft ) && !isNaN( el.offsetTop ) )
	    {
	        _x += el.offsetLeft ;
	        _y += el.offsetTop ;
	        el = el.offsetParent;
	        if (el != null)
	        {
	            if (getComputedStyle !== 'undefined')
	                valString = getComputedStyle(el, null).getPropertyValue('position');
	            else
	                valString = el.currentStyle['position'];
	            if (valString === "relative")
	                el = null;
	        }
	    }
    	return {
		      "x": _x,
		      "y": _y
		  };
	}

	function connectDivs(leftId, rightId, color, tension, currentTab) {
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
		  console.log(rightPos)
		  drawCircle(x1, y1, 3, color, currentTab);
		  drawCircle(x2, y2, 3, color, currentTab);
		  drawCurvedLine(x1, y1, x2, y2, color, tension,currentTab);
		}

	function drawCurvedLine(x1, y1, x2, y2, color, tension,currentTab) {
	    var svg = createSVG(currentTab);
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
	// end Draw
	
