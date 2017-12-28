<!-- alerts -->
@if (Session::has('alert'))

	<div class="content-alerts">

		<div class="container">

			<!-- alert info -->
			@if (Session::has('alert.info'))
				<div class="alert alert-info alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					{{ Session::get('alert.info') }}
				</div>
			@endif
			<!-- /alert info -->

			<!-- alert success -->
			@if (Session::has('alert.success'))
				<div class="alert alert-success alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					{{ Session::get('alert.success') }}
				</div>
			@endif
			<!-- /alert success -->

			<!-- alert warning -->
			@if (Session::has('alert.warning'))
				<div class="alert alert-warning alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					{{ Session::get('alert.warning') }}
				</div>
			@endif
			<!-- /alert warning -->

			<!-- alert danger -->
			@if (Session::has('alert.danger'))
				<div class="alert alert-danger alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					{{ Session::get('alert.danger') }}
				</div>
			@endif
			<!-- /alert danger -->
		</div>
	</div>
@endif
<!-- /alerts -->