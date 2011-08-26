<?php print drupal_render($form); ?>
<script>
	(function($) {
		function checkEmail(field) {
			var $field = $(field);
			var $wrapper = $field.parent();
			var entry = $field.val();
			if (matches = entry.match(/^.*@(gmail|yahoo|hotmail).com$/)) {
				var wmsg;
				if ($('.messages.warning', $wrapper).length == 0) {
					wmsg = $('<div>').attr('id', 'edit-mail-warn').addClass('messages warning');
					wmsg.hide().appendTo($wrapper);
					wmsg.text('Please use your e-mail from your university or organization.  Using a non-organizational e-mail (such as ' + matches[1] + ') may lead to a delay or in some cases to a rejection of the account request.');
				} else {
					wmsg = $('.messages.warning', $wrapper);
				}
				wmsg.text('Please use your e-mail from your university or organization.  Using a non-organizational e-mail (such as ' + matches[1] + ') may lead to a delay or in some cases to a rejection of the account request.');
				if (! wmsg.is(":visible")) {
					wmsg.fadeIn();
				}
			} else {
				$('.messages.warning', $wrapper).fadeOut();
			}
		}
		$(document).ready(function() {
			$('#edit-mail,#edit-profile-email').bind('blur', function() {
				checkEmail(this);
			});
			$('#edit-mail,#edit-profile-email').trigger('blur');
			
			$('#edit-submit').bind('click', function() {
				var email1 = $('#edit-mail').val(),
						email2 = $('#edit-profile-email').val();
				
				if (email1 != email2) {
					alert('The email addresses provided do not match!  Please check your entry before submitting again.');
					$('body,html').animate({"scrollTop":$('#edit-mail').parent().parent().offset().top}, 500);
					$('#edit-mail').focus();
					return false;
				}
			});
		});
	})(jQuery);
</script>