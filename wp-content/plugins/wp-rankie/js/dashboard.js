//INI
var oTable;
var wpRankieChecked = Array(); // contains index of checked pages

//Load the Visualization API and the piechart package.
google.load('visualization', '1.0', {'packages':['corechart']});




// Callback that creates and populates a data table, 
// instantiates the pie chart, passes in the data and
// draws it.
function drawChart() {

// Create the data table.
var data = google.visualization.arrayToDataTable([
	                                                  ['Rank', 'Ranking History'],
	                                                  ['29',   1],
	                                                  ['30',   2],
	                                                  ['31',   4],
	                                                  ['32',   60]
	                                             ]);

// Set chart options
var options = { title :'How Much Pizza I Ate Last Night',
                  width: 500, height: 400,
        vAxis: { direction:-1, viewWindowMode:"pretty"}};

// Instantiate and draw our chart, passing in some options.
var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
chart.draw(data, options);

}


// DIALOG POP
jQuery('.add-new-h2').click(function() {
	
	//ini dialog
	jQuery('#wp-rankie-group-select option:first-child').attr('selected','selected');
	
	jQuery('#wp-rankie-keywords-add').val('');
	
	var rankieDialog = jQuery('#keywordsDialog').dialog( {position: {
        my: "center", 
        at: "center",
        of:window
}}  );
	 
	 
	
	rankieDialog.dialog('open');
	
	jQuery('#wp-rankie-keywords-add').focus();
	
	jQuery('#wp-rankie-group-select').trigger('change');
	
});

// DIALOG NEW GROUP
jQuery('#wp-rankie-group-select').change(function(){
    if( jQuery('#wp-rankie-group-select').val() == 'wp-rankie-group-new' ){
        jQuery('#wp-rankie-group-new-text').show();
        jQuery('#wp-rankie-group-new-text').focus();
    }else{
        jQuery('#wp-rankie-group-new-text').hide();
    }
});

// DIALOG KEYWORD ADD
jQuery('#wp-rankie-keywords-add-btn').click(function() {
	var newKeywordsText = jQuery('#wp-rankie-keywords-add').val();
	var newKeywordsArr = newKeywordsText.split('\n');
	var wpRankieSite = jQuery('#wp-rankie-keywords-site').val();
	var wpRankieSelectedGroup = jQuery('#wp-rankie-group-select').val();
	
	//handling host url
	 link=wpRankieSite.replace('http://','');
	 link=link.replace(  /^www\./,'');
	 link='http://' + link;
	 var hostnamelink = jQuery('<a>').prop('href',  link).prop('hostname');
	 wpRankieSite = jQuery.trim( hostnamelink.replace(  /^www\./,'') );
	 
	 //add this url to the url list if not found
	 if(jQuery('#wp-rankie-select-site option[value="'+ wpRankieSite +'"]').length == 0 ){
		 jQuery('#wp-rankie-select-site').append('<option value="' + wpRankieSite + '">' + wpRankieSite +'</option> ' ) ;
	 }

	
	//handling group
	if(jQuery('#wp-rankie-group-select').val() == 'wp-rankie-group-new'){
	    wpRankieSelectedGroup = jQuery('#wp-rankie-group-new-text').val();
	    
	    //add this group to the list
	    jQuery('#wp-rankie-group-select').prepend('<option value="' + wpRankieSelectedGroup + '">' + wpRankieSelectedGroup +'</option> ' ) ;
	    jQuery('#wp-rankie-group').append('<option value="' + wpRankieSelectedGroup + '">' + wpRankieSelectedGroup +'</option> ' ) ;
	    
	}
	
	jQuery('.spinner-btn-add').show().addClass('is-active');
	
	//sending ajax with add request 
	jQuery.ajax({
        url: ajaxurl,
        type: 'POST',

        data: {
            action: 'wp_rankie_add_keywords',
            keywords: newKeywordsText,
            site: wpRankieSite,
            group: wpRankieSelectedGroup
            
        },
        
        success:function(data){
        	console.log(data);
        	
        	jQuery('.spinner-btn-add').hide();
        	
        	 var res = jQuery.parseJSON(data);
        	 jQuery(res).each(function(index,val){
        		 console.log(' keyword with id '+ val['id'] +' '+val['keyword']);
        		 oTable.dataTable().fnAddData( [   '<input type="checkbox" class="wp-rankie-keyword-id"  value="' + val['id'] +'" name="post[]" id="cb-select-' + val['id'] +'">' 
        		                                 , '<span class="wp-rankie-keyword-text">' +  val['keyword'] + '</span>' 
        		                                 ,  '-' 
        		                                 , '<span class="wp-rankie-keyword-site" >' + wpRankieSite + '</span>'
        		                                 , '<div class="spinner spinner-'+val['id']+'" style="display: none;"></div><a class="wp-rankie-update-row" href="#"><div class="updatedz updated-'+ val['id'] +' dashicons dashicons-clock"></div></a>'
        		                                 , '<a  class="wp-rankie-delete-row"  href="#"><div  class="dashicons dashicons-no-alt"></div></a>'
        		                                 , 'Manual'
        		                                 ,  wpRankieSelectedGroup 
        		                                 ,  '<input type="hidden" class="wp-rankie-updated" value="1" />' 
        		                                 ]  , false);
        		 
        		 //incrementing counts 
        		 totalCount = totalCount+1;
        		 manualCount = manualCount + 1 ;
        		 
        		 
        		 
        	 });
        	 
        	 //redraw
        	  oTable.fnDraw();
        	
        	jQuery('#keywordsDialog').dialog('close');
        	jQuery('#totalCount').text( '(' + totalCount + ')' );
        	jQuery('#manualCount').text( '(' + manualCount + ')' );
        	
        	//clickers
   		 	wpRankieUpdateClick();
        	
        }
    });
	
	jQuery(newKeywordsArr).each(function(index, val) {
		if (jQuery.trim(val) != '') {
			
			
			
		}

	});
	
	

	return false;

});

