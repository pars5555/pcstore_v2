<header class="header-wrapper">
	<div class="header-content row">
		<div class="logo col-md-4">
			<a href="{$SITE_PATH}" class="navbar-brand">
                PC STORE
            </a>
		</div>
		<div class="col-md-8">
			<ul class="top-menu-profile  pull-right">
				<li class="col-md-6">
					<a href="#">
						{$ns.customer->getName()} {$ns.customer->getLastName()}
						<i class="glyphicon glyphicon-user"></i>
					</a>
				</li>
				<li class="col-md-6">
					<a href="#">
						<span class="notif-quantity"></span>
						<i class="glyphicon glyphicon-bell"></i>
					</a>
				</li>
			</ul>
		</div>
	</div>
</header>