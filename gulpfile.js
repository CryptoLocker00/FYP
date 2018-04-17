const elixir = require('laravel-elixir');

require('laravel-elixir-vue');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

var paths = {
  'bs3':                './node_modules/bootstrap-sass/assets/',
  'moment':             './node_modules/moment/',
  'bootbox':            './node_modules/bootbox/',
  'datatables':         './node_modules/datatables/media/',
  'datatablesPlugins':  './node_modules/drmonty-datatables-plugins/',
  'select2':            './node_modules/select2/dist/',
  'select2Bs3':         './node_modules/select2-bootstrap-theme/dist/',
  'sortablejs':         './node_modules/sortablejs/',
  'autosize':           './node_modules/autosize/dist/',
  'datepickerbs3':      './node_modules/bootstrap-datepicker/dist/',
};


elixir(mix => {
  mix.sass('app.scss')
    .webpack('app.js')
    .styles([
      paths.select2           + 'css/select2.min.css',
      paths.select2Bs3        + 'select2-bootstrap.min.css',
      paths.datatablesPlugins + 'integration/bootstrap/3/dataTables.bootstrap.css',
      paths.datepickerbs3     + 'css/bootstrap-datepicker3.min.css',
    ])
    .scripts([
      paths.moment            + 'moment.js',
      paths.bs3               + 'javascripts/bootstrap/collapse.js',
      paths.bs3               + 'javascripts/bootstrap/transition.js',
      paths.datepickerbs3     + 'js/bootstrap-datepicker.min.js',
      paths.bootbox           + 'bootbox.js',
      paths.select2           + 'js/select2.min.js',
      paths.datatables        + 'js/jquery.dataTables.min.js',
      paths.datatablesPlugins + 'integration/bootstrap/3/dataTables.bootstrap.min.js',
      paths.sortablejs        + 'Sortable.min.js',
      paths.autosize          + 'autosize.min.js',
    ])
    .copy('node_modules/font-awesome/fonts', 'public/fonts')
    .copy('node_modules/bootstrap-sass/assets/fonts', 'public/fonts');
});