// DELETE KEYWORD FUNCTION
function wpRankieDeleteKeyword( keyIndex ){
	oTable.dataTable().fnDeleteRow(keyIndex,null , false);
}

//DELETE ROW BUTTON
jQuery(document).on('click', '.wp-rankie-delete-row' , function() {
	
	var deleteIndex=oTable.fnGetPosition( jQuery(this).parent().parent()[0] );
	
	console.log('deleteIndex:' + deleteIndex);
	
	jQuery(this).parent().parent().css('background-color','red');
	
	
	jQuery(this).parent().parent().fadeOut('slow',function(){
		
		wpRankieDeleteKeyword( deleteIndex );
		oTable.fnDraw();
		
	});
	
	  
	
	//ajax call to delete
	
	jQuery.ajax({
        url: ajaxurl,
        type: 'POST',

        data: {
            action: 'wp_rankie_delete_keywords',
            ids: jQuery(this).parent().parent().find('.wp-rankie-keyword-id').val()
            
            
        }
	});
	
	return false;
	
});

// BULK ACTIONS
jQuery('.action').unbind('click');
jQuery('.action').click( function(){
	
 
var selectedIds = '' ;
var deleteIndex =0;

selectedLength = jQuery('.wp-rankie-keyword-id:checked').length;
 jQuery('.wp-rankie-keyword-id:checked').each(function(){
    selectedIds = selectedIds + ',' + jQuery(this).val();
    
    deleteIndex=oTable.fnGetPosition( jQuery(this).parent().parent()[0] );
   
    console.log(deleteIndex);
    
    wpRankieDeleteKeyword(deleteIndex);
    
    jQuery('#cb-select-' + jQuery(this).val() ).parent().parent().remove();
     
    
 });
 
 	//ajax call to delete
    jQuery('.spinner-bulk').show().addClass('is-active');
	
    jQuery.ajax({
     url: ajaxurl,
     type: 'POST',

     data: {
         action: 'wp_rankie_delete_keywords',
         ids:  selectedIds
         
         
     },
     success: function(){
     	jQuery('.spinner-bulk').hide();
     	 alert( selectedLength + ' keys deleted' );
     }
	});
 
 oTable.fnDraw();
 

 jQuery('select[name="action"]').val('-1');
 
 console.log(selectedIds);
 
return false;

});

// FILTER TYPE : AUTO MANUAL ALL
jQuery('.subsubsub li a').click(function() {
	jQuery('.subsubsub li a').removeClass('current');
	jQuery(this).addClass('current');

	if (jQuery(this).parent().hasClass('all')) {
		oTable.fnFilter('', 6);
	} else if (jQuery(this).parent().hasClass('auto')) {
		oTable.fnFilter('auto', 6);
	} else if (jQuery(this).parent().hasClass('manual')) {
		oTable.fnFilter('manual', 6);
	}

	return false;
});

