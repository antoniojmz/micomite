	var myLayout;
	$(document).ready(function () {
		myLayout = $('body').layout({
			closable:					true	// pane can open & close
		,	resizable:					true	// when open, pane can be resized
		,	slidable:					true	// when closed, pane can 'slide' open over other panes - closes on mouse-out
		,	livePaneResizing:			true
		,	north__slidable:			false
		,	north__resizable:			false
		,	north__closable:			false
		,	north__spacing_closed:		20
		,	north__minSize:				65
		,	south__slidable:			false
		,	south__resizable:			false
		,	south__closable:			true
		,	west__slidable:				false
		,	west__resizable:			false
		,	west__closable:				false
		,	west__minSize:				85
		,	west__size:					240
		,	west__maxSize:				240
		,	west__animatePaneSizing:	false
		,	west__fxSpeed_size:			"fast"
		,	west__fxSpeed_open:			1000
		,	west__fxSettings_open:		{ easing: "easeOutBounce" }
		,	west__fxName_close:			"none"
		,	west__showOverflowOnHover:	false
		,	east__size:					300
		,	east__minSize:				200
		,	east__maxSize:				.5
		,	east__slidable:				false
		,	east__resizable:			false
		,	east__closable:				true
		,	east__initClosed:			true
		,	center__minWidth:			100
		,	stateManagement__enabled:	false
		,	showDebugMessages:			true
		});
		$.layout.disableTextSelection = function(){
			var $d	= $(document)
			,	s	= 'textSelectionDisabled'
			,	x	= 'textSelectionInitialized'
			;
			if ($.fn.disableSelection) {
				if (!$d.data(x))
					$d.on('mouseup', $.layout.enableTextSelection ).data(x, true);
				if (!$d.data(s))
					$d.disableSelection().data(s, true);
			}
		};
		$.layout.enableTextSelection = function(){
			var $d	= $(document)
			,	s	= 'textSelectionDisabled';
			if ($.fn.enableSelection && $d.data(s))
				$d.enableSelection().data(s, false);
		};
 	});