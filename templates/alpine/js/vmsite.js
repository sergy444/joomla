/**
 * list country.js: General Javascript Library for VirtueMart Administration
 *
 *
 * @package	VirtueMart
 * @subpackage Javascript Library
 * @author Patrick Kohl
 * @copyright Copyright (c) 2011VirtueMart Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */
 var vmnoconf = jQuery.noConflict();

(function(vmnoconf){
	var undefined,
	methods = {
		list: function(options) {
			var dest = options.dest;
			var ids = options.ids;
			var prefix = options.prefiks;
            methods.update(this,dest,ids,prefix);
			vmnoconf(this).change( function() { methods.update(this,dest,ids,prefix)});

		},
		update: function(org,dest,ids,prefix) {
			var opt = vmnoconf(org),
				optValues = opt.val() || [],
				byAjax = [] ;
			if (!vmnoconf.isArray(optValues)) optValues = jQuery.makeArray(optValues);
			if ( typeof  oldValues !== "undefined") {
				//remove if not in optValues
				vmnoconf.each(oldValues, function(key, oldValue) {
					if ( (vmnoconf.inArray( oldValue, optValues )) < 0 ) vmnoconf("#"+prefix+"group"+oldValue).remove();
				});
			}
			//push in 'byAjax' values and do it in ajax
			vmnoconf.each(optValues, function(optkey, optValue) {
				if( opt.data( 'd'+optValue) === undefined ) byAjax.push( optValue );
			});

			if (byAjax.length >0) {
				vmnoconf.getJSON('index.php?option=com_virtuemart&view=state&format=json&virtuemart_country_id=' + byAjax,
						function(result){
						
						// Max Bitte Testen
						var virtuemart_state_id = vmnoconf('#'+prefix+'virtuemart_state_id');
						var status = virtuemart_state_id.attr('required');
						
						if(status == 'required') {
							if( result[byAjax].length > 0 ) {
								virtuemart_state_id.attr('required','required');
							} else {
								virtuemart_state_id.removeAttr('required');
							}
						}
						
						// ENDE

						vmnoconf.each(result, function(key, value) {
							if (value.length >0) {
								opt.data( 'd'+key, value );	
							} else { 
								opt.data( 'd'+key, 0 );		
							}
						});
						methods.addToList(opt,optValues,dest,prefix);
						if ( typeof  ids !== "undefined") {
							var states =  ids.length ? ids.split(',') : [] ;
							vmnoconf.each(states, function(k,id) {
								vmnoconf(dest).find('[value='+id+']').attr("selected","selected");
							});
						}
						vmnoconf(dest).trigger("liszt:updated");
					}
				);
			} else {
				methods.addToList(opt,optValues,dest,prefix)
				vmnoconf(dest).trigger("liszt:updated");
			}
			oldValues = optValues ;
			
		},
		addToList: function(opt,values,dest,prefix) {
			vmnoconf.each(values, function(dataKey, dataValue) { 
				var groupExist = vmnoconf("#"+prefix+"group"+dataValue+"").size();
				if ( ! groupExist ) {
					var datas = opt.data( 'd'+dataValue );
					if (datas.length >0) {
					var label = opt.find("option[value='"+dataValue+"']").text();
					var group ='<optgroup id="'+prefix+'group'+dataValue+'" label="'+label+'">';
					vmnoconf.each( datas  , function( key, value) {
						if (value) group +='<option value="'+ value.virtuemart_state_id +'">'+ value.state_name +'</option>';
					});
					group += '</optgroup>';
					vmnoconf(dest).append(group);
					
					}
				}
			});
		}
	};
   
	
	vmnoconf.fn.vm2front = function( method ) {

		if ( methods[method] ) {
		  return methods[method].apply( this, Array.prototype.slice.call( arguments, 1 ));
		} else if ( typeof method === 'object' || ! method ) {
			return methods.init.apply( this, arguments );
		} else {
		  vmnoconf.error( 'Method ' +  method + ' does not exist on Vm2 front jQuery library' );
		}    
	
	};
})(vmnoconf)