// FILTER BY SITE
jQuery('#wp-rankie-select-site').change(function() {
	if (jQuery(this).val() == 'all') {
		oTable.fnFilter('', 3);
	} else {
		oTable.fnFilter(jQuery(this).val(), 3);
	}
});

// FILTER BY GROUP
jQuery('#wp-rankie-group').change(function() {
	if (jQuery(this).val() == 'all') {
		oTable.fnFilter('', 7);
	} else {
		oTable.fnFilter( '^' + jQuery(this).val() + '$' , 7 ,true);
	}
});

// SEARCH KEYWORDS

// function filter by search
function wpRankieSearch() {
	oTable.fnFilter(jQuery('#post-search-input').val(), 1);
}

// text chagne
jQuery('#post-search-input').change(function() {
	wpRankieSearch();
});

// key up
jQuery('#post-search-input').keyup(function() {
	wpRankieSearch();
});

// button click
jQuery('#search-submit').click(function() {
	wpRankieSearch();
	return false;
});



//UPDATE RANK
function wpRankieLinkExists( link , links ){

    link=link.replace('http://','');
    link=link.replace(  /^www\./,'');
    
    link='http://' + link;

     var hostnamelink = jQuery('<a>').prop('href',  link).prop('hostname');
     link = jQuery.trim( hostnamelink.replace(  /^www\./,'') );
     
     console.log( link );

        var i  ;
      for ( i = 0 ; i < links.length ; i++){
         
         val=links[i];
      
        console.log(val['unescapedUrl']);
       
       var hostname = jQuery('<a>').prop('href',  val['unescapedUrl']).prop('hostname');
       hostname = jQuery.trim( hostname.replace(  /^www\./,'') );
        
        console.log(hostname);
      
       if(link == hostname ){
        console.log('found:' + val['unescapedUrl'] );
         return Array(i + 1 , val['unescapedUrl'] ) ;
       } 
     
     } 
     
     return false;
}


function wpRankieGoogle(itemId , itemText , itemSite , searchIndex,itemTd ,fnUpdateRank ){

   jQuery('.spinner-'+ itemId ).show().addClass('is-active');
   jQuery('.updated-'+ itemId ).hide();
  
  jQuery.ajax({
      url: '//ajax.googleapis.com/ajax/services/search/web?v=1.0&rsz=8&start='+searchIndex * 8 +'&q='+itemText + googleL ,
      type:"GET",
      dataType: 'jsonp',
     
      async:'true',
      success:function (data) {
      
      jQuery('.spinner-'+ itemId ).hide();
      jQuery('.updated-'+ itemId ).show();
       
       if( data['responseData']  ){
            //check the links if contains the data 
            if(data['responseData']['cursor']){
                //found results finally check if our link exists in them 
               var rankieExists=wpRankieLinkExists( itemSite , data['responseData']['results'] ) ;
               if( rankieExists  ){
            	   	
            	   	//update icon
            	    jQuery('.updated-'+ itemId ).removeClass('dashicons-clock').addClass('dashicons-yes');
            	   	
                    console.log(searchIndex * 8  +  rankieExists);
                    fnUpdateRank (itemTd, itemId ,  searchIndex * 8  +  rankieExists[0] , rankieExists[1]  )  ;
               }else{
                    console.log('not found in index:' + searchIndex);
                    
                    //may be another index ? 
                    console.log(data['responseData']['results'].length);
                    wpRankieChecked[itemId] = searchIndex + 1;
                    searchIndex=searchIndex + 1 ;
                    
                    if(searchIndex < data['responseData']['results'].length ){
                    	 wpRankieGoogle(itemId , itemText , itemSite , searchIndex , itemTd , fnUpdateRank )  ;
                    }else{
                    	jQuery('.updated-'+ itemId ).removeClass('dashicons-clock').addClass('dashicons-yes');
                        fnUpdateRank(itemTd,itemId , 0 , '-');
                    }
                    
                    
               }
                
            }else{ //hint not covered 
                console.log('No results forund for this keyword');
                return false;
            }
            
            
       }else{
        console.log('responseData not found in result');
        return false;
       }
       
       if(data.length != 0){
            //valid json returned check if result data contains
             console.log( data['cursor'] );
            
            
       } else {
           console.log('Not json');
       }
    
     },
      error: function (request, status, error) {
        alert(request.responseText);
    }
  }); 
    
}

