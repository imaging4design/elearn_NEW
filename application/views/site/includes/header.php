<!DOCTYPE html>
<html>
<head>
	<title><?php echo $site_name; ?></title>
	<meta charset="UTF-8"> 
	<meta name="description" content="Online economics study resource for secondary schools and tertiary training institutes" />
	<meta name="keywords" content="economics 101, economics online, economics help, learn economics, study economics, economics study, economics tutor, economics online course" />

	<!--CSS STYLE SHEETS-->
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800' rel='stylesheet' type='text/css'><!--FONTS CSS-->
	<link href='http://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'><!--FONTS CSS-->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css"><!-- FONT AWESOME CSS -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>css/coda_slider.css" type="text/css" /><!--JQ CODA SLIDER CSS-->
	<link rel="stylesheet" href="<?php echo base_url(); ?>css/charts.css" type="text/css" /><!--MAIN STYLES CSS-->
	<link rel="stylesheet" href="<?php echo base_url(); ?>css/bootstrap.css" type="text/css" /><!--BOOTSTRAP CSS-->
	<link rel="stylesheet" href="<?php echo base_url(); ?>dist/css/styles.css" type="text/css" /><!--MAIN STYLES CSS-->


	<link rel="stylesheet" href="<?php echo base_url(); ?>css/owl.carousel.css"><!--OWL CAROUSEL CSS-->
	<link rel="stylesheet" href="<?php echo base_url(); ?>css/owl.theme.css"><!--OWL CAROUSEL DEFAULT THEME CSS-->


	<!--JS IMPORTS-->
	<script src="//code.jquery.com/jquery-1.11.3.min.js"></script><!--JQUERY 1.7 MAIN PACK JS-->
	<script src="<?php echo base_url() . 'js/charts.js'; ?>" type="text/javascript" ></script>


	<script type="text/javascript" src="<?php echo base_url() . 'js/magnify/jquery.magnifier.js'; ?>"></script><!--JQUERY MAGNIFY JS-->


	<!--<script src="<?php //echo base_url() . 'js/coda_slider/jquery.coda-slider-2.0.js'; ?>"></script> CODA-SLIDER JS -->
	<script src="<?php echo base_url() . 'js/coda_slider/jquery.easing.1.3.js'; ?>"></script><!-- JQUERY-EASING JS -->


	<script src="<?php echo base_url() . 'js/owl.carousel.js'; ?>"></script><!--OWL CAROUSEL JS-->


	<!--jQuery Auto Scroller-->
	<script src="<?php echo base_url() . 'js/jquery.simplyscroll.js'; ?>"></script>
	<link rel="stylesheet" href="<?php echo base_url(); ?>css/jquery.simplyscroll.css" type="text/css" /><!--SIMPLY SCROLL CSS-->



	<!--GOOGLE ANALYTICS-->
	<script type="text/javascript">

	  var _gaq = _gaq || [];
	  _gaq.push(['_setAccount', 'UA-7102098-9']);
	  _gaq.push(['_trackPageview']);

	  (function() {
		var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
		ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
		var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
	  })();

	</script>



</head>
<body id='body'>

	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				
			<?php
				// Create logo image 
				$logo = array(
					'src' => base_url() . 'images/logo_elearn.png',
					'alt' => 'Elearn Economics'
				);
			
				// Set up 'Login / Logout' session variables
				if( $this->session->userdata('logged_in') ==1) {
					$log_status = anchor('main/logout', 'LOGOUT');
					$topics = anchor('section/index', 'TOPICS');
				} elseif( $this->session->userdata('logged_in_admin') ==1) {
					$log_status = anchor('main/logout', 'LOGOUT');
					$topics = anchor('teachers/view_month', 'Teacher');
				} else {
					$log_status = anchor('main/login', 'LOGIN');
					$topics = anchor('section/demo', 'DEMO');
				}
			
				

				// Get $current to compare against $this->uri->segment(2) to see if link is 'active'
				$current = $this->uri->segment(2);

				$home = ( $current == '' || $current == '') ? 'active' : '';
				$about = ( $current == 'aboutUs') ? 'active' : '';
				$topic = ( $current == 'demo' || $current == 'index' || $current == 'login_member_student') ? 'active' : '';
				$blog = ( $current == 'news' || $current == 'news_full') ? 'active' : '';
				$faqs = ( $current == 'faqs') ? 'active' : '';
				$subscribe = ( $current == 'items' || $current == 'individual-student-premium' || $current == 'school_order') ? 'active' : '';
				$contact = ( $current == 'contact') ? 'active' : '';
				$log = ( $current == 'login') ? 'active' : '';
				$user = ( $current == 'view_progress' || $current == 'leaders_school' || $current == 'edit_options') ? 'active' : '';
				
			?>





				<!-- Fixed navbar -->
				<nav class="navbar navbar-default navbar-fixed-top">
					<div class="container">
						<div class="navbar-header">
							<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
								<span class="sr-only">Toggle navigation</span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
							</button>
							<?php echo anchor('', ' ', array('class' => 'navbar-brand hidden-sm')); ?>
						</div>
						<div id="navbar" class="navbar-collapse collapse">
							<ul class="nav navbar-nav">
								<li class="<?php echo $home; ?>"><?php echo anchor('', 'HOME'); ?></li>
								<li class="<?php echo $about; ?>"><?php echo anchor('site/aboutUs', 'ABOUT'); ?></li>
								<li class="<?php echo $topic; ?>"><?php echo $topics; ?></li>
								<li class="<?php echo $faqs; ?>"><?php echo anchor('site/faqs', 'FAQs'); ?></li>
								<?php if( $this->session->userdata('logged_in') != 1) { ?>
									<li class="<?php echo $subscribe; ?>"><?php echo anchor('paypal/items', 'SUBSCRIBE'); ?></li>
								<?php } ?>
								<li class="<?php echo $blog; ?>"><?php echo anchor('site/news', 'BLOG'); ?></li>
								<li class="<?php echo $contact; ?>"><?php echo anchor('site/contact', 'CONTACT'); ?></li>
								<li class="dropdown <?php echo $user; ?>">
								<?php if( $this->session->userdata('logged_in') == 1) { ?>
									<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">OPTIONS <span class="caret"></span></a>
										<ul class="dropdown-menu">
											<li><?php echo anchor('results/view_progress', 'View Progress'); ?></li>
											<li><?php echo anchor('results/leaders_school', 'Leader Board'); ?></li>
											<li><?php echo anchor('section/edit_options', 'My Options'); ?></li>
										</ul>
									</li>
								<?php } ?>
								<li class="<?php echo $log; ?>"><?php echo $log_status; ?></li>
							</ul>
						</div><!--/.nav-collapse -->
					</div>
				</nav>



			</div><!--ENDS col-->
		</div><!--ENDS row-->
	</div><!--ENDS container-->


	
