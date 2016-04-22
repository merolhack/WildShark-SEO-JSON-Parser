<?php
define('__ROOT', __DIR__);
define('DS', DIRECTORY_SEPARATOR);
$content = file_get_contents( __ROOT . DS . 'data' . DS . '20160412-SEO-prodecon_gob_mx-Report.json' );
$json_dataset = json_decode( $content,true );

// echo '<pre>' . print_r( array_keys( $json_dataset ), true ) . '</pre>';
// echo '<pre>' . print_r( show_items( $json_dataset['Children'] ), true ) . '</pre>';

function show_items( $dataset ) {
	echo '<ul>';
	foreach($dataset as $key => $value)
	{
		echo '<li><span>' . $value['Title'] . ' - ' . $value['StatusCode'] . ' <a href="'.$value['URL'].'" target="_blank">Ir &raquo;</span></a>';
		if ( isset( $value['Children'] ) && !empty( $value['Children'] ) && is_array( $value['Children'] ) ) {
			show_items( $value['Children'] );
		}
		echo '</li>';
	}
	echo '</ul>';
}

function show_images( $dataset ) {
	echo '<ul>';
	foreach($dataset as $key => $value)
	{
		echo '<li><span><a href="'.$value['URL'].'" target="_blank">' . $value['Alt'] . '</span></a>';
		echo '</li>';
	}
	echo '</ul>';
}

/**
 * Bootstrap tree
 * https://jsfiddle.net/jhfrench/GpdgF/
*/
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>PRODECON - Mapa del sitio</title>

    <!-- Bootstrap -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
	<!-- <link rel="stylesheet" href="assets/vendor/css/bootstrap-treeview.min.css"> -->
	<style>
	.tree {
		min-height:20px;
		padding:19px;
		margin-bottom:20px;
		background-color:#fbfbfb;
		border:1px solid #999;
		-webkit-border-radius:4px;
		-moz-border-radius:4px;
		border-radius:4px;
		-webkit-box-shadow:inset 0 1px 1px rgba(0, 0, 0, 0.05);
		-moz-box-shadow:inset 0 1px 1px rgba(0, 0, 0, 0.05);
		box-shadow:inset 0 1px 1px rgba(0, 0, 0, 0.05)
	}
	.tree li {
		list-style-type:none;
		margin:0;
		padding:10px 5px 0 5px;
		position:relative
	}
	.tree li::before, .tree li::after {
		content:'';
		left:-20px;
		position:absolute;
		right:auto
	}
	.tree li::before {
		border-left:1px solid #999;
		bottom:50px;
		height:100%;
		top:0;
		width:1px
	}
	.tree li::after {
		border-top:1px solid #999;
		height:20px;
		top:25px;
		width:25px
	}
	.tree li span {
		-moz-border-radius:5px;
		-webkit-border-radius:5px;
		border:1px solid #999;
		border-radius:5px;
		display:inline-block;
		padding:3px 8px;
		text-decoration:none
	}
	.tree li.parent_li>span {
		cursor:pointer
	}
	.tree>ul>li::before, .tree>ul>li::after {
		border:0
	}
	.tree li:last-child::before {
		height:30px
	}
	.tree li.parent_li>span:hover, .tree li.parent_li>span:hover+ul li span {
		background:#eee;
		border:1px solid #94a0b4;
		color:#000
	}
	</style>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
	<h2>Páginas</h2>
	<div class="tree well">
		<?php
		echo show_items( $json_dataset['Children'] );
		?>
	</div>
	<h2>Externas</h2>
	<div class="tree well">
		<?php
		echo show_items( $json_dataset['ExternalChildren'] );
		?>
	</div>
	<h2>Imágenes</h2>
	<div class="tree well">
		<?php
		echo show_images( $json_dataset['Images'] );
		?>
	</div>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
	<!-- <script src="assets/vendor/js/bootstrap-treeview.min.js"></script> -->
	<script>
	(function( $ ) {
		$('.tree li:has(ul)').addClass('parent_li').find(' > span').attr('title', 'Collapse this branch');
		$('.tree li.parent_li > span').on('click', function (e) {
			var children = $(this).parent('li.parent_li').find(' > ul > li');
			if (children.is(":visible")) {
				children.hide('fast');
				$(this).attr('title', 'Expand this branch').find(' > i').addClass('icon-plus-sign').removeClass('icon-minus-sign');
			} else {
				children.show('fast');
				$(this).attr('title', 'Collapse this branch').find(' > i').addClass('icon-minus-sign').removeClass('icon-plus-sign');
			}
			e.stopPropagation();
		});
	})(jQuery);
	</script>
</body>
</html>