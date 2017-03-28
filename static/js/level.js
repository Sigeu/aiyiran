	$(function(){
			/*level*/
			$('.clos').live('click',function(){
				var self=$(this);
				var fa=$(this).parent('td').parent('tr');
				fa.siblings('tr').show();
				if(fa.parent('tbody').parent('table').hasClass('level1')){
					fa.css('background-color','#FFF7F2');
				}				
				//self.parents('.tabelTBL table tr').addClass('level1on').removeClass('level1off');
				self.addClass('open').removeClass('clos');
			})
			$('.open').live('click',function(){
				var self=$(this);
				var fa=$(this).parent('td').parent('tr');
				fa.siblings('tr').hide();
				if(fa.parent('tbody').parent('table').hasClass('level1')){
					fa.css('background-color','#fff');
				}
				//self.parents('.tabelTBL table tr').addClass('level1off').removeClass('level1on');
				self.addClass('clos').removeClass('open');
			})
			//$('.level tr:not("tr>td>table")').css('background-color','red');
			//$('.level tr').not("tr table").css('background-color','red');
			function recol(){
				var arr=$('.tal').parent('tr');
				for(var i=0;i<arr.length;i++){
					if(i%2==0){
						$(arr[i]).css('background-color','#f7f7f7');	
					}else{
						$(arr[i]).css('background-color','#fff');	
					}
				}
			}
			recol();
			
			
	})
	