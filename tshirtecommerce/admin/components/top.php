<!-- start: HEADER -->
<div class="navbar navbar-inverse">
	<!-- start: TOP NAVIGATION CONTAINER -->
	<div class="container">
		<div class="navbar-header">
			<!-- start: RESPONSIVE MENU TOGGLER -->
			<button data-target=".navbar-collapse" data-toggle="collapse" class="navbar-toggle" type="button">
				<span class="clip-list-2"></span>
			</button>
			<!-- end: RESPONSIVE MENU TOGGLER -->
			
			<!-- start: LOGO -->
			<a class="navbar-brand" href="<?php echo site_url_ci();?>">
				<img src="<?php echo site_url_ci('assets/images/logo.png'); ?>" alt="http://tshirtecommerce.com" />
			</a>
			<!-- end: LOGO -->
		</div>
		
		<div class="navbar-tools">
			<ul class="nav navbar-right">						
				<li class="dropdown">
					<a data-toggle="dropdown" class="dropdown-toggle" href="#">
						<i class="fa fa-life-ring fa-lg"></i>						
					</a>
					<ul class="dropdown-menu todo">						
						<li>
							<a href="http://tshirtecommerce.com" target="_blank">
								<i class="fa fa-home"></i> 
								<span>Homepage</span>
							</a>									
						</li>
						<li>
							<a href="http://store.9file.net" target="_blank">
								<i class="fa fa-heart"></i> 
								<span>Clipart Store</span>
							</a>									
						</li>
						<li>
							<a href="http://tshirtecommerce.com/add-ons" target="_blank">
								<i class="fa fa-puzzle-piece"></i> 
								<span>Add-Ons</span>
							</a>									
						</li>
						<li>
							<a href="http://docs.tshirtecommerce.com" target="_blank">
								<i class="fa fa-book"></i> 
								<span>Documentation</span>
							</a>									
						</li>
					</ul>
				</li>				
			
				<!-- start: USER DROPDOWN -->
				<li class="current-user">
					<a href="<?php echo site_url_ci('index.php/user/logout'); ?>">
						<?php lang('logout'); ?> &nbsp;<i class="clip-exit"></i>
					</a>
				</li>
				<!-- end: USER DROPDOWN -->
			</ul>
			<!-- end: TOP NAVIGATION MENU -->
		</div>
	</div>
	<!-- end: TOP NAVIGATION CONTAINER -->
</div>
<!-- end: HEADER -->