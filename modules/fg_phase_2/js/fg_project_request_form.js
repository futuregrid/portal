(function($) {
	$(document).ready(function() {
		$('#edit-requests-all-approve').bind('change', function() {
			var $this = $(this);
			if ($this.is(':checked')) {
				$('input[id$=approve]').attr('checked','checked');
				$('input[id$=deny]').attr('checked','');
			} else {
				$('input[id$=approve]').attr('checked','');
			}
		});
		
		$('#edit-requests-all-deny').bind('change', function() {
			var $this = $(this);
			if ($this.is(':checked')) {
				$('input[id$=deny]').attr('checked','checked');
				$('input[id$=approve]').attr('checked','');
			} else {
				$('input[id$=deny]').attr('checked','');
			}
		});
		
		$('input[id$=approve]:not(#edit-requests-all-approve)').bind('change',function() {
			var $this = $(this);
			if ($this.is(':checked')) {
				var id = $this.attr('id').replace('approve','deny');
				$('#'+id).attr('checked','');
			}
			$('#edit-requests-all-approve,#edit-requests-all-deny').attr('checked','');
		});
		
		$('input[id$=deny]:not(#edit-requests-all-deny)').bind('change',function() {
			var $this = $(this);
			if ($this.is(':checked')) {
				var id = $this.attr('id').replace('deny','approve');
				$('#'+id).attr('checked','');
			}
			$('#edit-requests-all-approve,#edit-requests-all-deny').attr('checked','');
		});
	});
})(jQuery);