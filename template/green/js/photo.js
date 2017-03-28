/*photo*/
	var t;
	var t1;
	var id;
	var next;
	var prve;
	var id1;
	var id2;
	var j = 0;
	id = document.getElementById("photoUl").getElementsByTagName("li");
	//id1 = document.getElementById("photoUl");
	id1 = $("#photoUl");
	id2 = $("#photoUl");
	id1.append(id1.children().clone());
	id1.width(id1.width()+id1.width());

	next = document.getElementById("next");
	prve = document.getElementById("prve");
	prve.onclick = function () {
    clearTimeout(t);
    clearInterval(t1);
    if (j == 0) {
        j = id.length /2;
		id1.css("display","none");
		id1.css("left",-id1.width()/2+"px");
		id1.css("display","block");
    }
	j--;	
	t = setTimeout("auto()", 5000);
	t1 = setInterval("del()", 5);
}
   next.onclick = function () {
		clearTimeout(t);
		clearInterval(t1);
		zjj();
	}
	function add() {		
		var l = parseInt(id1.css("left").replace("px",""));
		id1.css("left", Math.floor((l + (-j * 198 - l) * 0.5)) + "px");
		//aler(id1.style.left);
	}
	function del() {
		var l = parseInt(id1.css("left").replace("px",""));
		id1.css("left", Math.ceil((l + (-j * 198 - l) * 0.5)) + "px");
		//alert(id1.style.left);
	}
	function zjj() {
		if (j < id.length - 1) {
			if (id.length/2==j)
			{
				j=0;
				id1.css("display","none");
				id1.css("left","0px");
				id1.css("display","block");
			}
			j++;
			t = setTimeout("auto()", 5000);
			t1 = setInterval("add()", 5);
		} else {
			j = 0;
			t = setTimeout("auto()", 5000);
			t1 = setInterval("del()", 5);
		}
	}
	function auto() {
		clearTimeout(t);
		clearInterval(t1);

		if (j == (id.length - 1)) {
			j = 0;
			t = setTimeout("auto()", 5000);
			t1 = setInterval("del()", 5);

		} else {
			if (id.length/2==j)
			{
				j=0;
				id1.css("display","none");
				id1.css("left","0px");
				id1.css("display","block");
			}
			j++;
			t = setTimeout("auto()", 5000);
			t1 = setInterval("add()", 5);
		}
	}
    t = setTimeout("auto()", 5000);