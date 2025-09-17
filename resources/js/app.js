import smartmenus from 'smartmenus';
import { tns } from 'tiny-slider/src/tiny-slider';
import toastr from 'toastr';

import './jquery/jquery';
import './ajaxsetup/ajaxsetup';
import './tripsearch/tripsearch';
import './emailsubscribe/emailsubscribe';
import axios from 'axios';

import debounce from "lodash.debounce";
window._ = { debounce };
window.tns = tns;
window.axios = axios;

window.$.smartmenus = smartmenus;
$('#main-nav').smartmenus({
  subMenusSubOffsetY: -1,
  subMenusMinWidth: '0',
  subMenusMaxWidth: 'fit-content',
});

toastr.options = {
  "closeButton": false,
  "debug": false,
  "newestOnTop": false,
  "progressBar": false,
  "positionClass": "toast-top-right",
  "preventDuplicates": false,
  "onclick": null,
  "showDuration": "300",
  "hideDuration": "1000",
  "timeOut": "3000",
  "extendedTimeOut": "1000",
  "showEasing": "swing",
  "hideEasing": "linear",
  "showMethod": "slideDown",
  "hideMethod": "slideUp"
};