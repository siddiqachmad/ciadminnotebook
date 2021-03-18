<!DOCTYPE html>
<html lang="en" class="app">
<head>
	<?php $this->load->view('component/head') ?>
</head>
<body>
<section class="vbox">
	<?php
		$this->load->view('component/header');
	?>
	<section>
		<section class="hbox stretch">
			<!-- .aside -->
			<?php
				$this->load->view('component/sidebar');
			?>
			<!-- /.aside -->

			<section id="content">
				<?php
					$this->load->view($view);
				?>
			</section>

			<aside class="bg-light lter b-l aside-md hide" id="notes">
				<div class="wrapper">Notification</div>
			</aside>
		</section>
	</section>
</section>
<?php
	$this->load->view('component/footjs');
?>

</body>
</html>
