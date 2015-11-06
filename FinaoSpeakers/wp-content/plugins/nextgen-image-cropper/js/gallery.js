jQuery(document).ready(function($) {
	// Insert the crop link into NextGen image actions
	$('form#updategallery #ngg-listimages tbody tr').each(function(index) {
		var rowID = $(this).attr('id'),
			pictureID = '';
		
		if(rowID) {
			pictureID = rowID.replace('picture-','');
		
			// Crop Action link
			actionrow = $(this).find('.row-actions');
			$('<span class="crop"> | <a href="' + ngg_crop.plugin_path + 'ajax/imagecrop.php?pictureID=' + pictureID + '" class="ngg_crop_dialoglink" title="Crop">Crop</a></span>').appendTo(actionrow);
		}
	});
	
	$('form#updategallery').on('click','a.ngg_crop_dialoglink', function() {																							 
		var $thelink = $(this),
			$dialog = $('<div id="ngg_crop_dialog" style="display:none"></div>').appendTo('body');
		
        if($("#spinner").length == 0) {
            $("body").append('<div id="spinner"></div>');
		}

        $('#spinner').fadeIn();
		$('img#cropthis').remove();
		
        // load the remote content
        $dialog.load($thelink.attr('href'), function () {
			$('#spinner').hide();
            $dialog.dialog({
            	title: $thelink.attr('title'),
                width: 'auto',
                height: 'auto',
				position: [100,100],
                modal: true,
                resizable: true,
                close: function() { $dialog.remove(); }
			});
			
			jcropoptions = {
				setSelect	:	[20,20,ngg_crop.crop_width, ngg_crop.crop_height],
				aspectRatio	:	ngg_crop.aspect,
				boxWidth	:	ngg_crop.imagesize,
				minSize		:	[ngg_crop.crop_width, ngg_crop.crop_height],
				onChange	:	nggcrop_preview,
				onSelect	:	nggcrop_preview};
			
			$dialog.find('img#cropthis').one('load', function(e) {
				$(this).Jcrop(jcropoptions);
			});
			
			// Fix bug in jCrop going black on multiple crops
			setTimeout(function() {
				$dialog.find('.jcrop-holder img').show();
			}, 2000);
		});
		
        //prevent the browser to follow the link
        return false;
    });

	// Use preselected crop
	$(document).on('click', '.ngg_crop input#usepreselected', function() {
		// Retrieve the Jcrop object
		var jcropobj = $('img#cropthis').data('Jcrop');
		
		if($(this).is(':checked')) {
			$('.ngg_crop #lockaspect').prop('disabled','disabled');
			$('.ngg_crop #lockaspect').prop('checked',true);
			
			// Set selection size
			jcropobj.setOptions({setSelect	:	[20,20,ngg_crop.crop_width, ngg_crop.crop_height]});
			jcropobj.setOptions({aspectRatio:	ngg_crop.aspect});
		}
		else {		
			$('.ngg_crop #lockaspect').prop('disabled',false);
			$('.ngg_crop #lockaspect').prop('checked',false);
			jcropobj.setOptions({aspectRatio:	null});
		}
		
		// Save the new jcrop options
		$('img#cropthis').data('Jcrop', jcropobj);		
	});

	$(document).on('click', '.ngg_crop input#lockaspect', function(e) {
		var $dom = $(this),
			jcropobj = $('img#cropthis').data('Jcrop');
		
		if($dom.is(':checked')) {
			theselect = jcropobj.tellSelect();
			current_aspect = (theselect.w / theselect.h);
			jcropobj.setOptions({aspectRatio:	current_aspect});
		}
		else {		
			$('.ngg_crop input#lockaspect').prop('disabled',false);
			jcropobj.setOptions({aspectRatio:	null});
		}
		
		// Save the new jcrop options
		$('img#cropthis').data('Jcrop', jcropobj);
	});
	
	$(document).on('click', '.ngg_crop a.thumbnail_review', function(e) {
		var pictureID = $(this).attr('pictureID'),
			$dialog = $('#ngg_crop_dialog');
			
		$dialog.dialog('close');
		
		$('form#updategallery #ngg-listimages tbody tr#picture-' + pictureID + ' .row-actions .custom_thumb a').trigger('click');
		
		return false;
	});	
	
	$(document).on('submit', '.ngg_crop .ngg_crop_form', function(e) {
		var $form = $(this), 
			formurl = $form.attr('action'),
			post = $form.serialize(),
			$pictureID = $form.find('#pictureID'),
			$dialog = $('#ngg_crop_dialog'),
			jcropobj = $('img#cropthis').data('Jcrop'),
			trackerwidth = $('.jcrop-tracker').width();
			
		if($form.find('.spinner').length == 0) {
            $form.find('input[type=submit]').after('<div class="spinner" style="display: inline-block">&nbsp;</div>');
		}

        $form.find('.spinner').show();
			
		$.post(formurl, post, function(response) {			
			if(response) {
				$dialog.prepend('<div class="error">' + response + '</div>');
			}
			else {								   
				// Add success message
				html = '<div class="updated">';
					html += '<p>';
						html += '<b>Image Updated.</b><br>';
						html += 'Please clear your browser cache.<br>';
						html += '<a class="thumbnail_review" href="#" pictureID="' + $pictureID.val() + '">Review your thumbnail</a> to see if it needs cropping as well.';
					html += '</p>';
				html += '</div>';
				$dialog.find('.ngg_crop_data').html(html);
	
				jcropobj.destroy();
								
				// Update the image
				$form.find('img').each(function(index) {
					var oldsrc = $(this).attr('src'),
						srcsplit = oldsrc.split('?'),
						newsrc = srcsplit[0] + '?' + Math.random(0,10000);
						
					$(this).attr('src',newsrc);
					$(this).attr('width',trackerwidth);
				});				
			}
			$form.find('.spinner').remove();
		});	
		
		return false;
	});	

});

// Simple event handler, called from onChange and onSelect
// event handlers, as per the Jcrop invocation above
function nggcrop_preview(c) {
	jQuery('.ngg_crop_form #x1').val(c.x);
	jQuery('.ngg_crop_form #y1').val(c.y);
	jQuery('.ngg_crop_form #x2').val(c.x2);
	jQuery('.ngg_crop_form #y2').val(c.y2);
	jQuery('.ngg_crop_form #cropwidth').val(c.w);
	jQuery('.ngg_crop_form #cropheight').val(c.h);
}