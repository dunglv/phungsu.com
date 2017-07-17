(function($){
	'use strict'
	$.fn.ownConfirm = function(options){
		var config =  $.extend({
			title: 'Confirm action',
			content: 'Do you want to continute this action?',
			action: {
				ok: {
					label: 'Yes',
					color: '#4caf50'
				},
				cancel: {
					label: 'No',
					color: '#f44336'
				} 
			},
			ok_action: function(){},
			cancel_action:function(){}
		}, options);

		var body = document.getElementsByTagName('body')[0];
		var md = document.createElement('div');
		md.className = "own-modal";
		md.style = 'position:fixed;top:0;left:0;height:100%;width:100%;background: rgba(0,0,0,0.7);z-index:1000;';
		md.onclick = function(e){
			if(e.target === this){
				md.remove();
			}
		};

		var aw = document.createElement('div');
		aw.className = 'own-panel';
		aw.style = 'min-width:200px;max-width:70%;background:#fff;border-radius:5px;border:1px solid #ccc;position:absolute;top:45%;left:50%;transform:translate(-50%,-45%)';
		md.append(aw);

		var aa = document.createElement('div');
		aa.className = 'own-modal-head';
		aa.style = 'padding:7px 10px;text-align:left;background:#dedede;font-weight:700;';
		aa.innerHTML = config.title;
		aw.append(aa);

		var bb = document.createElement('div');
		bb.className = 'own-modal-content';
		bb.style = 'padding:7px 10px;text-align:left;min-height:70px'
		bb.innerHTML = config.content;
		aw.append(bb);

		var cc = document.createElement('div');
		cc.className = 'own-modal-action';
		cc.style = 'padding:7px 10px;text-align:left;display:table;width:100%;text-align:right;';
		aw.append(cc);

		var btnY = document.createElement('div');
		btnY.className = 'own-modal-yes';
		btnY.innerHTML = config.action.ok.label;
		btnY.style = 'padding:5px 10px;text-align:left;background:'+config.action.ok.color+';color:#fff;display:inline-block;margin-right:5px;user-select:none;';
		cc.append(btnY);
		btnY.onclick = function(){
			md.remove();
			config.ok_action();
		};
		btnY.onmouseenter = function(){this.style="padding:5px 10px;text-align:left;background:"+config.action.ok.color+";color:#fff;display:inline-block;user-select:none;margin-right:5px;cursor:pointer;opacity:0.8";}
		btnY.onmouseleave = function(){this.style="padding:5px 10px;text-align:left;background:"+config.action.ok.color+";color:#fff;display:inline-block;margin-right:5px;user-select:none;";}


		var btnN = document.createElement('div');
		btnN.className = 'own-modal-no';
		btnN.innerHTML = config.action.cancel.label;
		btnN.style = 'padding:5px 10px;text-align:left;background:'+config.action.cancel.color+';color:#fff;;display:inline-block;';
		cc.append(btnN);
		btnN.onclick = function(){
			config.cancel_action();
			md.remove();
			return false;
		};
		btnN.onmouseenter = function(){this.style="padding:5px 10px;text-align:left;background:"+config.action.cancel.color+";color:#fff;display:inline-block;user-select:none;cursor:pointer;opacity:0.8;"}
		btnN.onmouseleave = function(){this.style="padding:5px 10px;text-align:left;background:"+config.action.cancel.color+";color:#fff;display:inline-block;user-select:none;"}

		body.append(md);
	}

	$.fn.ownModal = function(options){
		var config = $.extend({
			title: 'Confirm action',
			content: 'Do you want to continute this action?',
			action: {
				ok: {
					label: 'Yes',
					color: '#4caf50'
				},
				cancel: {
					label: 'No',
					color: '#f44336'
				}
			},
			ok_action: function()
			}, options);
		});
	}
}(jQuery));