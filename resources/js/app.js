// JQuery
import $ from "jquery";
window.$ = window.jQuery = $;

// Bootstrap
require("bootstrap");

// AdminLTE
require("admin-lte");

// RUT.js
const { format } = require("rut.js");
window.format = format;

// Select2
require("admin-lte/plugins/select2/js/select2");

// DataTables
require("admin-lte/plugins/datatables-bs4/js/dataTables.bootstrap4");
require("admin-lte/plugins/datatables-responsive/js/responsive.bootstrap4");
require("admin-lte/plugins/datatables-rowgroup/js/rowGroup.bootstrap4");

// SweetAlert2
const Swal = require("admin-lte/plugins/sweetalert2/sweetalert2");
window.Swal = Swal;

// momentjs
const moment = require("moment");
window.moment = moment;

// datepicker
const gijgo = require("gijgo/js/gijgo");
window.datepicker = gijgo;

// fileinput
require("bootstrap-fileinput/js/fileinput");

// flaser
const flasher = require("@flasher/flasher/dist/flasher");
window.flasher = flasher;

// ckeditor
window.ClassicEditor = require("@ckeditor/ckeditor5-build-classic/build/ckeditor");

// clipboard.js
window.ClipboardJS = require("clipboard");
