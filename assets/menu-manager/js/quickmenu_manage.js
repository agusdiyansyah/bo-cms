$(document).ready(function(){	
 $(function() {
  $('.dd').nestable({ 
    dropCallback: function(details) {
       
       var order = new Array();
       $("li[data-id='"+details.destId +"']").find('ol:first').children().each(function(index,elem) {
         order[index] = $(elem).attr('data-id');
       });

       if (order.length === 0){
        var rootOrder = new Array();
        $("#nestable > ol > li").each(function(index,elem) {
          rootOrder[index] = $(elem).attr('data-id');
        });
       }

       $.post(BASEURL+'managemenu/reorder', 
        { source : details.sourceId, 
          destination: details.destId, 
          order:JSON.stringify(order),
          rootOrder:JSON.stringify(rootOrder), 
          _token:TOKEN
        }, 
        function(data) {
          console.log(data); 
        })
       .done(function() { 
          $( "#success-indicator" ).fadeIn(100).delay(1000).fadeOut();
       })
       .fail(function() {  })
       .always(function() {  });
     }
   });

  
  
   $('.top_menu_edit_toggle').each(function(index,elem) {
      $(elem).click(function(e){
        e.preventDefault();
       $('#editTopMenuModal').modal('toggle');
      });
  });
  
});
	     
      $('#add_top_menu').on('submit',function(){		
          $('#newTopMenuModal').modal('toggle');         
          var postData = $(this).serializeArray();
            $.ajax(
            {
                url : BASEURL+'managemenu/add_to_menu',
                type: "POST",
                data : postData,
                async: false,
                success:function(data, textStatus, jqXHR) 
                {
                    
                    if($.trim(data) != 'error')
                    {
                        if($('#tab_holder').length )    
                        {
                        var str = '<li><a class="glyphicons " href="'+BASEURL+'managemenu/menu/'+$.trim(data)+'" ><i></i><span>'+$('#top_menu_title').val()+'<span class="id_menu">('+$.trim(data)+')</span></span></a></li>';
                        $(str).appendTo('#top_menu_tab');
                        }
                            else{
                                location.reload();
                            }
                        }
                },
                error: function(jqXHR, textStatus, errorThrown) 
                {
                    //if fails      
                }
            });
            
          $('#top_menu_title').val('');
          
          return false;
      });
      
      $('#add_menu_item').on('submit',function(){
          $('#newModal').modal('toggle');
         
          var postData = $(this).serializeArray();
            $.ajax(
            {
                url : BASEURL+'managemenu/add',
                type: "POST",
                data : postData,
                success:function(data, textStatus, jqXHR) 
                {
                    if($.trim(data) != 'error')
                    {
                        
                    var str = $.trim(data);
                    
                    if($('#top_ol').length )    
                    {
                      $(str).appendTo('#top_ol');
                        }
                        else
                        {
                           $("<ol id='top_ol' class='dd-list'>"+str+'</ol>').appendTo('#nestable'); 
                        }
                    
                    
                        }
                    
                },
                error: function(jqXHR, textStatus, errorThrown) 
                {
                    //if fails      
                }
            });
           
          $('#title').val('');
          $('#label').val('');
          $('#url').val('');
		  $('#new_tab').attr('checked', false);	
          $("#css").val('');
          $("#description").val('');          
          return false;
      });
      
       $('#delete_menu_item').on('submit',function(){
          $('#deleteModal').modal('toggle');
         
          var postData = $(this).serializeArray();
            $.ajax(
            {
                url : BASEURL+'managemenu/delete',
                type: "POST",
                data : postData,
                success:function(data, textStatus, jqXHR) 
                {
                 if($.trim(data) == 'ok')
                    {
                        $('#'+$('#postvalue').val()).remove();
                    }    
                    
                },
                error: function(jqXHR, textStatus, errorThrown) 
                {
                    //if fails      
                }
            });
          return false;
      });
      
      
      $('#edit_menu_item').on('submit',function(){
          $('#editModal').modal('toggle');
         
          var postData = $(this).serializeArray();
            $.ajax(
            {
                url : BASEURL+'managemenu/edit',
                type: "POST",
                data : postData,
                success:function(data, textStatus, jqXHR) 
                {
                    if($.trim(data) == 'ok')
                    {
                 var $id = $('#editvalue').val();
                 $('#menu_title_'+$id).html($('#edit_label').val())
                 $('#title_'+$id).val($('#edit_title').val());
                 $('#label_'+$id).val($('#edit_label').val());
                 $('#url_'+$id).val($('#edit_url').val());
                  if($('#edit_new_tab').is(":checked"))
				 {		
				 $('#new_tab_'+$id).val('1');	 
				 }
				 else
				 {
					 $('#new_tab_'+$id).val('0');
				 } 				            
                 $('#css_'+$id).val($('#edit_css').val());
                 $('#description_'+$id).val($('#edit_description').val());
                        }
                },
                error: function(jqXHR, textStatus, errorThrown) 
                {
                    //if fails      
                }
            });
            
          
          
          return false;
      });
      
      $('#edit_top_menu').on('submit',function(){
          $('#editTopMenuModal').modal('toggle');
         
          var postData = $(this).serializeArray();
            $.ajax(
            {
                url : BASEURL+'managemenu/edit_top_menu',
                type: "POST",
                data : postData,
                success:function(data, textStatus, jqXHR) 
                {
                    if($.trim(data) == 'ok')
                    {
                        var $id = $('#top_menu_id').val();
                        $('#top_menu_title_'+$id).html($('#edit_top_menu_title').val()+"<span class='id_menu'>("+$id+")</span>")   
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) 
                {
                    //if fails      
                }
            });          
          return false;
      });  
      
  $('.well').on('click','.edit_toggle',function(e){
       var suffix = $(this).attr('rel');
     
        $('#editvalue').attr('value',$(this).attr('rel'));
         $('#edit_title').attr('value',$("#title_"+suffix).val());
         $('#edit_url').attr('value',$("#url_"+suffix).val());
         $('#edit_label').attr('value',$("#label_"+suffix).val());
         if($("#new_tab_"+suffix).val()=="1")
         {		
		 $('#edit_new_tab').attr('checked', true);	 
		 } 
		 else{
			 $('#edit_new_tab').attr('checked', false);	 
			 }       
         $('#edit_css').attr('value',$("#css_"+suffix).val());
         $('#edit_description').attr('value',$("#description_"+suffix).val());
        $('#editModal').modal('toggle');
      });
        
   });
   
   
   $('.well').on('click','.delete_toggle',function(e){
        e.preventDefault();
        $('#postvalue').attr('value',$(this).attr('rel'));
        $('#deleteModal').modal('toggle');
      });
 $(document).ready(function() {

	if (jQuery(window).width() > 767) {
		jQuery('.header-nav > li').hover(function() {
			jQuery(this).children('.sub-menu').show().animate({
				top : '78px'
			}, 350)
		}, function() {
			jQuery(this).children('.sub-menu').hide().animate({
				top : '60px'
			})
		})
		jQuery('.header-nav .sub-menu li').hover(function() {
			jQuery(this).children('.sub-menu').animate({
				top : '0px'
			}, 350)
		}, function() {
			jQuery(this).children('.sub-menu').animate({
				top : '-25px'
			})
		})
	}

	$(".toggle-row").click(function() {
		$(".toggle-row").toggleClass("active");
		$(".header-navigation").slideToggle();
		$('.header-navigation .sub-menu ').css("display", "none");
		$(".menu-arrow").removeClass("active");
	});

	$(".header-navigation .menu-arrow").click(function() {
		$('.active2').slideUp().removeClass('active2');
		$('.active3').slideUp().removeClass('active3');

		if ($(this).next().css('display') == 'none')
			$(this).next().addClass('active3').slideDown();
	})
	$(".header-navigation .nextmenu-arrow").click(function() {
		$('.active2').slideUp().removeClass('active2');
		if ($(this).next().css('display') == 'none')
			$(this).next().addClass('active2').slideDown();
	})
});
function get_edit_data(id)
   {
		 $.ajax({
		 url : BASEURL+'managemenu/get_edit_top_menu_data',
		type: "POST",
		data_type: 'json',
		data: { edit_id: id,_token:TOKEN},
		success: function (data)
		{
			var values = data.split('###');
			$('#edit_top_menu_title').val(values[0]);
			$(".edit_effect[value='effect-2']").prop('selected', true);
			if(values[1]!="")
			{
				$('.edit_effect').val(values[1]).prop('selected', true);
			}
			if(values[2]!="")
			{
				$('.edit_color').val(values[2]).prop('selected', true);
			}
		},
		});
	}
