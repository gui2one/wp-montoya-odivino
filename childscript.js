jQuery(function ($) {
  $(document).ajaxSuccess(function () {
    if (typeof window.vc_js === "function") {
      console.log("AJAX SUCCESS !!!");
      window.vc_js();
    }
  });
});

console.log("childscript.js loaded");