//Whatsmyserp processor
function wpRankieGoogle2(itemId , itemText , itemSite , searchIndex , itemTd ,fnUpdateRank ){

	jQuery('.spinner-'+ itemId ).show().addClass('is-active');
	jQuery('.updated-'+ itemId ).hide();
	
	
	
	//ajax call to get rank 
	jQuery.ajax({
        
    	url: ajaxurl,
        type: 'POST',

        data: {
        	
            action: 'wp_rankie_fetch_rank',
            itm: itemId,
             
            
        },
        success: function(data){
        	
        	 jQuery('.spinner-'+ itemId ).hide();
             jQuery('.updated-'+ itemId ).show();
             jQuery('.updated-'+ itemId ).removeClass('dashicons-clock').addClass('dashicons-yes');
             
             var res = jQuery.parseJSON(data);
             
             
             
             if(res['status'] == 'success'){
            	 
            	 fnUpdateRank( itemTd , res['id'] , res['rank'] , res['link'] );
             }
             
             jQuery('.wp_rankie_last_log').html(res['lastLog']);
             
        	
        }
    });

}

//update UI Rank
function updateUIRank(itemTd , rankId,rankNum , rankUrl){
	 
    console.log('Final rank for id = '+ rankId + ' is ' + rankNum ); 
    
    itmPosition = oTable.fnGetPosition( itemTd ) ;
    
    itmRowIndex = itmPosition[0];
    itmCoulmnIndex = itmPosition[1];
    
    
    oTable.fnUpdate (    rankNum     ,  itmRowIndex  , 2 , false);
    oTable.fnUpdate ( '<input type="hidden" class="wp-rankie-updated" value="0" />'   , itmRowIndex , 8 , false );
    
    if(googleMethod == 'ajax'){
	    jQuery.ajax({
	           url: ajaxurl,
	           type: 'POST',
	
	           data: {
	               action: 'wp_rankie_update_rank',
	               rank: rankNum,
	               itm: rankId,
	               url: rankUrl
	               
	           }	        
	    });
	}

}

//update click
function  wpRankieUpdateClick(){
	
	var nNodes = oTable.fnGetNodes( );

	
	jQuery(nNodes).find('.wp-rankie-update-row').unbind('click');
	jQuery(nNodes).find('.wp-rankie-update-row').click( function() {
	
	  var itemId = (jQuery(this).parent().parent().find('.wp-rankie-keyword-id').val());
	  var itemSite = (jQuery(this).parent().parent().find('.wp-rankie-keyword-site').text());
	  var itemText = (jQuery(this).parent().parent().find('.wp-rankie-keyword-text').text());
	  var itemTd = jQuery(this).parent()[0];
	 
	  console.log( 'id:'+itemId);
	  console.log( 'itemSite:'+itemSite);
	  console.log( 'itemText:'+itemText);
	  
	  
	   //loop on google from last index
	  	var searchIndex=0;
	  
	  	if (! wpRankieChecked[itemId] ){
		    wpRankieChecked[itemId] = 0;
		}else{
			searchIndex=wpRankieChecked[itemId];
		}
	   
	  	console.log('searchIndex:' + searchIndex);
	    
	  	 if( googleMethod == 'ajax'){
	  		 
	  		 if(  searchIndex < 8){
	  			 wpRankieGoogle(itemId,itemText,itemSite,searchIndex,itemTd, updateUIRank);
	  		 }else{
	  			 console.log('reached end of search');
	  		 }
		     
	     
	  	 }else  {
	  		 
	  		 console.log('Method:server side');
	  		 wpRankieGoogle2(itemId,itemText,itemSite,searchIndex,itemTd, updateUIRank );
	  		 
	  	 }
	  	 
	  	 return false;
	 
	});

}

//function fetched rank updater 


