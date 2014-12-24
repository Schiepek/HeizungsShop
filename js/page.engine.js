
	$(function() 
	{
		$("input[type^='text']").each(function(index)
		{
			var defVal 	= $(this).attr('default');
			
			if(defVal!="" && typeof defVal!='undefined')
			{
				$(this).val(defVal);
				$(this).focus(function() 
				{
					if($(this).val()==defVal)
					{
						$(this).val('');
					}
				});
				$(this).blur(function() 
				{
					if($(this).val()=='')
					{
						$(this).val(defVal);
					}
				});
			}
		});
		
		$(".lightbox").prettyPhoto({gallery_markup:'  ', social_tools: '  '});
		$("a[rel^='lightbox']").prettyPhoto({gallery_markup:'  ', social_tools: '  '});
		
		$("#slidesshow_startseite").slides(
		{
			play: 5000,
			pause: 2500,
			hoverPause: true
		});
		$("#slidesshow_startseite").hover(
			function () 
			{
				$('#slidesshow_startseite .next').fadeIn();
				$('#slidesshow_startseite .prev').fadeIn();
			},
			function () 
			{
				$('#slidesshow_startseite .next').fadeOut();
				$('#slidesshow_startseite .prev').fadeOut();
			}
		);
		
		$("#slides").slides(
		{
			play: 5000,
			pause: 2500,
			hoverPause: true,
			animationStart: function(current,direction) 
			{
            	setTitel(current,direction);
            	for(x in this)
            	{
            		//alert(x+'||'+this[x]);
            	}
        	}
		});
		setTitel(0,'next');
		function setTitel(num,direction)
		{
			if(direction=="prev")
			{
				pos = num-2;
				pos	= (pos<0) ? $(".slides_control > div").length-1 : pos;
				pos	= (pos>$(".slides_control > div").length-1) ? 0 : pos;
			}
			else
			{
				pos = num;
				pos	= (pos>$(".slides_control > div").length-1) ? 0 : pos;
			}
			
			$(".slides_control > div").each(function(index)
			{
				if(index==pos)
				{
					var h2 		= ($('h2',this).length<=0) ? $('h3',this).text() : $('h2',this).text();
					var link	= $('a.img',this).attr('href');
					$('.angebot_button').text(h2);//+'|'+index+'|'+pos+'|'+direction
					$('.angebot_button').attr('href',link);
				}
			});
		}
		
		$('.tabcontent').hide();
		$("ul.tab li").each(function(index)
		{
			if($(this).hasClass('aktiv'))
			{
				var id = $(this).attr('value');
				$("#tabcontent_"+id).show();
			}
		});
		$("ul.tab li").click(function() 
		{
			var id = $(this).attr('value');
			if(id>0)
			{
				$('.tabcontent').hide();
				$('ul.tab li').removeClass('aktiv');
				$("#tabcontent_"+id).show();
				$(this).addClass('aktiv');
			}
		});
		
		if($("#artikelproseite_labels span").length>0)
		{
			var num = $("#artikelproseite").val();
			
			$('#artikelproseite_labels span').each(function(index)
			{
				var value	= $(this).text();
				if(value==num)
				{
					$(this).addClass('aktiv');
				}
			});
		}
		$("#artikelproseite_labels span").click
		(
			function()
			{	
				$("#artikelproseite").val($(this).text());
				$('#artikeluebersicht').submit();
			}		
		);
		
		if($("#produkte_optionen_content").length>0)
		{
			$('#produktidchange').change(function() 
			{
				var val 	= $(this).val();
				var urlarr 	= document.URL.split('/');
				var url 	= urlarr[0]+'//'+urlarr[2]+'/cmssystem/warenkorb/ajax.php?produktoptionen=1&produktid='+val;
				//$('body').prepend($('<div>').text(url));	
			
				var jqxhr 	= $.ajax(
				{
					url:		url,
					success: 	function( data )
					{
						$("#produkte_optionen_content").html(data);
					},
					error: 	function(data) 
					{
	 					$("#produkte_optionen_content").html('');	
					}
				});
			
			});
		
		
		}
		
		
		
		
		
		
		
		
		
		
		$('#lieferung_adresse_auswahl').change(function() 
		{
			var val 	= $(this).val();
			var urlarr 	= document.URL.split('/');
			var url 	= urlarr[0]+'//'+urlarr[2]+'/cmssystem/warenkorb/ajax.php?lieferung_adresse_auswahl='+val;
			//$('body').prepend($('<div>').text(url));
		
			var jqxhr 	= $.ajax(
			{
				url:		url,
				success: 	function( data )
				{
					for(x in data)
					{
						data[x] = data[x].replace(/\&([^;]+);/g, function(entity, entityCode)
						{
							var match;
							
							if (match = entityCode.match(/^#x([\da-fA-F]+)$/)) 
							{
								return String.fromCharCode(parseInt(match[1], 16));
							} 
							else if (match = entityCode.match(/^#(\d+)$/)) 
							{
								return String.fromCharCode(~~match[1]);
							} 
							else 
							{
								return entity;
							}
						});
						switch(x)
						{
							case 'anrede'	: $("select[name^='lieferung_anrede").val(data[x]); break;
							case 'firma'	: $("input[name^='lieferung_firma']").val(data[x]); break;
							case 'vorname'	: $("input[name^='lieferung_vorname']").val(data[x]); break;
							case 'nachname'	: $("input[name^='lieferung_name']").val(data[x]); break;
							case 'zusatz'	: $("input[name^='lieferung_zusatz']").val(data[x]); break;
							case 'strasse'	: $("input[name^='lieferung_strasse']").val(data[x]); break;
							case 'plz'		: $("input[name^='lieferung_plz']").val(data[x]); break;
							case 'ort'		: $("input[name^='lieferung_ort']").val(data[x]); break;
							case 'land'		: $("select[name^='lieferung_land']").val(data[x]); break;
						}
					}
				},
				error: 	function(data) 
				{
 					
				}
			});
		});
	});
	
	function toggleMenu(el, over)
	{
	    if (over) {
	    $(el).addClass('over');
	        //Element.addClassName(el, 'over');
	    }
	    else {
	     $(el).removeClass('over');
	       // Element.removeClassName(el, 'over');
	    }
	}