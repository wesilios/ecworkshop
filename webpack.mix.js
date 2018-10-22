let mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/assets/js/app.js', 'public/js')
   .sass('resources/assets/sass/app.scss', 'public/css');

// Main site styles and scripts
mix.styles ([

    'resources/assets/mainsite/slick/slick.css',
    'resources/assets/mainsite/slick/slick-theme.css',
    'resources/assets/mainsite/css/style.css'


], 'public/css/mainsite/libs.css');

mix.scripts ([

    'resources/assets/mainsite/slick/slick.min.js',
    'resources/assets/mainsite/js/button.js'

], 'public/js/mainsite/libs.js');


// Admin login styles and scripts
mix.styles ([

	'resources/assets/admin/bootstrap/css/bootstrap.min.css',
	'resources/assets/admin/dist/css/AdminLTE.min.css',
	'resources/assets/admin/plugins/iCheck/square/blue.css'

], 'public/css/admin/login.css');

mix.scripts ([

	'resources/assets/admin/plugins/jQuery/jQuery-2.1.4.min.js',
	'resources/assets/admin/bootstrap/js/bootstrap.min.js',
	'resources/assets/admin/plugins/iCheck/icheck.min.js'

], 'public/js/admin/login.js');



// Admin styles and scripts
mix.styles ([

	'resources/assets/admin/bootstrap/css/boostrap.min.css',
	'resources/assets/admin/dist/css/skins/_all-skins.min.css',
	'resources/assets/admin/plugins/morris/morris.css',
	'resources/assets/admin/plugins/jvectormap/jquery-jvectormap-1.2.2.css',
    'resources/assets/admin/plugins/daterangepicker/daterangepicker-bs3.css',
	'resources/assets/admin/plugins/datepicker/datepicker3.css',
	'resources/assets/admin/plugins/select2/select2.css',
    'resources/assets/admin/plugins/iCheck/all.css',
    'resources/assets/admin/dist/css/AdminLTE.css',
    'resources/assets/admin/plugins/tagsinput/bootstrap-tagsinput.css'

], 'public/css/admin/libs.css');

mix.scripts([

	'resources/assets/admin/plugins/jQuery/jQuery-2.1.4.min.js',
	'resources/assets/admin/plugins/jQueryUI/jquery-ui.min-confict.js',
    'resources/assets/admin/bootstrap/js/bootstrap.min.js',
    'resources/assets/admin/plugins/datatables/jquery.dataTables.min.js',
    'resources/assets/admin/plugins/datatables/dataTables.bootstrap.min.js',
    'resources/assets/admin/plugins/morris/raphael-min.js',
    'resources/assets/admin/plugins/morris/morris.min.js',
    'resources/assets/admin/plugins/sparkline/jquery.sparkline.min.js',
    'resources/assets/admin/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js',
    'resources/assets/admin/plugins/jvectormap/jquery-jvectormap-world-mill-en.js',
    'resources/assets/admin/plugins/knob/jquery.knob.js',
    'resources/assets/admin/plugins/daterangepicker/moment.min.js',
    'resources/assets/admin/plugins/daterangepicker/daterangepicker.js',
    'resources/assets/admin/plugins/datepicker/bootstrap-datepicker.js',
    'resources/assets/admin/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js',
    'resources/assets/admin/plugins/slimScroll/jquery.slimscroll.min.js',
    'resources/assets/admin/plugins/select2/select2.full.min.js',
    'resources/assets/admin/plugins/iCheck/icheck.min.js',
    'resources/assets/admin/plugins/fastclick/fastclick.min.js',
    'resources/assets/admin/dist/js/app.min.js',
    'resources/assets/admin/dist/js/demo.js'

], 'public/js/admin/libs.js');