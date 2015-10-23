var noconflictjq=jQuery.noConflict();
if(typeof Virtuemart === "undefined")
	{
		var Virtuemart = {
			setproducttype : function (form, id) {
				form.view = null;
				datas = form.serialize();
				var prices = form.parent(".productdetails").find(".product-price");
				if (0 == prices.length) {
					prices = noconflictjq("#productPrice" + id);
				}
				datas = datas.replace("&view=cart", "");
				prices.fadeTo("fast", 0.75);
				noconflictjq.getJSON(window.vmSiteurl + 'index.php?option=com_virtuemart&nosef=1&view=productdetails&task=recalculate&virtuemart_product_id='+id+'&format=json' + window.vmLang, encodeURIComponent(datas),
					function (datas, textStatus) {
						prices.fadeTo("fast", 1);
						// refresh price
						for (var key in datas) {
							var value = datas[key];
							if (value!=0) prices.find("span.Price"+key).show().html(value);
							else prices.find(".Price"+key).html(0).hide();
						}
					});
				return false; // prevent reload
			},
			productUpdate : function(mod) {

				noconflictjq.ajaxSetup({ cache: false })
				noconflictjq.getJSON(window.vmSiteurl+"index.php?option=com_virtuemart&nosef=1&view=cart&task=viewJS&format=json"+window.vmLang,
					function(datas, textStatus) {
						if (datas.totalProduct >0) {
							mod.find(".vm_cart_products").html("");
							noconflictjq.each(datas.products, function(key, val) {
								noconflictjq("#hiddencontainer .container").clone().appendTo(".vmCartModule .vm_cart_products");
								noconflictjq.each(val, function(key, val) {
									if (noconflictjq("#hiddencontainer .container ."+key)) mod.find(".vm_cart_products ."+key+":last").html(val) ;
								});
							});
							mod.find(".total").html(datas.billTotal);
							mod.find(".show_cart").html(datas.cart_show);
						}
						mod.find(".total_products").html(datas.totalProductTxt);
					}
				);
			},
			sendtocart : function (form){

				if (Virtuemart.addtocart_popup ==1) {
					Virtuemart.cartEffect(form) ;
				} else {
					form.append('<input type="hidden" name="task" value="add" />');
					form.submit();
				}
			},
			cartEffect : function(form) {

                noconflictjq.ajaxSetup({ cache: false });
                var datas = form.serialize();

                if(usefancy){
                    noconflictjq.fancybox.showActivity();
                }

                noconflictjq.getJSON(vmSiteurl+'index.php?option=com_virtuemart&nosef=1&view=cart&task=addJS&format=json'+vmLang,encodeURIComponent(datas),
                function(datas, textStatus) {
                    if(datas.stat ==1){

                        var txt = datas.msg;
                    } else if(datas.stat ==2){
                        var txt = datas.msg +"<H4>"+form.find(".pname").val()+"</H4>";
                    } else {
                        var txt = "<H4>"+vmCartError+"</H4>"+datas.msg;
                    }
                    if(usefancy){
                        noconflictjq.fancybox({
                                "titlePosition" : 	"inside",
                                "transitionIn"	:	"elastic",
                                "transitionOut"	:	"elastic",
                                "type"			:	"html",
                                "autoCenter"    :   true,
                                "closeBtn"      :   false,
                                "closeClick"    :   false,
                                "content"       :   txt
                            }
                        );
                    } else {
                        noconflictjq.facebox.settings.closeImage = closeImage;
                        noconflictjq.facebox.settings.loadingImage = loadingImage;
                        //noconflictjq.facebox.settings.faceboxHtml = faceboxHtml;
                        noconflictjq.facebox({ text: txt }, 'my-groovy-style');
                    }

                    if (noconflictjq(".vmCartModule")[0]) {
                        Virtuemart.productUpdate(noconflictjq(".vmCartModule"));
                    }
                });

                noconflictjq.ajaxSetup({ cache: true });
			},
			product : function(carts) {
				carts.each(function(){
					var cart = jQuery(this),
					step=cart.find('input[name="quantity"]'),
					addtocart = cart.find('input.addtocart-button'),
					plus   = cart.find('.quantity-plus'),
					minus  = cart.find('.quantity-minus'),
					select = cart.find('select:not(.no-vm-bind)'),
					radio = cart.find('input:radio:not(.no-vm-bind)'),
					virtuemart_product_id = cart.find('input[name="virtuemart_product_id[]"]').val(),
					quantity = cart.find('.quantity-input');

                    var Ste = parseInt(step.val());
                    //Fallback for layouts lower than 2.0.18b
                    if(isNaN(Ste)){
                        Ste = 1;
                    }
					addtocart.click(function(e) { 
						Virtuemart.sendtocart(cart);
						return false;
					});
					plus.click(function() {
						var Qtt = parseInt(quantity.val());
						if (!isNaN(Qtt)) {
							quantity.val(Qtt + Ste);
						Virtuemart.setproducttype(cart,virtuemart_product_id);
						}
						
					});
					minus.click(function() {
						var Qtt = parseInt(quantity.val());
						if (!isNaN(Qtt) && Qtt>Ste) {
							quantity.val(Qtt - Ste);
						} else quantity.val(Ste);
						Virtuemart.setproducttype(cart,virtuemart_product_id);
					});
					select.change(function() {
						Virtuemart.setproducttype(cart,virtuemart_product_id);
					});
					radio.change(function() {
						Virtuemart.setproducttype(cart,virtuemart_product_id);
					});
					quantity.keyup(function() {
						Virtuemart.setproducttype(cart,virtuemart_product_id);
					});
				});

			}
		};
		jQuery.noConflict();
		jQuery(document).ready(function(noconflictjq) {

			Virtuemart.product(noconflictjq("form.product"));

			noconflictjq("form.js-recalculate").each(function(){
				if (noconflictjq(this).find(".product-fields").length && !noconflictjq(this).find(".no-vm-bind").length) {
					var id= noconflictjq(this).find('input[name="virtuemart_product_id[]"]').val();
					Virtuemart.setproducttype(noconflictjq(this),id);

				}
			});
		});
	}