//update all waiting function
function wpRankieUpateAll(){

	spinCount = jQuery(oTable.fnGetNodes( )).find('.spinner:visible').length;

	if( spinCount < 1 ) {
	    
		jQuery('.wp-rankie-updated[value = "1"]:first').parent().parent().find('td .spinner:hidden').parent().find('.wp-rankie-update-row').trigger('click');
		
		/*
		validItems = jQuery(oTable.fnGetNodes( )).find('.wp-rankie-updated[value = "1"]').parent().parent().find('td .spinner:hidden').parent().find('.wp-rankie-update-row');

	    var i=0;
	     
	    for(i=0;i<1;i++){
	        jQuery(validItems[i]).trigger('click');
	    }
	    
	    */

	}
	
	t = setTimeout("wpRankieUpateAll()", 30000);

}


//tabs clicker
jQuery('.category-tabs li').click(function(){
    jQuery('.category-tabs li').removeClass('tabs');
    jQuery(this).addClass('tabs');
    
    jQuery('.categorydiv .tabs-panel').hide();
    jQuery('.categorydiv .tabs-panel').eq(jQuery(this).index()).show();
    
    return false;
    
});

 

// DOC READY
jQuery(document).ready(function() {
	
	//SELECT 
	 jQuery('#cb-select-all-1').click(function(){
		    
	     if (jQuery(this).attr('checked') == 'checked') {
	                 jQuery('.wp-rankie-keyword-id').removeAttr('checked');
	             jQuery('.wp-rankie-keyword-id:visible').attr('checked', 'true');   

	      }else{

	        jQuery('.wp-rankie-keyword-id:visible').removeAttr('checked');
	      }
	 
	});
	

	// DIALOG INI
	jQuery('#keywordsDialog').dialog({
		autoOpen : false,
		dialogClass : 'wp-dialog',
		position : 'center',
		draggable : false,
		width : 400,
		title : 'Add New Keywords'
	});


	
	// DATA TABLE INI
	oTable = jQuery('#rankie-keywords').dataTable({
		"sScrollY": sScroll,
		"bPaginate": false,
		"oLanguage" : {
			"oPaginate" : {
				"sNext" : "›",
				"sPrevious" : "‹"
			}
		},

		"bFilter" : true,
		"iDisplayLength" : 7 ,
		"aoColumnDefs": [
          { "sType": "numeric", "aTargets": [ 2 ] }
        ]

	});

	wpRankieUpdateClick();
	
	wpRankieUpateAll();
	
	//GET CHART
	
	jQuery('#rankie-keywords_wrapper').on('click','.wp-rankie-keyword-text', function(){
	
	//jQuery('.wp-rankie-keyword-text').click(function(){
	    
	    var itemId =jQuery(this).parent().parent().find('.wp-rankie-keyword-id').val() ;
	    var itemSite = jQuery(this).parent().parent().find('.wp-rankie-keyword-site').text() ;
	    var itemKeyword = jQuery(this).text();
	    
	    jQuery('.wp-rakie-chart-site').text( itemSite );
	    jQuery('.wp-rakie-chart-keyword').text( itemKeyword );
	    
	    jQuery('#chart_div').html('<div style="display:block" class="spinner is-active"></div>');
	    
	    jQuery.ajax({
			            url: ajaxurl,
			            type: 'POST',
		
			            data: {
			                action: 'wp_rankie_get_rank',
			                itm: itemId
			                
			            },
			            success: function(data){
			                
			                  var res = jQuery.parseJSON(data);
			                  
			                  // Create the data table.
			                  var data = google.visualization.arrayToDataTable(res[0]);

			                  // Set chart options
			                  jQuery('#category-tabs li:first-child').trigger('click');
			                  var options = {	
			                		  			title: "- Ranking Records of (" + itemSite + ") for (" + itemKeyword + ")" ,
			                                    width: jQuery('#chart_div').width() - 10 , height: 190,
			                          vAxis: { title:"Rank" ,direction:-1, viewWindowMode:"pretty"},
			                          titleTextStyle : {bold:false},
			                          hAxis:{title : "Change date"}
			                  
			                  };

			                  // Instantiate and draw our chart, passing in some options.
			                  var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
			                  chart.draw(data, options);

			                  jQuery('#wp-rakie-chart tbody tr').remove();
			                  
			                  jQuery(res[1]).each(function(index,val){
			                	  if (val[0] != 'Rank'){
			                		  jQuery('#wp-rakie-chart tbody ').append( '<tr><td>' + val[0] + '</td> <td>' + val[1] + '</td> <td><a href="' + val[2] + '">' + val[2] + '</a></td> </tr>' ) ;
			                	  }
			                  });
			                  
			            }
			        });
	    
	});
});